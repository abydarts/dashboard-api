<?php
/**
 * Api base middleware
 * @package api
 * @version 0.0.2
 */

namespace Api;

use Api\Library\Handler;

class Middleware extends \Mim\Middleware
{
    public function resp(int $error=0, $data=null, string $message=null, array $meta=null): void{
        Handler::resp($this, $error, $data, $message, $meta);
    }
}