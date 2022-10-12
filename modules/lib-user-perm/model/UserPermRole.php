<?php
/**
 * UserPermRole
 * @package lib-user-perm
 * @version 0.0.1
 */

namespace LibUserPerm\Model;

class UserPermRole extends \Mim\Model
{

    protected static $table = 'user_perm_role';

    protected static $chains = [];

    protected static $q = ['name'];
}