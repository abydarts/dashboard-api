<?php
/**
 * Lib event service
 * @package lib-event
 * @version 0.0.1
 */

namespace LibEvent\Service;

class Event extends \Mim\Service
{
    public function trigger(string $name, $data=null): void{
        \LibEvent\Library\Event::trigger($name, $data);
    }
}