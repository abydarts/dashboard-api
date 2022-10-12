<?php
/**
 * QuizController
 * @package site-post
 * @version 0.0.1
 */

namespace SitePayment\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use SitePayment\Library\Meta;

class PaymentController extends \Site\Controller
{
    public function indexAction() {
        $this->res->render('virtual-stadium/index');
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function showStatusAction() {
        $this->resp('coin/default-payment-success', ['meta' => Meta::single()]);
    }

    public function topupAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        // get coin product list
        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/coin/list',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $form = new Form('site.payment.topup.coin');

        $params = [
            'meta' => Meta::single(),
            'list' => $list->data,
            'form' => $form
        ];
        if(!($valid = $form->validate())){
            $this->resp('coin/topup', $params);
        }

        // get payment method list
        $channels = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/channel',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        $channels = $channels->data;

        $form = new Form('site.payment.topup');
        $params = [
            'meta' => Meta::single(),
            'coin' => $valid->coin,
            'form' => $form,
            'channels' => $channels
        ];

        $this->resp('coin/payment-method', $params);
    }

    public function topupCoinAction() {
        $form = new Form('site.payment.topup');

        if(($valid = $form->validate())){
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/coin/topup',
                'method' => 'POST',
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->profile->getSession()->hash,
                ],
                'body' => [
                    'coin' => $valid->coin,
                    'channel' => $valid->channel,
                ]
            ]);
            if ($result->success) {
                $params = [
                    'meta' => Meta::single(),
                    'payment' => $result->data,
                ];
                return $this->res->redirect($this->router->to('sitePaymentDetail', ['id' => $result->data->trans_id]));
            } else {
                $params = [
                    'meta' => Meta::single(),
                    'message' => $result->message,
                ];
                $this->resp('coin/payment-error', $params);
            }
        }
    }

    public function pointHistoryAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/point/history',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'meta' => Meta::single(),
            'list' => $list->data,
        ];

        $this->resp('coin/point-history', $params);
    }

    public function historyAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/coin/history',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'meta' => Meta::single(),
            'list' => $list->data,
        ];

        $this->resp('coin/history', $params);
    }

    public function historyDetailAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $id = $this->req->param->id;
        $trans = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/coin/transaction/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($trans->success) {
            if($trans->data->type == 'purchase') {
                return $this->res->redirect($this->router->to('siteMatchSingle', ['id' => $trans->data->matches->id]));
            } elseif($trans->data->type == 'topup') {
                $trans->data->meta_topup->tran_status = $trans->data->tran_status;
                $params = [
                    'meta' => Meta::single(),
                    'transaction' => $trans->data,
                    'payment' => $trans->data->meta_topup,
                ];

                $this->resp('coin/payment-confirmation', $params);
            }
        } else {
            $this->show404();
        }
        $this->show404();

    }
}