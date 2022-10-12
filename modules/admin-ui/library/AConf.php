<?php
/**
 * AConf
 * @package admin-ui
 * @version 0.0.1
 */

namespace AdminUi\Library;

class AConf
{
    static private $conf = [];

    static function add(string $key, $value): void{
        if(!self::$conf)
            self::$conf = [];
        self::$conf = array_merge_recursive(self::$conf, [$key=>$value]);
    }

    static function json(): string{
        return json_encode(self::$conf, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES);
    }
}