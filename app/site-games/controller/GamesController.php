<?php
/**
 * GamesController
 * @package site-post
 * @version 0.0.1
 */

namespace SiteGames\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use LibFormatter\Library\Formatter;
use SiteGames\Library\Meta;
use Slideshow\Model\Slideshow;

class GamesController extends \Site\Controller
{
    public function indexAction() {
        // $next = $this->req->getQuery('next');
        // if(!$next)
        //     $next = $this->router->to('siteHome');

        // if(!$this->profile->isLogin())
        //     return $this->res->redirect($next);

        $list = Curl::fetch([
            'url' => $this->config->app->games->host.'/api/getGame',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $params = [
            'games' => $list->data,
            'meta' => Meta::single($this->profile),
        ];

        $this->resp('game/index', $params);
    }

    public function redirectAction() {
        $next = $this->req->getQuery('next');
        if(!$next)
            $next = $this->router->to('siteProfileLogin');

        if(!$this->profile->isLogin()) echo $next;
        else{
            $params = [
                'meta'      => Meta::single($this->profile)
            ];
    
            $session = $this->profile->getSession();
            $id = $this->req->param->id;
            $web_id = $this->config->app->games->website_id;
    
            $getSession = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/v1/ingame/auth/create',
                'method' => 'PUT',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $session->hash
                ],
                'body' => [
                    'uid' => $session->id,
                    'session_token' => $session->hash,
                    'website_id' => $web_id
                ]
            ]);
    
            $session_token = $getSession->data->token;
            $url = $this->config->app->games->host.'/games/lobby/?session_token='.$session_token.'&website_id='.$web_id.'&uid='.$session->id.'&game='.$id;
            echo $url;
        }
    }

    public function singleAction() {
        //
    }
}