<?php
/**
 * Event
 * @package site-team
 * @version 0.0.1
 */

namespace SiteTeam\Library;

use LibCacheOutput\Library\Cleaner;

class Event
{
    static function clear(array $data): void{
        $page = $data['page'] ?? $data['old'] ?? null;

        // clear output cache
        if($page && module_exists('lib-cache-output'))
            Cleaner::router('siteTeamSingle', (array)$page);

        // Clear static page RSS Feed output cache
        // Clear global RSS Feed output cache
        // Clear global Sitemap output cache
    }
}