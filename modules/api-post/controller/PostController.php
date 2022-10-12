<?php
/**
 * PostController
 * @package api-post
 * @version 0.0.1
 */

namespace ApiPost\Controller;

use LibFormatter\Library\Formatter;

use Post\Model\Post;

class PostController extends \Api\Controller
{
    public function indexAction() {
//        if(!$this->app->isAuthorized())
//            return $this->resp(401);

        list($page, $rpp) = $this->req->getPager();

        $cond = [
            'status' => 3
        ];
        if($q = $this->req->getQuery('q'))
            $cond['q'] = $q;

        $pages = Post::get($cond, $rpp, $page, ['created' => false]);
        $fmt   = ['user'];
        if(module_exists('post-category'))
            $fmt[] = 'category';
        $pages = !$pages ? [] : Formatter::formatMany('post', $pages, $fmt);

        foreach($pages as &$pg)
            unset($pg->meta);
        unset($pg);

        $this->resp(0, $pages, null, [
            'meta' => [
                'page'  => $page,
                'rpp'   => $rpp,
                'total' => Post::count($cond)
            ]
        ]);
    }

    public function randomAction() {
//        if(!$this->app->isAuthorized())
//            return $this->resp(401);

        list($page, $rpp) = $this->req->getPager();

        $cond = [
            'status' => 3
        ];
        if($q = $this->req->getQuery('q'))
            $cond['q'] = $q;

        $pages = Post::get($cond, $rpp, $page, ['RAND()' => true]);
        $fmt   = ['user'];
        if(module_exists('post-category'))
            $fmt[] = 'category';
        $pages = !$pages ? [] : Formatter::formatMany('post', $pages, $fmt);

        foreach($pages as &$pg)
            unset($pg->meta);
        unset($pg);

        $this->resp(0, $pages);
    }

    public function singleAction() {
//        if(!$this->app->isAuthorized())
//            return $this->resp(401);

        $identity = $this->req->param->identity;

        $page = Post::getOne(['id'=>$identity]);
        if(!$page)
            $page = Post::getOne(['slug'=>$identity]);

        if(!$page)
            return $this->resp(404);

        $fopts = ['user','content','publisher'];
        $ex_modules = [
            'post-category' => 'category'
        ];

        foreach($ex_modules as $name => $prop){
            if(module_exists($name))
                $fopts[] = $prop;
        }

        $page = Formatter::format('post', $page, $fopts);

        $this->resp(0, $page);
    }
}