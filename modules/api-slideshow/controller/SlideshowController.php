<?php
/**
 * SlideshowController
 * @package api-slideshow
 * @version 0.0.1
 */

namespace ApiSlideshow\Controller;

use Slideshow\Model\Slideshow;
use LibFormatter\Library\Formatter;

class SlideshowController extends \Api\Controller
{
	public function indexAction(){
//		if(!$this->app->isAuthorized())
//            return $this->resp(401);

        list($page, $rpp) = $this->req->getPager();

        $cond = [];
        if($q = $this->req->getQuery('q'))
        	$cond['q'] = $q;

        $slides = Slideshow::get($cond, $rpp, $page, ['name'=>true]);
        if($slides)
        	$slides = Formatter::formatMany('slideshow', $slides);

        $this->resp(0, $slides, null, [
            'meta' => [
                'page'  => $page,
                'rpp'   => $rpp,
                'total' => Slideshow::count($cond)
            ]
        ]);
	}

	public function singleAction(){
//		if(!$this->app->isAuthorized())
//            return $this->resp(401);

        $identity = $this->req->param->identity;
        $slide = Slideshow::getOne(['id'=>$identity]);
        if(!$slide)
        	$slide = Slideshow::getOne(['name'=>$identity]);

        if(!$slide)
        	return $this->show404();

        $slide = Formatter::format('slideshow', $slide);

        $this->resp(0, $slide);
	}
}