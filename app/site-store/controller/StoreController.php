<?php
/**
 * StoreController
 * @package site-post
 * @version 0.0.1
 */

namespace SiteStore\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use LibFormatter\Library\Formatter;
use SiteStore\Library\Meta;
use Slideshow\Model\Slideshow;

class StoreController extends \Site\Controller
{
    public function indexAction() {
        $page = $this->req->getQuery('page');
        if ($page == null) $page=1;

        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/products?page='.$page,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $list->meta->links = array_slice($list->meta->links, 1, -1);

        $params = [
            'products' => $list->data,
            'pagination' => $list->meta,
          'meta' => Meta::single(),
        ];

        // header slideshow
        $slide = $this->cache->get('store-slideshow');
        if(!$slide){
            $slide = Slideshow::getOne(['name'=>'store-slideshow']);

            if($slide)
                $this->cache->add('store-slideshow', $slide, (60*60*2));
        }
        if($slide)
            $params['slides'] = Formatter::format('slideshow', $slide);


        $this->resp('store/index', $params);
    }

    public function singleAction() {
        $id = $this->req->param->id;
        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/product/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $params = [
            'product' => $list->data,
            'meta' => Meta::single(),
        ];

        $this->resp('store/single', $params);
    }

    public function redeemAction() {
        $id = $this->req->param->id;
        $product = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/product/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $form = new Form('site.payment.confirmation');
        $data = (object) ['name' => 'Tournament IFeL'];

        $params = [
            'id'=>$id,
            'meta' => Meta::single(),
            'product' => $product->data,
            'price' => $product->data->price,
            'form' => $form,
            'point' => true
        ];

        if (!$valid = $form->validate())
            $this->resp('payment/payment-confirmation', $params);

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/buy',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'product_id' => $id,
            ]
        ]);

        if ($result->success) {
            $payment_result = $result->data;
            $params['payment'] = $payment_result;
//            $this->resp('store/redeem-success', $params);
            return $this->res->redirect($this->router->to('siteRewardDetail', ['id' => $payment_result->id]));
        }
        $params['error'] = $result->message ?? 'Something went wrong';
        $this->resp('payment/payment-error', $params);
    }

    public function rewardsAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $detail = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/rewards',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'meta' => Meta::single(),
            'rewards' => $detail->data
        ];
        $this->resp('store/rewards-history', $params);
    }

    public function rewardDetailAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $id = $this->req->param->id;
        $detail = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/reward/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);
        if ($detail->success == false) {
            $this->show404();
        }

        $address = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/address/',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $form = new Form('site.store.claim');

        $params = [
            'meta' => Meta::single(),
            'form' => $form,
            'reward' => $detail->data,
            'address' => $address->data
        ];


        if(!($valid = $form->validate())){
            $this->resp('store/rewards-detail', $params);
        }

//        $result = Curl::fetch([
//            'url' => $this->config->app->api->host.'/api/claim',
//            'method' => 'POST',
//            'headers' => [
//                'Accept' => 'application/json',
//                'Content-Type' => 'application/json',
//                'Authorization' => $this->profile->getSession()->hash,
//            ],
//            'body' => [
//                'transaction_id' => $id,
//            ]
//        ]);
//        if ($result->success) {
//            $payment_result = $result->data;
//            $params['payment'] = $payment_result;
//            $this->resp('store/claim-success', $params);
////            return $this->res->redirect($this->router->to('siteStoreClaim', ['id' => $payment_result->id]));
//        }
//        $params['error'] = $result->message ?? 'Something went wrong';
//        $this->resp('payment/payment-error', $params);
    }

    public function claimAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));
        $id = $this->req->param->id;

        $detail = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/reward/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'meta' => Meta::single(),
            'reward' => $detail->data
        ];

        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/claim',
            'method' => 'POST',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ],
            'body' => [
                'transaction_id' => $id,
            ]
        ]);
        if ($result->success) {
            $payment_result = $result->data;
            $params['payment'] = $payment_result;
            $this->resp('store/claim-success', $params);
//            return $this->res->redirect($this->router->to('siteStoreClaim', ['id' => $payment_result->id]));
        }
        $params['error'] = $result->message ?? 'Something went wrong';
        $this->resp('payment/payment-error', $params);
    }

}