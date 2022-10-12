<?php
/**
 * Matches
 * @package match
 * @version 0.0.1
 */

namespace Match\Model;

class Matches extends \Mim\Model
{
    const STATUS_DELETED = 0;
    const STATUS_COMING_SOON = 1;
    const STATUS_LIVE = 2;
    const STATUS_EXPIRED = 3;

    protected static $table = 'match';

    protected static $chains = [];

    protected static $q = [];
}