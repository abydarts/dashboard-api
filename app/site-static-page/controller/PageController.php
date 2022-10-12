<?php
/**
 * PageController
 * @package site-static-page
 * @version 0.0.1
 */

namespace SiteStaticPage\Controller;

use SiteStaticPage\Meta\StaticPage as Meta;
use StaticPage\Model\StaticPage as SPage;
use LibFormatter\Library\Formatter;

class PageController extends \Site\Controller
{
    public function singleAction() {
        $slug = $this->req->param->slug;

        $page = SPage::getOne(['slug'=>$slug]);
        if(!$page)
            return $this->show404();

        $page = Formatter::format('static-page', $page, ['user']);

        $params = [
            'page' => $page,
            'meta' => Meta::single($page)
        ];

        $this->resp('static-page/single', $params);
    }
}