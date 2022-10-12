<?php
/**
 * Response
 * @package api
 * @version 0.0.3
 */

namespace Api\Iface;


interface Response
{
    static function resp(object $self, int $error=0, $data=null, string $message=null, array $meta=null): array;
}