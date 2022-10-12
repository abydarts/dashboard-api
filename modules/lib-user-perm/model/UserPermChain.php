<?php
/**
 * UserPermChain
 * @package lib-user-perm
 * @version 0.0.1
 */

namespace LibUserPerm\Model;

class UserPermChain extends \Mim\Model
{

    protected static $table = 'user_perm_chain';

    protected static $chains = [];

    protected static $q = [];
}