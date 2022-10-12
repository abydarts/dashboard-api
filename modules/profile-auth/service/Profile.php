<?php
/**
 * Profile
 * @package profile-auth
 * @version 0.0.1
 */

namespace ProfileAuth\Service;

use LibCurl\Library\Curl;
use ProfileAuth\Model\ProfileSession as PSession;
use Profile\Model\Profile as _Profile;

class Profile extends \Mim\Service
{
	private $session;
	private $profile;

	public function __construct(){
		$config = \Mim::$app->config->profileAuth;
		$cookie_name = $config->cookie->name;

		// by cookie
		$hash = \Mim::$app->req->getCookie($cookie_name);
		
		// by header
		if(!$hash)
			$hash = \Mim::$app->req->getServer('HTTP_AUTHORIZATION');
		
		if(!$hash)
			return;

		$hash = strtolower($hash);

		$session = PSession::getOne(['hash'=>$hash]);
		if($session){
			$expires = strtotime($session->expires);

			if($expires < time()){
				PSession::remove(['id'=>$session->id]);
			}else{
                $profile = Curl::fetch([
                    'url' => \Mim::$app->config->app->api->host.'/api/me',
                    'method' => 'GET',
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => $session->hash
                    ],
                ]);
                if(!$profile || (isset($profile->success) && $profile->success == false)) {
                    $params['error'] = true;
                    $params['error_message'] = $profile->message;
                    $this->res->render('profile/auth/login', $params);
                    return $this->res->send();
                }

				if($profile){
					$this->profile = $profile->data;
					$this->session = $session;
				}
			}
		}
	}

	public function isLogin(): bool{
		return !!$this->profile;
	}

	public function getAuthorizer(): ?string{
		if($this->profile)
			return 'ProfileAuth\\Library\\Authorizer';
		return null;
	}

	public function getSession(): ?object{
		return $this->session;
	}

	public function getProfile(): ?object{
		return $this->profile;
	}

	public function getCoinBalance(): ?int{
        $result = Curl::fetch([
            'url' => \Mim::$app->config->app->api->host.'/api/coin/balance',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->session->hash,
            ]
        ]);
        if ($result->success) {
            return  $result->data->coin;
        } return 0;
	}

	public function __get(string $name){
		if(!$this->profile)
			return null;
		return ($this->profile->$name ?? null);
	}
}