<?php
/**
 * SignupController
 * @package site-profile-signup
 * @version 0.0.1
 */

namespace SiteProfileSignup\Controller;

use Profile\Model\Profile;

use LibForm\Library\Form;
use ProfileAuth\Model\ProfileSession as PSession;
use SiteProfileLogin\Library\Meta;
use LibCurl\Library\Curl;
use LibMailer\Library\Mailer;

class SignupController extends \Site\Controller
{
    public function registerAction(){
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if($this->profile->isLogin())
            return $this->res->redirect($next);

        $form = new Form('site.profile.signup');

        $params = [
            'error' => false,
            'form'  => $form,
            'meta' => Meta::single((object)[
                'title' => 'Register',
                'description' => 'Profile register page'
            ])
        ];

        if(!($valid = $form->validate())){
            $this->res->render('profile/auth/signup', $params);
            return $this->res->send();
        }

        if ($valid->password != $valid->confirm_password) {
            $form->addError('confirm_password', 'password', 'Konfirmasi password tidak sesuai!');
            $params['form'] = $form;
            $this->res->render('profile/auth/signup', $params);
            return $this->res->send();
        }

        // send email to ifel support
//        $options = [
//            'to' => [
//                [
//                    'name' => $this->config->name,
//                    'email' => $this->setting->contact_email,
//                ],
//            ],
//            'subject' => 'IFeL User Registration',
//            'text' => '/User Daftar/',
////            'view' => [
////                'path' => 'path/to/view',
////                'params' => [
////                    'additional' => 'data',
////                    'to' => 'forward to',
////                    'view' => 'renderer'
////                ]
////            ]
//        ];
//        if(!Mailer::send($options))
//            die(Mailer::getError());
//        die();

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/register',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => [
                "name" => $valid->name,
                "email" => $valid->email,
                "phone" => $valid->phone,
                "birthdate" => $valid->birthdate,
                "password" => $valid->password,
                "password_confirmation" => $valid->confirm_password,
            ],
        ]);
        if(!$result || (isset($result->success) && $result->success == false)) {
            $params['error'] = true;
            if(isset($result->message))  $params['error_message'] = $result->message;
            if ($result->data) {
                $form = new Form('site.profile.signup', $result->data);
                $form->addErrors($result->data);
                $params['form'] = $form;

            }
            $this->res->render('profile/auth/signup', $params);
            return $this->res->send();
        }
        $access_token = $result->token_type . ' '.$result->access_token;




        $profile = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/me',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $access_token
            ],
        ]);
        if(!$result || (isset($result->success) && $result->success == false)) {
            $params['error'] = true;
            $params['error_message'] = $profile->message;
            $this->res->render('profile/auth/login', $params);
            return $this->res->send();
        }

        $session = [
            'profile' => $profile->data->id,
            'hash'    => $access_token,
            'expires' => date('Y-m-d H:i:s', strtotime('now') + $result->expires_in - 60 - 60)
        ];

        PSession::create($session);

        $config         = \Mim::$app->config->profileAuth;
        $cookie_name    = $config->cookie->name;
        $cookie_expires = $result->expires_in - 60;
        if(!$this->req->getPost('remember'))
            $cookie_expires = 0;

        $this->res->addCookie($cookie_name, $session['hash'], $cookie_expires);

        $this->res->redirect($this->router->to('siteHome'));
    }
}