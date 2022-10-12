<?php
/**
 * Menu
 * @package admin-ui
 * @version 0.0.1
 */

namespace AdminUi\Library;
use StableSort\StableSort as SSort;

class Menu
{
    private static $sidebar;
    private static $sidebar_flat = [];

    private static function parseSidebar(array $meta): void{
        $sidebar_menu = [];

        $handlers = (array)\Mim::$app->config->adminUi->sidebarMenu->handlers;
        $items    = (array)\Mim::$app->config->adminUi->sidebarMenu->items;

        $result = self::parseSidebarRecursive($meta, $handlers, $items, 'none', 'Admin');

        self::$sidebar = $result;
    }

    private static function parseSidebarRecursive(array $meta, array $handlers, array $items, string $parent, string $bcumb): array{
        $result = [];

        $def_props = [
            'priority'   => 0,
            'filterable' => true,
            'visible'    => true,
            'route'      => ['adminHome']
        ];

        foreach($items as $id => $menu){
            foreach($def_props as $prop => $def)
                $menu->$prop = $menu->$prop ?? $def;
            
            $menu->id = $id;
            if(isset($menu->perms)){
                if(!\Mim::$app->can_i->{$menu->perms})
                    continue;
            }
            if(isset($menu->route)){
                $menu->link = to_route($menu->route);
                unset($menu->route);
            }

            $result[$menu->id] = $menu;
        }

        if(isset($handlers[$parent])){
            foreach($handlers[$parent] as $class){
                $menus = $class::getSidebarMenu($meta);
                if(!$menus)
                    continue;
                foreach($menus as $menu)
                    $result[$menu->id] = $menu;
            }
        }

        // find the children
        SSort::usort($result, function($a,$b){
            if($b->priority != $a->priority)
                return $b->priority - $a->priority;
            return strcmp($a->label, $b->label);
        });

        $rem_menu = [];
        foreach($result as $index => &$menu){
            $menu->bcumb = $bcumb;

            self::$sidebar_flat[] = $menu;

            if(!isset($menu->children) && !isset($handlers[$menu->id]))
                continue;

            $next_bcumb = $bcumb . ' / ' . $menu->label;
            $children = self::parseSidebarRecursive($meta, $handlers, (array)($menu->children??[]), $menu->id, $next_bcumb);
            if($children)
                $menu->children = $children;
            else
                $rem_menu[] = $index;
        }
        unset($menu);

        if($rem_menu){
            foreach($rem_menu as $idx)
                unset($result[$idx]);
        }
        
        return $result;
    }

    static function getFlatSidebar(array $meta): array{
        if(is_null(self::$sidebar))
            self::parseSidebar($meta);
        return self::$sidebar_flat;
    }

    static function getTreeSidebar(array $meta): array{
        if(is_null(self::$sidebar))
            self::parseSidebar($meta);
        return self::$sidebar;
    }

    static function getNavbar(array $meta){
        // navbar menu
        $navbar_menu = [];
        $handlers = (array)\Mim::$app->config->adminUi->navbarMenu->handlers;
        $handlers = group_by_prop($handlers, 'parent');

        if(!isset($handlers['none']))
            return [];

        $main_handlers = $handlers['none'];

        foreach($main_handlers as $main_handler){
            $main_class = $main_handler->class;
            $main_menus = $main_class::getNavbarMenu($main_handler, $meta);
            if(!$main_menus)
                continue;

            foreach($main_menus as $main_menu){
                if(isset($handlers[$main_menu->id])){
                    if(!isset($main_menu->children))
                        $main_menu->children = [];

                    $sub_handlers = $handlers[$main_menu->id];
                    foreach($sub_handlers as $sub_handler){
                        $sub_class = $sub_handler->class;
                        $sub_menus = $sub_class::getSubNavbarMenu($sub_handler, $main_menu, $meta);
                        if(!$sub_menus)
                            continue;

                        foreach($sub_menus as $sub_menu)
                            $main_menu->children[] = $sub_menu;
                    }

                    if($main_menu->children){
                        SSort::usort($main_menu->children, function($a,$b){
                            if($b->priority != $a->priority)
                                return $b->priority - $a->priority;
                            return strcmp($a->label, $b->label);
                        });
                    }
                }
                $navbar_menu[] = $main_menu;
            }
        }

        if($navbar_menu){
            SSort::usort($navbar_menu, function($a,$b){
                if($b->priority != $a->priority)
                    return $b->priority - $a->priority;
                return strcmp($a->label, $b->label);
            });
        }
        
        $result = [];

        // let filter the separator
        foreach($navbar_menu as $menus){
            if(isset($menus->children)){
                
                $last_menu = null;
                $separator = null;

                $final_children = [];
                foreach($menus->children as $menu){
                    if($menu->label !== '---'){
                        if($separator && $last_menu){
                            $final_children[] = $separator;
                            $separator = null;
                        }
                        $last_menu = $menu;
                        $final_children[] = $menu;
                    }else{
                        $separator = $menu;
                    }
                }

                $menus->children = $final_children;
            }

            $result[] = $menus;
        }

        return $result;
    }
}