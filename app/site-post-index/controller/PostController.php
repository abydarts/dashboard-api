<?php
/**
 * PostController
 * @package site-post-index
 * @version 0.0.1
 */

namespace SitePostIndex\Controller;

use Post\Model\Post;
use PostCategory\Model\PostCategory as PCategory;
use PostCategory\Model\PostCategoryChain as PCChain;
use SitePostIndex\Library\Meta;
use LibFormatter\Library\Formatter;

class PostController extends \Site\Controller
{
	public function indexAction(){
		$posts = Post::get(['status'=>3], 12, 1, ['created'=>false]);
		if($posts)
			$posts = Formatter::formatMany('post', $posts, ['user', 'content', 'category']);

		$featured_post = Post::getOne(['status' => 3, 'featured'=>1]);
		if ($featured_post)
            $featured_post = Formatter::format('post', $featured_post, ['user', 'category']);
		else
            $featured_post = $posts[0] ?? null;

        // get tv post
        list($page, $rpp) = $this->req->getPager(5);
        $tvcategory = $category = PCategory::getOne(['slug'=>'tv']);
        $cond = [
            'post.status'   => 3,
            'post_category' => !empty($tvcategory) ? $tvcategory->id : null,
        ];
        $pchains = PCChain::get($cond, $rpp, $page, ['created'=>false]);
        if($pchains){
            $post_ids = array_column($pchains, 'post');
            $tvposts = Post::get(['id'=>$post_ids], 0, 1, ['created'=>false]);
            $tvposts = Formatter::formatMany('post', $tvposts, ['user', 'content', 'category']);
        }

        $params = [
            'meta'    => Meta::single(),
            'posts'   => $posts,
            'featured_post'   => $featured_post,
            'tvposts' => $tvposts ?? [],
            'sidebar' => 'default'
        ];

        $this->resp('post/index', $params);
	}
}