<?php
/**
 * Event
 * @package site-match
 * @version 0.0.1
 */

namespace SiteMatch\Library;

use LibCacheOutput\Library\Cleaner;

class Event
{
    static function clear(array $data): void{
        $page = $data['page'] ?? $data['old'] ?? null;

        // clear output cache
        if($page && module_exists('lib-cache-output'))
            Cleaner::router('siteMatchSingle', (array)$page);

        // Clear static page RSS Feed output cache
        // Clear global RSS Feed output cache
        // Clear global Sitemap output cache
    }
}