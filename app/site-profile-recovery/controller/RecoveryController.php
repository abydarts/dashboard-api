<?php
/**
 * RecoveryController
 * @package site-profile-recovery
 * @version 0.0.1
 */

namespace SiteProfileRecovery\Controller;

use LibCurl\Library\Curl;
use SiteProfileRecovery\Library\Meta;
use LibForm\Library\Form;
use SiteProfileRecovery\Model\ProfileRecovery as PRecovery;
use Profile\Model\Profile;

class RecoveryController extends \Site\Controller
{
	public function recoveryAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if($this->profile->isLogin())
            return $this->res->redirect($next);

        $form = new Form('site.profile.recovery');

        $params = [
            '_meta' => [
                'title' => 'Recovery Account'
            ],
            'form'  => $form,
            'meta'  => Meta::recovery(),
            'error' => []
        ];

        if(!($valid = $form->validate()) || !$form->csrfTest('noob')){
            $this->resp('profile/recovery/recovery', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/forgot-password',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => [
                'email' => $valid->identity,
            ]
        ]);

        if(!$result || (isset($result->success) && $result->success == false)) {
            $params['error'] = true;
            $params['error_message'] = $result->message ?? 'Something went wrong';
            $this->resp('profile/recovery/recovery', $params);
        }

        // create recovery object
//        $verif = [
//            'profile' => $profile->id,
//            'expires' => date('Y-m-d H:i:s', strtotime('+2 hour')),
//            'hash'    => ''
//        ];
//
//        while(true){
//            $verif['hash'] = md5(time() . '-' . uniqid() . '-' . $profile->id);
//            if(!PRecovery::getOne(['hash'=>$verif['hash']]))
//                break;
//        }
//        PRecovery::create($verif);
//
//        $params['reset_url'] = $this->router->to('siteProfileRecoveryReset', ['hash'=>$verif['hash']], ['next'=>$next]);

        $this->resp('profile/recovery/recovery-success', $params);
    }

    public function resentAction(){
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if($this->profile->isLogin())
            return $this->res->redirect($next);

        $profile_id = $this->req->param->profile;
        $recover_id = $this->req->param->recover;

        $profile = Profile::getOne(['id'=>$profile_id]);
        if(!$profile)
            return $this->show404();
        $recover = PRecovery::getOne(['id'=>$recover_id, 'profile'=>$profile_id]);
        if(!$recover)
            return $this->show404();

        $params = [
            '_meta' => [
                'title' => 'Recovery Account'
            ],
            'meta'    => Meta::recovery(),
            'next'    => $next,
            'profile' => $profile,
            'recover' => $recover
        ];

        $params['reset_url'] = $this->router->to('siteProfileRecoveryReset', ['hash'=>$recover->hash], ['next'=>$next]);

        $this->res->render('profile/recovery/recovery-success', $params);
        return $this->res->send();
    }

    public function resetAction(){
    	$next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if($this->profile->isLogin())
            return $this->res->redirect($next);

        $hash = $this->req->param->hash;
//        $recovery = PRecovery::getOne(['hash'=>$hash]);
//        if(!$recovery)
//        	return $this->show404();

        $form = new Form('site.profile.reset');

        $params = [
            '_meta' => [
                'title' => 'Reset Password Account'
            ],
            'form'   => $form,
            'meta'   => Meta::reset(),
            'errors' => [],
            'error'=> false,
        ];

        if(!($valid = $form->validate()) || !$form->csrfTest('noob')){
            $params['errors'] = $form->getErrors();
            $this->resp('profile/recovery/reset', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/reset-password',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => [
                'token' => $hash,
                'email' => $this->req->getQuery('email'),
                'password' => $valid->password,
                'password_confirmation' => $valid->password,
            ]
        ]);

        if(!$result || (isset($result->success) && $result->success == false)) {
            $params['error'] = true;
            $params['error_message'] = $result->message ?? 'Something went wrong';
            $this->resp('profile/recovery/reset', $params);
        }

        $this->resp('profile/recovery/reset-success', $params);
    }
}