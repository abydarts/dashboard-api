<?php
/**
 * CanI
 * @package lib-user-perm
 * @version 0.0.1
 */

namespace LibUserPerm\Service;

use \LibUserPerm\Model\{
    UserPerm as UPerm,
    UserPermChain as UPChain,
    UserPermRole as UPRole,
    UserPermRoleChain as UPRChain
};

class CanI extends \Mim\Service
{

    private $perms = null;

    private function prepare(): void{
        $this->perms = [];
        if(!\Mim::$app->user->isLogin())
            return;

        $role = \Mim::$app->user->role;
        $user = \Mim::$app->user->id;

        // by perms
        if(!$role){
            $perms = UPChain::get(['user'=>$user]);
        // by role
        }else{
            $perms = UPRChain::get(['role'=>$role]);
        }

        if(!$perms)
            return;

        $perm_ids = array_column($perms, 'perm');
        $perms = UPerm::get(['id'=>$perm_ids]);
        if($perms)
            $this->perms = array_column($perms, 'name');
    }

    public function __get($name): bool{
        if(is_null($this->perms))
            $this->prepare();
        return in_array($name, $this->perms);
    }
}