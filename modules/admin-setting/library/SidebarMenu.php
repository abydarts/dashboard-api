<?php
/**
 * SidebarMenu
 * @package admin-setting
 * @version 0.0.1
 */

namespace AdminSetting\Library;


class SidebarMenu implements \AdminUi\Iface\SidebarMenu{

    static function getSidebarMenu(array $params): array{
        $menus = \Mim::$app->config->adminSetting->menus;
        $found = false;
        $can_i = &\Mim::$app->can_i;

        foreach($menus as $menu){
            if($can_i->{$menu->perm}){
                $found = true;
                break;
            }
        }

        if(!$found)
            return [];

        return [
            (object)[
                'label' => 'Setting',
                'icon'  => '<i class="fas fa-tools"></i>',
                'link'  => \Mim::$app->router->to('adminSetting'),
                'id'    => 'admin-setting',
                'filterable' => true,
                'visible'    => true,
                'priority'   => 0
            ]
        ];
    }
}