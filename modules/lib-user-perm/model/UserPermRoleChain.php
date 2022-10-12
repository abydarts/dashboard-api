<?php
/**
 * UserPermRoleChain
 * @package lib-user-perm
 * @version 0.0.1
 */

namespace LibUserPerm\Model;

class UserPermRoleChain extends \Mim\Model
{

    protected static $table = 'user_perm_role_chain';

    protected static $chains = [];

    protected static $q = [];
}