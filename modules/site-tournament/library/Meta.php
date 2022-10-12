<?php
/**
 * Meta
 * @package site-tournament
 * @version 0.0.1
 */

namespace SiteTournament\Library;


use Cassandra\Date;

class Meta
{
    static function single(object $page){
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        $result['head'] = [
            'description'       => $page->name ?? 'Tournamnet IFeL',
            'published_time'    => $page->created_at ?? '',
            'schema.org'        => [],
            'type'              => 'article',
            'title'             => $page->name ?? 'Tournamnet IFeL',
            'updated_time'      => $page->updated_at ?? '',
            'url'               => \Mim::$app->req->url,
            'metas'             => []
        ];

        return $result;
    }
}