<?php
/**
 * PostCategory
 * @package post-category
 * @version 0.0.1
 */

namespace PostCategory\Model;

class PostCategory extends \Mim\Model
{

    protected static $table = 'post_category';

    protected static $chains = [];

    protected static $q = ['name'];
}