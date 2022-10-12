<?php
/**
 * SettingController
 * @package admin-site-setting
 * @version 0.0.1
 */

namespace AdminSiteSetting\Controller;

use SiteSetting\Model\SiteSetting as SSetting;
use LibForm\Library\Form;

class SettingController extends \Admin\Controller
{
    public function editAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->update_site_setting)
            return $this->show404();

        $name  = urldecode($this->req->param->group);
        $group = (object)['name'=>$name];

        $items = SSetting::get(['group'=>$name], 0, 1, ['name'=>'ASC']) ?? [];
        $item  = null;
        $id    = $this->req->param->item;
        foreach($items as $itm){
            if($itm->id == $id){
                $item = $itm;
                break;
            }
        }

        if(!$item)
            return $this->show404();

        // let construct the form
        $ffields = (object)[
            'value' => (object)[
                'label'     => $item->name,
                'nolabel'   => true,
                'type'      => 'text',
                'rules'     => []
            ]
        ];
        switch($item->type){
            case '2':
                $ffields->value->type = 'date';
                break;
            case '3':
                $ffields->value->type = 'number';
                break;
            case '4':
                $ffields->value->type = 'select';
                $ffields->value->options = (object)['No','Yes'];
                break;
            case '5':
                $ffields->value->type = 'textarea';
                break;
            case '6':
                $ffields->value->type = 'url';
                break;
            case '7':
                $ffields->value->type = 'email';
                break;
            case '8':
                $ffields->value->type = 'color';
                break;
        }
        $this->config->libForm->forms->site_setting = $ffields;

        $form = new Form('site_setting');

        $params = [
            '_meta' => [
                'title' => 'System Settings',
                'menus' => ['admin-setting']
            ],
            'items' => $items,
            'item'  => $item,
            'group' => $group,
            'form'  => $form
        ];

        if(!($valid = $form->validate($item)) || !$form->csrfTest('noob'))
            return $this->resp('site-setting/edit', $params);

        $set = ['value' => ($valid->value ?? '')];
        if(!SSetting::set($set, ['id'=>$item->id]))
            deb(SSetting::lastError());

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $item->id,
            'parent' => 0,
            'method' => 2,
            'type'   => 'site_setting',
            'original' => $item,
            'changes'  => $valid
        ]);
        
        if(module_exists('lib-event'))
            $this->event->trigger('site-setting:updated', $item);

        $next = $this->router->to('adminSiteSettingSingle', ['group'=>$name], ['saved'=>$item->id]);
        $this->res->redirect($next);
    }

    public function singleAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->read_site_setting)
            return $this->show404();

        $name  = urldecode($this->req->param->group);
        $group = (object)['name'=>$name];

        $items = SSetting::get(['group'=>$name], 0, 1, ['name'=>'ASC']) ?? [];
        if(!$items)
            return $this->show404();

        $params = [
            '_meta' => [
                'title' => 'System Settings',
                'menus' => ['admin-setting']
            ],
            'items' => $items,
            'group' => $group,
            'saved' => $this->req->getQuery('saved')
        ];

        return $this->resp('site-setting/single', $params);
    }
}