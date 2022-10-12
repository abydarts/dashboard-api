<?php
/**
 * Default home controller
 * @package site
 * @version 0.0.1
 */

namespace Site\Controller;

use LibCurl\Library\Curl;
use LibForm\Library\Form;
use LibFormatter\Library\Formatter;
use Match\Model\Matches;
use PostCategory\Model\PostCategory as PCategory;
use PostCategory\Model\PostCategoryChain as PCChain;
use Site\Library\Meta;
use Post\Model\Post;
use Slideshow\Model\Slideshow;

class HomeController extends \Site\Controller
{
    public function indexAction(){
        $params = [ 'meta'  => Meta::single(), 'sidebar' => 'default' ];


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

        // header slideshow
        $slide = $this->cache->get('home-slideshow');
        if(!$slide){
            $slide = Slideshow::getOne(['name'=>'home-slideshow']);
            if($slide)
                $this->cache->add('home-slideshow', $slide, (60*60*2));
        }
        if($slide)
            $params['slides'] = Formatter::format('slideshow', $slide);

        // get live match
        $result = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/matches?status=live&date='.date('Y-m-d'),
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $params['live_matches'] = $result->data;

        // get upcoming match
        $res = Curl::fetch([
            'url' => $this->config->app->api->host.'/api/matches?status=upcoming&per_page=20',
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $params['upcoming_matches'] = $res->data;

        $this->resp('home/index', $params);
    }

    public function loginAction(){
        $form = new Form('site-contact');
        $params = [
            'meta'  => Meta::single(),
            'form'    => $form,
            'error'   => null,
            'success' => null
        ];

        $this->res->render('auth/login', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function registerAction(){
        $form = new Form('site-contact');
        $params = [
            'meta'  => Meta::single(),
            'form'    => $form,
            'error'   => null,
            'success' => null
        ];

        if(!($valid = $form->validate()) || !$form->csrfTest('noob')) {
            $this->res->render('auth/register', $params);
            $this->res->setCache(86400);
            $this->res->send();
        }

        dd($valid);
    }
}