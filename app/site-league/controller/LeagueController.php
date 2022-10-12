<?php
/**
 * LeagueController
 * @package site-league
 * @version 0.0.1
 */

namespace SiteLeague\Controller;

use League\Model\League;
use LibCurl\Library\Curl;
use SiteLeague\Library\Meta;
use LibFormatter\Library\Formatter;

class LeagueController extends \Site\Controller
{
    public function singleAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $league = $result->data;
        } else {
            $this->show404();
        }

//        // return
        $params = [
            'league' => $league,
            'meta' => Meta::single($league),
        ];

        if ($id == 3) {
            $groupBid = 4;
        } else if($id == 7) {
            $groupBid = 8;
        }
        if (isset($groupBid) && $groupBid != 0) {
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/competitions/'.$groupBid,
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $groupB = $result->data;

            $params2 = [
                'groupB' => $groupB,
            ];

            $params = array_merge($params, $params2);
        }

        $this->resp('league/index', $params);
    }

    public function classementAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $league = $result->data;
        } else {
            $this->show404();
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id.'/classement',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $league->classement = $result->data;

        // return
        $params = [
            'league' => $league,
            'meta' => Meta::single($league),
        ];

        if ($id == 3) {
            $groupBid = 4;
        } else if($id == 7) {
            $groupBid = 8;
        }
        if (isset($groupBid) && $groupBid != 0) {
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/competitions/'.$groupBid,
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $groupB = $result->data;

            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/competitions/'.$groupBid.'/classement',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $groupB->classement = $result->data;

            $params2 = [
                'groupB' => $groupB,
            ];

            $params = array_merge($params, $params2);
        }

        $this->resp('league/classement', $params);
    }

    public function scheduleAction() {
        // get league content
        $id = $this->req->param->id;

        $result = Curl::fetch([
            'url' => $this->config->app->api->host . '/api/competitions/' . $id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $league = $result->data;

        //        $dates = date_month_range();
        $params = "?competition=$id";
        $result = Curl::fetch([
            'url' => $this->config->app->api->host . '/api/matches/available-date' . $params,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $dates = $result->data;
        $closest_date = $result->meta->closest_date;

        $params = "?competition=$id&date=" . date('Y-m-d', strtotime($closest_date));
        $result = Curl::fetch([
            'url' => $this->config->app->api->host . '/api/matches' . $params,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $matches = $result->data;

        // return
        $params = [
            'league' => $league,
            'matches' => $matches,
            'meta' => Meta::single($league),
            'week_range' => $dates,
            'closest_date' => $closest_date,
        ];

        $this->resp('league/schedule', $params);

    }

    public function clubAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $league = $result->data;

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id.'/classement',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $teams = $result->data;

        // return
        $params = [
            'league' => $league,
            'teams' => $teams,
            'meta' => Meta::single($league),
        ];

        $this->resp('league/club', $params);
    }

    public function getClubDetailsAction() {
        $league_id = $this->req->get('league_id');
        $club_id = $this->req->get('club_id');

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$league_id.'/club/'.$club_id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $team = $result->data;
            return $this->ajax(false, $team);
        } else {
            return $this->ajax(true, []);
        }
    }

    public function clubStatisticAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/competitions/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $league = $result->data;

        // return
        $params = [
            'league' => $league,
            'meta' => Meta::single($league),
        ];

        $this->resp('league/club-statistic', $params);
    }
}