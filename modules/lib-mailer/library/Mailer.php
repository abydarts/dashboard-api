<?php
/**
 * Mailer
 * @package lib-mailer
 * @version 0.0.1
 */

namespace LibMailer\Library;

use LibView\Library\View;
use PHPMailer\PHPMailer\{
    PHPMailer,
    Exception
};

class Mailer
{

    private static $error;

    private static function applyParams(string $text, array $params): string{
        foreach($params as $key => $val)
            $text = str_replace('(:' . $key . ')', $val, $text);
        return $text;
    }

    private static function buildParams($params, string $parent=''): array{
        $result = [];

        foreach($params as $par => $val){
            if(is_array($val) || is_object($val)){
                $res = self::buildParams($val, $parent . $par . '.');
                $result = array_merge($result, $res);
            }else{
                $result[$parent.$par] = $val;
            }
        }

        return $result;
    }

    static function send(array $options): bool{
        $recipients = $options['to'];
        $config = \Mim::$app->config->libMailer;
        $direct_set_conf = [
            'Host',
            'SMTPAuth',
            'Username',
            'Password',
            'SMTPSecure',
            'Port'
        ];

        self::$error = null;

        $additiona_params = $options['view']['params'] ?? [];
        $params = $additiona_params ? self::buildParams($additiona_params) : [];

        foreach($recipients as $recipient){
            try{
                $mail = new PHPMailer(true);

                // $mail->SMTPDebug = 2;

                if($config->SMTP)
                    $mail->isSMTP();
                
                foreach($direct_set_conf as $val){
                    if(isset($config->$val))
                        $mail->$val = $config->$val;
                }

                if(isset($options['from'])){
                    $mail->setFrom($options['from']['email'], $options['from']['name']);
                } else {
                    $mail->setFrom($config->FromEmail, $config->FromName);
                }

                $mail->addAddress($recipient['email'], $recipient['name']);

                if(isset($recipient['cc'])){
                    foreach($recipient['cc'] as $cc)
                        $mail->addCC($cc['email'], $cc['name']);
                }

                if(isset($recipient['bcc'])){
                    foreach($recipient['bcc'] as $bcc)
                        $mail->addCC($bcc['email'], $bcc['name']);
                }

                if(isset($options['attachment'])){
                    foreach($options['attachment'] as $att)
                        $mail->addAttachment($att['file'], $att['name']);
                }
                
                $params['to.name']  = $recipient['name'];
                $params['to.email'] = $recipient['email'];

                $mail->Subject = self::applyParams($options['subject'], $params);

                if(isset($options['text'])){
                    $alt_body = self::applyParams($options['text'], $params);
                    $mail->Body = $mail->AltBody = $alt_body;
                }

                if(isset($options['view'])){
                    $view = $options['view'];
                    $view_params = $view['params'] ?? [];
                    $view_params['to'] = $recipient;
                    $mail->isHTML(true);
                    $mail->Body = View::render($view['path'], $view_params, 'mailer');
                }

                $mail->send();

            }catch(Exception $e){
                self::$error = $mail->ErrorInfo;

            }
        }

        return !self::$error;
    }

    static function getError(): ?string{
        return self::$error;
    }
}