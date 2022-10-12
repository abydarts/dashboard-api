<?php
/**
 * Feed
 * @package lib-robot
 * @version 0.0.1
 */

namespace LibRobot\Library;

class Feed
{
    static function render(array $data, object $options): void{
        $escapes = [
            'description',
            'title',
            'host',
            'self_url'
        ];
        foreach($escapes as $key){
            if(isset($options->$key))
                $options->$key = hs($options->$key);
        }

        $options->created = date('r', strtotime(\Mim::$app->config->install));
        $options->updated = date('r');

        $params = [
            'pages'     => $data,
            'options'   => $options
        ];

        $newest_update = 0;
        foreach($data as $page){
            $update = strtotime($page->updated);
            if($update > $newest_update)
                $newest_update = $update;
        }

        $params['options']->updated = date('r', $newest_update);

        \Mim::$app->res->addHeader('Content-Type', 'application/xml; charset=UTF-8');
        \Mim::$app->res->render('robot/feed', $params);
    }
}