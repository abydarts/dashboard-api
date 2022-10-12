<?php
/**
 * Meta
 * @package admin-site-meta
 * @version 0.0.1
 */

namespace AdminSiteMeta\Library;


class Meta
{
    private static $metas = ['schema','title','description','keywords'];

    static function parse(object &$object, string $key): void{
        $meta = $object->$key;
        if(is_string($meta))
            $meta = json_decode($meta);

        foreach(self::$metas as $met)
            $object->{'meta-'.$met} = $meta->$met ?? '';

        $keywords = 'meta-keywords';

        if(!$object->$keywords)
            $object->$keywords = [];
        if(is_string($object->$keywords))
            $object->$keywords = json_decode($object->$keywords);
    }

    static function combine(object &$object, string $key): void{
        $object->$key = [];
        foreach(self::$metas as $met){
            $mkey = 'meta-'.$met;
            $object->$key[$met] = $object->$mkey;
            unset($object->$mkey);
        }

        if(is_array($object->$key['keywords']))
            $object->$key['keywords'] = implode(',', $object->$key['keywords']);

        $object->$key = json_encode($object->$key);
    }
}