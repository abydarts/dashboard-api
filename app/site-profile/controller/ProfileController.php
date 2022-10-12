<?php
/**
 * ProfileController
 * @package site-profile
 * @version 0.0.1
 */

namespace SiteProfile\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use Post\Model\Post;
use PostCategory\Model\PostCategoryChain as PCChain;
use SiteProfile\Library\Meta;
use LibFormatter\Library\Formatter;

class ProfileController extends \Site\Controller
{

    public function singleAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if(!$this->profile->isLogin())
            return $this->res->redirect($next);

        $params = [
            'meta'      => Meta::single($this->profile)
        ];

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/matches?status=live&date='.date('Y-m-d'),
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $params['live_matches'] = $result->data;


        $this->res->render('profile/live-match', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function addressAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if(!$this->profile->isLogin())
            return $this->res->redirect($next);

        $params = [
            'meta'      => Meta::single($this->profile)
        ];

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/address',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        $params['address'] = $result->data;

        $form = new Form('site.profile.address');
        $params['form'] = $form;
        if (!$valid = $form->validate()) {
            $this->res->render('profile/address', $params);
            $this->res->setCache(86400);
            $this->res->send();
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/address',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'name' => $valid->name,
                'address' => $valid->address,
                'state' => $valid->state,
                'state' => $valid->state,
                'postal_code' => $valid->postal_code,
                'phone' => $valid->phone,
                'map_address' => "",
            ]
        ]);

        if ($result->success) {
            return $this->res->redirect($this->router->to('siteProfileAddress'));
        }

        $params['error'] = $result->message ?? 'Something went wrong';
        $this->res->render('profile/address', $params);
        return $this->res->send();




    }

    public function newsUpdateAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if(!$this->profile->isLogin())
            return $this->res->redirect($next);

        $params = [
            'meta'      => Meta::single($this->profile)
        ];

        // get latest post
        $cond = [
            'post.status'   => 3,
        ];
        list($page, $rpp) = $this->req->getPager(5);

        $pchains = PCChain::get($cond, $rpp, $page, ['created'=>false]);
        if($pchains){
            $post_ids = array_column($pchains, 'post');
            $posts = Post::get(['id'=>$post_ids], 0, 1, ['created'=>false]);
            $posts = Formatter::formatMany('post', $posts, ['user', 'content', 'category']);
        }
        $params['posts'] = $posts ?? [];


        $this->res->render('profile/news-update', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function editAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if(!$this->profile->isLogin())
            return $this->res->redirect($next);

        $params = [
            'meta'      => Meta::single($this->profile)
        ];

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/me',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        $params['edit'] = $result->data;

        $form = new Form('site.profile.edit');
        $params['form'] = $form;

        if (!$valid = $form->validate()) {
            $this->res->render('profile/edit', $params);
            $this->res->setCache(86400);
            $this->res->send();
        }

        if($valid->confirmpassword != $valid->password){
            $params['error'] = $result->message ?? 'Password confirmation must match re-Password';
            $this->res->render('profile/edit', $params);
            return $this->res->send();
        }
        
        $fetch = [
            'url' => $this->config->app->api->host.'/api/profile',
            'method' => 'PUT',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'name' => $valid->name,
                'avatar' => $valid->avatar,
                'email' => $valid->email,
                'phone' => $valid->phone,
            ]
        ];

        if($valid->password) $fetch['body']['password'] = $valid->password;

        $result = Curl::fetch($fetch);

        if ($result->success) {
            return $this->res->redirect($this->router->to('siteProfileEdit'));
        }

        $params['error'] = $result->message ?? 'Something went wrong';
        $this->res->render('profile/edit', $params);
        return $this->res->send();
    }

    public function uploadAction(){
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteHome');

        if(!$this->profile->isLogin())
            return $this->res->redirect($next);

        $file = $this->req->get('files');
        if($file) {
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/img-upload',
                'method' => 'POST',
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                    'Authorization' => $this->profile->getSession()->hash,
                ],
                'body' => [
                    'file' => new \CURLFile($file['tmp_name'], $file['type'], $file['name'])
                ]
            ]);
        
            if ($result->success) {
                echo json_encode($result);
            }
        }
    }
}