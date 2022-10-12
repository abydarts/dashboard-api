<?php
/**
 * CategoryController
 * @package site-post-category
 * @version 0.0.1
 */

namespace SitePostCategory\Controller;

use SitePostCategory\Library\Meta;
use PostCategory\Model\PostCategory as PCategory;
use PostCategory\Model\PostCategoryChain as PCChain;
use Post\Model\Post;
use LibFormatter\Library\Formatter;

class CategoryController extends \Site\Controller
{
    public function singleAction() {
        $slug = $this->req->param->slug;

        $category = PCategory::getOne(['slug'=>$slug]);
        if(!$category)
            return $this->show404();

        $category = Formatter::format('post-category', $category, ['user']);

        $posts = [];

        $cond = [
            'post.status'   => 3,
            'post_category' => $category->id
        ];

        list($page, $rpp) = $this->req->getPager(12, 24);

        $pchains = PCChain::get($cond, $rpp, $page, ['created'=>false]);
        if($pchains){
            $post_ids = array_column($pchains, 'post');
            $posts = Post::get(['id'=>$post_ids], 0, 1, ['created'=>false]);
            $posts = Formatter::formatMany('post', $posts, ['user', 'content', 'category']);
        }

        $featured_post = Post::getOne(['status' => 3, 'featured'=>1]);
        if ($featured_post)
            $featured_post = Formatter::format('post', $featured_post, ['user', 'category']);
        else
            $featured_post = !empty($posts) ? $posts[0] : false;

        // get tv post
//        $tvcategory = PCategory::getOne(['slug'=>'tv']);
//        $cond = [
//            'post.status'   => 3,
//            'post_category' => !empty($tvcategory) ? $tvcategory->id : null,
//        ];
//        $pchains = PCChain::get($cond, 2, 1, ['created'=>false]);
//        if($pchains){
//            $post_ids = array_column($pchains, 'post');
//            $tvposts = Post::get(['id'=>$post_ids], 2, 1, ['created'=>false]);
//            $tvposts = Formatter::formatMany('post', $tvposts, ['user', 'content', 'category']);
//        }

        $params = [
            'category'  => $category,
            'meta'      => Meta::single($category),
            'posts'     => $posts,
//            'tvposts'     => $tvposts,
            'featured_post'     => $featured_post,
            'total'     => PCChain::count($cond),
            'sidebar' => 'default'
        ];

        $this->resp('post-category/single', $params);
    }
}