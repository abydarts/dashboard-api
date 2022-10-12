<?php
/**
 * PostController
 * @package site-post
 * @version 0.0.1
 */

namespace SitePost\Controller;

use PostCategory\Model\PostCategory as PCategory;
use PostCategory\Model\PostCategoryChain as PCChain;
use SitePost\Library\Meta;
use Post\Model\Post;
use LibFormatter\Library\Formatter;

class PostController extends \Site\Controller
{
    public function singleAction() {
        // get post content
        $slug = $this->req->param->slug;

        $post = Post::getOne(['slug'=>$slug, 'status'=>3]);
        if(!$post)
            return $this->show404();

        $post = Formatter::format('post', $post, ['user', 'content', 'category']);

        // return
        $params = [
            'post' => $post,
            'meta' => Meta::single($post),
            'sidebar' => 'sidebar_post'
        ];

        $this->resp('post/single', $params);
    }
}