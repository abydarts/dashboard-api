<?php
/**
 * NavbarMenu
 * @package admin-ui
 * @version 0.0.1
 */

namespace AdminUi\Iface;

interface NavbarMenu
{
    static function getNavbarMenu(object $menu, array $params): array;

    static function getSubNavbarMenu(object $menu, object $parent, array $params): array;
}