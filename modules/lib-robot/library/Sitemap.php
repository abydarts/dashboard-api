<?php
/**
 * Sitemap
 * @package lib-robot
 * @version 0.0.1
 */

namespace LibRobot\Library;

class Sitemap
{
    static function render(array $pages): void{
        $params = [
            'pages'     => $pages
        ];

        \Mim::$app->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
        \Mim::$app->res->render('robot/sitemap', $params);
    }
}