<?php
/**
 * Page Meta Provider
 * @package site-static-page
 * @version 0.0.1
 */

namespace SiteContact\Meta;

class Contact
{
    static function single(){
        $mim = &\Mim::$app;

        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = $mim->router->to('siteHome');

        $meta = (object)[
            'title'         => hs($mim->setting->site_sponsorship_title),
            'description'   => hs($mim->setting->site_sponsorship_description),
            'schema'        => 'ContactPage',
            'keyword'       => '',
            'created'       => date('c', strtotime($mim->config->install)),
            'page'          => $mim->router->to('siteContact')
        ];

        $result['head'] = [
            'description'       => $meta->description,
            'published_time'    => $meta->created,
            'schema.org'        => [],
            'type'              => 'website',
            'title'             => $meta->title,
            'updated_time'      => $meta->created,
            'url'               => $meta->page,
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
                        'name' => $mim->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $home_url . '#page',
                        'name' => 'Pages'
                    ]
                ]
            ]
        ];

        // schema page
        $result['head']['schema.org'][] = [
            '@context'      => 'http://schema.org',
            '@type'         => $meta->schema,
            'name'          => $meta->title,
            'description'   => $meta->description,
            'dateCreated'   => $meta->created,
            'dateModified'  => $meta->created,
            'datePublished' => $meta->created,
            'publisher'     => \Mim::$app->meta->schemaOrg( \Mim::$app->config->name ),
            // 'thumbnailUrl'  => $meta_image,
            'url'           => $meta->page,
            // 'image'         => $meta_image
        ];

        return $result;
    }
}