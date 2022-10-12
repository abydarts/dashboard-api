<?php
/**
 * Meta
 * @package site-profile
 * @version 0.0.1
 */

namespace SiteProfile\Library;


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
            'updated_time'      => $page->created_at,
            'url'               => \Mim::$app->req->url,
            'metas'             => []
        ];

//        $meta = (object)[
//            'title'         => $page->name,
//            'description'   => $page->name,
//            'schema'        => 'Person',
//            'keyword'       => ''
//        ];
//
//        $result['head'] = [
//            'description'       => $meta->description,
//            'published_time'    => $page->created_at,
//            'schema.org'        => [],
//            'type'              => 'profile',
//            'title'             => $meta->title,
//            'updated_time'      => $page->created_at,
//            'url'               => \Mim::$app->req->url,
//            'metas'             => []
//        ];
//
//        // schema breadcrumbList
//        $result['head']['schema.org'][] = [
//            '@context'  => 'http://schema.org',
//            '@type'     => 'BreadcrumbList',
//            'itemListElement' => [
//                [
//                    '@type' => 'ListItem',
//                    'position' => 1,
//                    'item' => [
//                        '@id' => $home_url,
//                        'name' => \Mim::$app->config->name
//                    ]
//                ],
//                [
//                    '@type' => 'ListItem',
//                    'position' => 2,
//                    'item' => [
//                        '@id' => $home_url . '#profile',
//                        'name' => 'Profiles'
//                    ]
//                ]
//            ]
//        ];
//
//        // schema page
//        $result['head']['schema.org'][] = [
//            '@context'      => 'http://schema.org',
//            '@type'         => $meta->schema,
//            'name'          => $meta->title,
//            'description'   => $meta->description,
//            'dateCreated'   => $page->created,
//            'dateModified'  => $page->updated,
//            'datePublished' => $page->created,
//            'publisher'     => \Mim::$app->meta->schemaOrg( \Mim::$app->config->name ),
//            // 'thumbnailUrl'  => $meta_image,
//            'url'           => $page->page,
//            // 'image'         => $meta_image
//        ];

        return $result;
    }
}