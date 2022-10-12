<?php
/**
 * Filter
 * @package admin-team
 * @version 0.0.1
 */

namespace AdminTeam\Library;

use Team\Model\Team;

class Filter implements \Admin\Iface\ObjectFilter
{
    static function filter(array $cond): ?array{
        $cnd = [];
        if(isset($cond['q']) && $cond['q'])
            $cnd['q'] = (string)$cond['q'];
        $teams = Team::get($cnd, 15, 1, ['title'=>true]);
        if(!$teams)
            return [];

        $result = [];
        foreach($teams as $team){
            $result[] = [
                'id'    => (int)$team->id,
                'label' => $team->title,
                'info'  => $team->title,
                'icon'  => NULL
            ];
        }

        return $result;
    }

    static function lastError(): ?string{
        return null;
    }
}