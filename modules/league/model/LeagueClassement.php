<?php
/**
 * LeagueClassement
 * @package league
 * @version 0.0.1
 */

namespace League\Model;

class LeagueClassement extends \Mim\Model
{

    protected static $table = 'league_classement';

    protected static $chains = [
        'league' => [
            'model' => 'League\\Model\\League',
            'field' => 'id'
        ]
    ];

    protected static $q = [];
}