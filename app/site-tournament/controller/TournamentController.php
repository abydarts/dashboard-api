<?php
/**
 * TournamentController
 * @package site-tournament
 * @version 0.0.1
 */

namespace SiteTournament\Controller;

use League\Model\League;
use LibCurl\Library\Curl;
use LibForm\Library\Form;
use SiteTournament\Library\Meta;
use LibFormatter\Library\Formatter;

class TournamentController extends \Site\Controller
{

    public function indexAction() {
        // get league content
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $tournaments = $result->data;

        $data = (object) ['name' => 'Tournament IFeL'];

//        // return
        $params = [
            'meta' => Meta::single($data),
            'tournaments' => $tournaments
        ];

        $this->resp('tournament/index', $params);
    }

    public function singleAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        if($this->profile->isLogin()) {
            $check_payment = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ]
            ]);
        }

        $data = (object) ['name' => 'Tournament IFeL'];
//        // return
        $params = [
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'status_payment' => $check_payment->success ?? false
        ];

        $this->resp('tournament/single', $params);
    }

    public function singleMatchAction() {
        // get league content
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        if($this->profile->isLogin()) {
            $check_payment = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ]
            ]);
        }

        $matches = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id.'/games',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $matches = $matches->data;

        $data = (object) ['name' => 'Tournament IFeL'];
//        // return
        $params = [
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'matches' => $matches,
            'status_payment' => $check_payment ?? null
        ];

        $this->resp('tournament/single-match', $params);
    }

    public function singleRulesAction() {
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        if($this->profile->isLogin()) {
            $check_payment = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ]
            ]);
        }

        $data = (object) ['name' => 'Tournament IFeL'];
//        // return
        $params = [
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'status_payment' => $check_payment ?? null
        ];

        $this->resp('tournament/single-rules', $params);
    }

    public function singleTutorialAction() {
        $id = $this->req->param->id;
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        if($this->profile->isLogin()) {
            $check_payment = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ]
            ]);
        }

        $data = (object) ['name' => 'Tournament IFeL'];
//        // return
        $params = [
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'status_payment' => $check_payment ?? null
        ];

        $this->resp('tournament/single-tutorial', $params);
    }

    public function paymentAction(){
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        // check match quiz purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($check_payment->success) {
            return $this->res->redirect($this->router->to('siteTournamentSingle', ['id' => $id ]));
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        $form = new Form('site.payment.confirmation');
        $data = (object) ['name' => 'Tournament IFeL'];

        $params = [
            'id'=>$id,
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'price' => $tournament->price,
            'form' => $form,
        ];


        if(!($valid = $form->validate())){
            $this->resp('payment/payment-confirmation', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournament/'.$tournament->id.'/purchase',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $params['purchase_no'] = $payment_result->purchase_no;
            $this->resp('payment/payment-success', $params);
        }
        $params['error_msg'] = $result->message;
        $this->resp('payment/payment-error', $params);
    }

    public function editTeamAction(){
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        // check match quiz purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournament/'.$id.'/check',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if (!$check_payment->success) {
            return $this->res->redirect($this->router->to('siteTournamentSingle', ['id' => $id ]));
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournaments/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        if ($result->success) {
            $tournament = $result->data;
        } else {
            $this->show404();
        }

        $form = new Form('site.tournament.edit.team');
        $data = (object) ['name' => 'Tournament IFeL'];
        $params = [
            'meta' => Meta::single($data),
            'tournament' => $tournament,
            'form' => $form,
            'group' => $check_payment->data->group
        ];

        if(!($valid = $form->validate())){
            $this->resp('tournament/edit-team', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/tournament/'.$tournament->id.'/register',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'name' => $valid->group_name,
                'group_players' => $valid->group_players

            ]
        ]);
        if ($result->success) {
            return $this->res->redirect($this->router->to('siteTournamentEditTeam', ['id'=>$tournament->id]));
        }
        $params['error_msg'] = $result->message;
        $this->resp('payment/payment-error', $params);
    }


}