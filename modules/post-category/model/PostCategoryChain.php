<?php
/**
 * PostCategoryChain
 * @package post-category
 * @version 0.0.1
 */

namespace PostCategory\Model;

class PostCategoryChain extends \Mim\Model
{

    protected static $table = 'post_category_chain';

    protected static $chains = [
        'post' => [
            'model' => 'Post\\Model\\Post',
            'field' => 'id'
        ]
    ];

    protected static $q = [];
}