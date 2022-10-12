<?php
/**
 * AuthController
 * @package site-profile-login
 * @version 0.0.1
 */

namespace SiteProfileLogin\Controller;

use Banner\Model\Banner;
use ProfileAuth\Model\ProfileSession as PSession;
use Profile\Model\Profile;

use LibForm\Library\Form;
use SiteProfileLogin\Library\Meta;
use LibCurl\Library\Curl;

class AuthController extends \Site\Controller
{
	public function logoutAction(){
        $session = $this->profile->getSession();
        if($session){
        	PSession::remove(['id'=>$session->id]);

        	$config = $this->config->profileAuth;
        	$cookie_name = $config->cookie->name;
        	$this->res->addCookie($cookie_name, '', -1000);
        }

        $next = $this->router->to('siteHome');
        $this->res->redirect($next);
    }

    public function loginAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if($this->profile->isLogin())
            return $this->res->redirect($next);

        $form = new Form('site.profile.login');

        $params = [
            'error' => false,
            'form'  => $form,
            'meta' => Meta::single((object)[
            	'title' => 'Login',
            	'description' => 'Profile login page'
            ])
        ];

        if(!($valid = $form->validate())){
            $this->res->render('profile/auth/login', $params);
            return $this->res->send();
        }

        // get token
        $opts = [
            'url' => $this->config->app->api->host.'/api/auth',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => [
                'email' => $valid->email,
                'password' => $valid->password,
            ],
        ];
        $result = Curl::fetch($opts);
        if(!$result || (isset($result->success) && $result->success == false)) {
            $params['error'] = true;
            $params['error_message'] = $result->message;
            if (isset($result->data)) {
                $form = new Form('site.profile.login', $result->data);
                $form->addErrors($result->data);
                $params['form'] = $form;
            }
            $this->res->render('profile/auth/login', $params);
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
        if(!$profile || (isset($profile->success) && $profile->success == false)) {
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
        
        if(!PSession::create($session))
            deb(PSession::lastError());

        $config         = \Mim::$app->config->profileAuth;
        $cookie_name    = $config->cookie->name;
        $cookie_expires = $result->expires_in - 60;
        if(!$this->req->getPost('remember'))
        	$cookie_expires = 0;

        $this->res->addCookie($cookie_name, $session['hash'], $cookie_expires);

        $this->res->redirect($this->router->to('siteHome'));
    }
}