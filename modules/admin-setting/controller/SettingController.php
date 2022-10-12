<?php
/**
 * SettingController
 * @package admin-setting
 * @version 0.0.1
 */

namespace AdminSetting\Controller;


class SettingController extends \Admin\Controller
{
    public function indexAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);

        $menus = (array)$this->config->adminSetting->menus;
        $menus = array_filter($menus, function($val){ return $this->can_i->{$val->perm}; });
        uasort($menus, function($a,$b){ return $a->index - $b->index; });

        $params = [
            '_meta' => [
                'title' => 'System Settings',
                'menus' => ['admin-setting']
            ],
            'menus' => array_chunk($menus, 2, true)
        ];
        
        return $this->resp('admin-setting/index', $params);
    }
}