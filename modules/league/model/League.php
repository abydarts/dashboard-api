<?php
/**
 * League
 * @package league
 * @version 0.0.1
 */

namespace League\Model;

class League extends \Mim\Model
{

    protected static $table = 'league';

    protected static $chains = [];

    protected static $q = ['title'];
}