<?php
/**
 * Banner
 * @package banner
 * @version 0.0.1
 */

namespace Banner\Model;

class Banner extends \Mim\Model
{

    protected static $table = 'banner';

    protected static $chains = [];

    protected static $q = ['name'];
}