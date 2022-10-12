<?php
/**
 * Robot
 * @package site-contact
 * @version 0.0.1
 */

namespace SiteContact\Library;

class Robot
{

    static function feed(): array {
        $mim = &\Mim::$app;

        $route = $mim->router->to('siteContact');

        $title = $mim->setting->site_contact_title;
        $desc  = $mim->setting->site_contact_description;

        $page = (object)[
            'description'   => $desc,
            'page'          => $route,
            'published'     => $mim->config->install,
            'updated'       => $mim->config->install,
            'priority'      => '0.3',
            'title'         => $title,
            'changefreq'    => 'hourly',
            'guid'          => $route,
            'image'         => [
                'url'           => $mim->router->asset('site', '/logo/192x192.png'),
                'caption'       => $title,
                'title'         => $title
            ]
        ];

        return [$page];
    }

    static function sitemap(): array {
        $mim = &\Mim::$app;

        $route = $mim->router->to('siteContact');
        $title = $mim->setting->site_contact_title;
        $desc  = $title;

        $page = (object)[
            'page'          => $route,
            'updated'       => date('Y-m-d H:i:s'),
            'priority'      => '0.3',
            'changefreq'    => 'monthly'
        ];

        return [$page];
    }
}