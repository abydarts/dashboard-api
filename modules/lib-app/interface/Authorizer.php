<?php
/**
 * Authorizer
 * @package lib-app
 * @version 0.0.1
 */

namespace LibApp\Iface;

interface Authorizer
{

    static function hasScope(string $scope): bool;

    static function getAppId(): ?int;
}