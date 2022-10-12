<?php
/**
 * StaticPage
 * @package static-page
 * @version 0.0.1
 */

namespace StaticPage\Model;

class StaticPage extends \Mim\Model
{

    protected static $table = 'static_page';

    protected static $chains = [];

    protected static $q = ['title'];
}