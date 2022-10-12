<?php
/**
 * SidebarMenu
 * @package admin-ui
 * @version 0.0.1
 */

namespace AdminUi\Iface;

interface SidebarMenu
{
    static function getSidebarMenu(array $params): array;
}