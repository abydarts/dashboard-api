<?php
/**
 * Meta
 * @package site-league
 * @version 0.0.1
 */

namespace SiteLeague\Library;


class Meta
{
    static function single(object $page){
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        $result['head'] = [
            'description'       => $page->name,
            'published_time'    => $page->created_at,
            'schema.org'        => [],
            'type'              => 'article',
            'title'             => $page->name,
            'updated_time'      => $page->updated_at,
            'url'               => \Mim::$app->req->url,
            'metas'             => []
        ];

        return $result;
    }
}