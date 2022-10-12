<?php
/**
 * Robot
 * @package site-team
 * @version 0.0.1
 */

namespace SiteTeam\Library;

use Team\Model\Team;

class Robot
{
    static private function getPages(): ?array{
        $cond = [
            'status'  => 3,
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        $pages = Team::get($cond);
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
            $route = $mim->router->to('siteTeamSingle', (array)$page);
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

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route  = $mim->router->to('siteTeamSingle', (array)$page);
            $result[] = (object)[
                'page'          => $route,
                'updated'       => $page->updated,
                'priority'      => '0.4',
                'changefreq'    => 'monthly'
            ];
        }

        return $result;
    }
}