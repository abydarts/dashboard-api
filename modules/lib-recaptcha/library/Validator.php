<?php
/**
 * Validator
 * @package lib-recaptcha
 * @version 0.0.1
 */

namespace LibRecaptcha\Library;

use LibCurl\Library\Curl;

class Validator
{

    static function validate(string $token): ?object {
        $body = [
            'secret'    => \Mim::$app->config->libRecaptcha->sitesecret,
            'response'  => $token,
            'remoteip'  => \Mim::$app->req->getIP()
        ];

        $opts = [
            'url'       => 'https://www.google.com/recaptcha/api/siteverify',
            'method'    => 'POST',
            'headers'   => [
                'Accept'    => 'application/json'
            ],
            'body'      => $body,
            'agent'     => 'lib-recaptcha v0.0.1'
        ];

        $result = Curl::fetch($opts);
        if(!$result || !$result->success)
            return null;
        if($result->score < .5)
            return null;

        return $result;
    }
}