<?php
/**
 * Robot
 * @package site-match
 * @version 0.0.1
 */

namespace SiteStore\Library;


class Robot
{
    static private function getPages(): ?array{
        $cond = [
            'status'  => 3,
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        $pages = Matches::get($cond);
        if(!$pages)
            return null;

        return $pages;
    }

    static function feed(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('sitePostSingle', (array)$page);
            $meta  = json_decode($page->meta);
            $title = $meta->title ?? $page->title;
            $desc  = $meta->description ?? $title;

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function sitemap(): array {
        $mim = &\Mim::$app;

        $route = $mim->router->to('siteGamesIndex');
        $title = 'IFeL - Games';
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