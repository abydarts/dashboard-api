<?php
/**
 * Assets
 * @package admin-ui
 * @version 0.0.1
 */

namespace AdminUi\Library;

class Assets
{
    static $custom_assets = [];

    static function addAsset(string $type, string $area, string $path, string $version='1'): void{
        if(!isset(self::$custom_assets[$area]))
            self::$custom_assets[$area] = [];
        
        if(!isset(self::$custom_assets[$area][$type]))
            self::$custom_assets[$area][$type] = [];

        self::$custom_assets[$area][$type][$path] = $version;
    }

    static function getAssets(string $type, string $area): array {
        $aconf  = \Mim::$app->config->adminUi->static;
        $result = [];

        $files  = [];

        if(isset($aconf->$area) && isset($aconf->$area->$type))
            $files = (array)$aconf->$area->$type;

        if(isset(self::$custom_assets[$area]) && isset(self::$custom_assets[$area][$type]))
            $files = array_merge($files, self::$custom_assets[$area][$type]);

        foreach($files as $file => $version){
            if(substr($file,0,1) === '/' || preg_match('!^https?:\/\/!', $file))
                $result[$file] = $version;
            else{
                $file = \Mim::$app->router->asset('admin', $file);
                $result[$file] = $version;
            }
        }

        return $result;
    }
}