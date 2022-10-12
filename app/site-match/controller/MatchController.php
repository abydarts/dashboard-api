<?php
/**
 * MatchController
 * @package site-post
 * @version 0.0.1
 */

namespace SiteMatch\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use SiteMatch\Library\Meta;
use SiteProfile\Controller\ProfileController;

class MatchController extends \Site\Controller
{
    public function indexAction() {
        $this->res->render('virtual-stadium/index');
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function singleAction() {
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
            $this->show404();
        }

        if($this->profile->isLogin()) {
            $check_payment = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/match/purchased/'.$id,
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ]
            ]);
        }

        $params = [
            'id'=>$id,
            'meta' => Meta::single($match),
            'match' => $match,
            'status_payment' => $check_payment ?? null
        ];

        $this->resp('match/single', $params);
    }

    public function quizPaymentAction() {
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteMatchQuiz', ['id' => $id]));

        // check match quiz purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id.'/1',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($check_payment->success) {
            return $this->res->redirect($this->router->to('siteMatchQuiz', ['id' => $id ]));
        }

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
            $this->show404();
        }

        $form = new Form('site.payment.quiz');

        $params = [
            'id'=>$id,
            'meta' => Meta::single($match),
            'match' => $match,
            'form' => $form,
        ];


        if(!($valid = $form->validate())){
            $this->resp('quiz/payment-confirmation', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/coin/purchase',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'match_id' => $valid->match_id,
                'is_quiz' => true,
            ]
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $params['purchase_no'] = $payment_result->purchase_no;
            $this->resp('quiz/payment-success', $params);
        }
        $this->resp('quiz/payment-error', $params);
    }

    public function quizAction() {
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        // check match purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if (!$check_payment->success) {
            return $this->res->redirect($this->router->to('siteMatchPayment', ['id' => $id ]));
        }

        // check match quiz purchase
//        $check_payment = Curl::fetch([
//            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id.'/1',
//            'method' => 'GET',
//            'headers' => [
//                'Accept' => 'application/json',
//                'Authorization' => $this->profile->getSession()->hash,
//            ]
//        ]);
//        if (!$check_payment->success) {
//            return $this->res->redirect($this->router->to('siteMatchQuizPayment', ['id' => $id ]));
//        }

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
            $this->show404();
        }

        if ($match->closing_date < date('c')) {
            return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $match->id]));
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/quiz/questions?group_id='.$match->group_question_id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($result->success) {
            $question = $result->data;
        }

        $form = new Form('site.match.quiz');

        $params = [
            'id'=>$id,
            'meta' => Meta::single($match),
            'match' => $match,
            'question' => $question,
            'form' => $form,
            'status_payment' => null
        ];

        if(!($valid = $form->validate())){
            $this->resp('quiz/single', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/quiz',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'match_id' => $valid->match_id,
                'point' => 0,
                'answers' => $valid->answer,
            ]
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $this->resp('quiz/quiz-success', $params);
        }
        $params['error'] = $result->message ?? 'Something went wrong';
        return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $valid->match_id]));

    }

    public function matchPaymentAction() {
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteMatchQuiz', ['id' => $id]));

        // check match quiz purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($check_payment->success) {
            return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $id ]));
        }

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
            $this->show404();
        }

        $form = new Form('site.payment.quiz');

        $params = [
            'id'=>$id,
            'meta' => Meta::single($match),
            'match' => $match,
            'form' => $form,
        ];

        if(!($valid = $form->validate())){
            $this->resp('match/payment-confirmation', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/coin/purchase',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'match_id' => $valid->match_id,
                'is_quiz' => false,
            ]
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $params['purchase_no'] = $payment_result->purchase_no;
            $this->resp('match/payment-success', $params);
        }
        $this->resp('payment/payment-error', $params);
    }

    public function buyAction() {
        $id = $this->req->param->id;

        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        // check match quiz purchase
        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if (!$check_payment->success) {
            return $this->res->redirect($this->router->to('siteMatchPayment', ['id' => $id ]));
        }

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
            $this->show404();
        }

        if ($match->match_date < date('c')) {
            return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $match->id]));
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/quiz/questions?group_id='.$match->group_question_id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($result->success) {
            $question = $result->data;
        }

        $form = new Form('site.match.quiz');

        $params = [
            'id'=>$id,
            'meta' => Meta::single($match),
            'match' => $match,
            'question' => $question,
            'form' => $form,
            'status_payment' => $check_payment
        ];

        if(!($valid = $form->validate())){
            $this->resp('quiz/single', $params);
        }

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/quiz',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'match_id' => $valid->match_id,
                'point' => 0,
                'answers' => $valid->answer,
            ]
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $this->resp('quiz/quiz-success', $params);
        }
        $params['error'] = $result->message ?? 'Something went wrong';
        return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $valid->match_id]));

    }

    public function virtualStadiumExampleAction() {
        $this->res->render('virtual-stadium/example');
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function virtualStadiumAction() {
        $id = $this->req->param->id;

        $check_payment = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/match/purchased/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if (isset($check_payment) && $check_payment->success == false){
            return $this->res->redirect($this->router->to('siteMatchBuy', ['id' => $id]));
        }

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