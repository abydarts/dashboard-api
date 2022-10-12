<?php
/**
 * Site base controller
 * @package site
 * @version 0.0.1
 */

namespace Site;

use LibCurl\Library\Curl;
use LibFormatter\Library\Formatter;
use LibView\Library\View;
use Post\Model\Post;
use PostCategory\Model\PostCategory as PCategory;
use PostCategory\Model\PostCategoryChain as PCChain;

class Controller extends \Mim\Controller
    implements \Mim\Iface\GateController
{
    public function show404(): void{
        $this->res->setStatus(404);
        $this->res->addContent('<h1>Not found</h1>');
        $this->res->send();
    }

    public function show404Action(): void{
        $this->show404();
    }

    public function show500(object $error): void{
        $tx = $error->text;
        $tx.= '<br>';
        $tx.= 'File: ' . $error->file . ' (' . $error->line . ')';
        if(isset($error->trace)){
            $tx.= '<ul>';
            foreach($error->trace as $trace){
                if(!isset($trace['file']))
                    continue;
                $tx.= '<li>' . $trace['file'] . '(' . $trace['line'] . ')' . '</li>';
            }
            $tx.= '</ul>';
        }

        $this->res->addContent($tx);
        $this->res->send();
    }

    public function show500Action(): void{
        $this->show500(\Mim\Library\Logger::$last_error);
    }

    public function ajax(bool $error, $data): void{
        $content = json_encode(['error'=>$error,'data'=>$data], JSON_PRESERVE_ZERO_FRACTION);

        $this->res->addContent($content);
        $this->res->addHeader('Content-Type', 'application/json', false);
        $this->res->addHeader('Connection', 'close');
        $this->res->addHeader('Content-Length', strlen($content));
        $this->res->send();
    }

    public function resp(string $view, array $params=[], string $layout='default') {
        // render the sidebar
        if(!isset($params['sidebar']) || $params['sidebar'] === false) {
            $sidebar = '';
        } else if ($params['sidebar'] == 'sidebar_post') {
            // get related post
            $related_posts = [];
            $tv_post = [];

            $category = PCategory::getOne(['slug'=>'tv']);
            $category = Formatter::format('post-category', $category);

            $cond = [
                'post.status'   => 3,
                'post_category' => !empty($params['post']->category) ? $params['post']->category[0]->id : null,
            ];

            list($page, $rpp) = $this->req->getPager(5);

            $pchains = PCChain::get($cond, $rpp, $page, ['created'=>false]);
            if($pchains){
                $post_ids = array_column($pchains, 'post');
                $posts = Post::get(['id'=>$post_ids], 0, 1, ['created'=>false]);
                $related_posts = Formatter::formatMany('post', $posts, ['user']);
            }

            // get tv post
//            $tvposts = [];
//            $tvcategory = $category = PCategory::getOne(['slug'=>'tv']);
//            $cond = [
//                'post.status'   => 3,
//                'post_category' => !empty($tvcategory) ? $tvcategory->id : null,
//            ];
//            $pchains = PCChain::get($cond, $rpp, $page, ['created'=>false]);
//            if($pchains){
//                $post_ids = array_column($pchains, 'post');
//                $tvposts = Post::get(['id'=>$post_ids], 0, 1, ['created'=>false]);
//                $tvposts = Formatter::formatMany('post', $tvposts, ['user', 'content', 'category']);
//            }
            $sidebar_params = [
//                'tvposts' => $tvposts,
                'related_posts' => $related_posts,
            ];

            $sidebar = View::render('shared/sidebar_post', $sidebar_params) ?? '';

        } else {
            $league_classement = [];
            $today_match = [];

            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/matches?date='.date('Y-m-d'),
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $today_match = $result->data;

            $league_id = 1;
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/competitions/'.$league_id,
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $league = $result->data;
            $result = Curl::fetch([
                'url' => $this->config->app->api->host.'/api/competitions/'.$league_id.'/classement',
                'method' => 'GET',
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $league->classement = $result->data;

//            $league_id = 4;
//            $result = Curl::fetch([
//                'url' => $this->config->app->api->host.'/api/competitions/'.$league_id,
//                'method' => 'GET',
//                'headers' => [
//                    'Accept' => 'application/json',
//                ]
//            ]);
//            $leagueB = $result->data;
//            $result = Curl::fetch([
//                'url' => $this->config->app->api->host.'/api/competitions/'.$league_id.'/classement',
//                'method' => 'GET',
//                'headers' => [
//                    'Accept' => 'application/json',
//                ]
//            ]);
//            $leagueB->classement = $result->data;

            $sidebar_params = [
                'today_match' => $today_match,
                'resume_league' => $league,
//                'resume_league_b' => $leagueB,
            ];

            $sidebar = View::render('shared/sidebar', $sidebar_params) ?? '';
        }
        $params['sidebar_content'] = $sidebar;

        // render the content
        $content = View::render($view, $params) ?? '';

        $layout_params = [
            'meta'   => $params['meta'],
            'content' => $content,
            'notification_unread' => $notification ?? 0,
        ];
        $result  = View::render('layout/' . $layout, $layout_params) ?? '';

        $this->res->addContent($result);
        $this->res->send();
    }
}