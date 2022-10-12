<?php
/**
 * QuizController
 * @package site-post
 * @version 0.0.1
 */

namespace SiteMatch\Controller;

use LibCurl\Library\Curl;
use SiteMatch\Library\Meta;

class QuizController extends \Site\Controller
{
    public function indexAction() {
        $this->res->render('virtual-stadium/index');
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function singleAction() {
        $id = $this->req->param->id;

        $params = [
            'id' => $id,
            'meta' => \SiteLeague\Library\Meta::single($league),
        ]

        $this->res->render('virtual-stadium/index', ['id'=>$id]);
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function virtualStadiumXMLAction() {
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/matches/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $match = $result->data;
        } else {
            $match = null;
        }

        $params = [
            'match' => $match,
            'id' =>$id,
        ];

        $this->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->res->render('virtual-stadium/feed', $params);
        $this->res->setCache(86400);
        $this->res->send();

    }

    public function virtualStadiumPluginAction() {
        $params = [];
        $id = $this->req->param->id;
        $plugin = $this->req->get('plugin');

        if (in_array($plugin, ['score', 'iframe'])) {
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/matches/'.$id,
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            if ($result->success) {
                $match = $result->data;
            } else {
                $match = null;
            }
            $params = [
                'match' => $match,
            ];
        }


        $this->res->render('virtual-stadium/plugin/'.$plugin, $params);
        $this->res->setCache(86400);
        $this->res->send();

    }

    public function matchByDateAction() {
        // get post content
        $league_id = $this->req->get('league_id');
        $date = $this->req->get('date');
        $params = "?competition=$league_id&date=$date";
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/matches'.$params,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $matches = $result->data;
        return $this->ajax(false, $matches);
    }
}