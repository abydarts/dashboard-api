<?php
/**
 * RobotController
 * @package site-team
 * @version 0.0.1
 */

namespace SiteTeam\Controller;

use LibRobot\Library\Feed;
use SiteTeam\Library\Robot;

class RobotController extends \Site\Controller
{
    public function feedAction(){
        $links = Robot::feed();

        $feed_opts = (object)[
            'self_url'          => $this->router->to('siteTeamFeed'),
            'copyright_year'    => date('Y'),
            'copyright_name'    => \Mim::$app->config->name,
            'description'       => '...',
            'language'          => 'id-ID',
            'host'              => $this->router->to('siteHome'),
            'title'             => \Mim::$app->config->name
        ];

        Feed::render($links, $feed_opts);
        $this->res->setCache(3600);
        $this->res->send();
    }
}