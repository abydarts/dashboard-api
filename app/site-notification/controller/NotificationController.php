<?php
/**
 * NotificationController
 * @package site-post
 * @version 0.0.1
 */

namespace SiteNotification\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use LibFormatter\Library\Formatter;
use SiteStore\Library\Meta;
use Slideshow\Model\Slideshow;

class NotificationController extends \Site\Controller
{
    public function indexAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/notifications',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'notifications' => $list->data,
            'meta' => Meta::single(),
        ];

        $this->resp('profile/notification', $params);
    }

    public function readAction() {
        if(!$this->profile->isLogin())
            return $this->res->redirect($this->router->to('siteProfileLogin'));

        $id = $this->req->param->id;
        $list = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/product/'.$id,
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $this->profile->getSession()->hash,
            ]
        ]);

        $params = [
            'product' => $list->data,
          'meta' => Meta::single(),
        ];

        $this->resp('store/single', $params);
    }


}