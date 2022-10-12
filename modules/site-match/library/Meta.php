<?php
/**
 * Meta
 * @package site-match
 * @version 0.0.1
 */

namespace SiteMatch\Library;


class Meta
{
    static function single(object $match){
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        $page = (object)[
            'title'         => "Match {$match->home->name} vs {$match->away->name}",
            'description'   => "Match {$match->home->name} vs {$match->away->name}",
            'schema'        => 'WebSite',
            'keyword'       => '',
            'page'          => \Mim::$app->req->url,
        ];

        $result['head'] = [
            'description'       => $page->description,
            'schema.org'        => [],
            'type'              => 'article',
            'title'             => $page->title,
            'url'               => $page->page,
            'metas'             => []
        ];

        // schema breadcrumbList
        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $page->page,
                        'name' => $page->title
                    ]
                ]
            ]
        ];

        return $result;
    }
}