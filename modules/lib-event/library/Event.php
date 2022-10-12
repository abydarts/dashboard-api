<?php
/**
 * Event registerer
 * @package lib-event
 * @version 0.0.1
 */

namespace LibEvent\Library;

class Event
{
    static function trigger(string $name, $data=null): void{
        self::bind($name, $data);
    }

    static function bind(string $name, $data=null): void{
        $event = \Mim::$app->config->libEvent->events;
        if(!isset($event->$name))
            return;
        $listeners = $event->$name;
        foreach($listeners as $handler => $use){
            if(!$use)
                continue;
            $hdrs = explode('::', $handler);
            $class = $hdrs[0];
            $method= $hdrs[1];

            $class::$method($data);
        }
    }
}