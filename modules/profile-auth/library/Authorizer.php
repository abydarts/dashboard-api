<?php
/**
 * Authorizer
 * @package profile-auth
 * @version 0.1.0
 */

namespace ProfileAuth\Library;


class Authorizer
    implements 
        \LibApp\Iface\Authorizer
{

    static function hasScope(string $scope): bool {
        return false;
    }

    static function getAppId(): ?int {
        $session = \Mim::$app->profile->getSession();
        if(!$session)
            return null;
        if($session->app)
            return $session->app;
        return null;
    }
}