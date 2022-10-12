<?php
/**
 * Filter
 * @package admin-league
 * @version 0.0.1
 */

namespace AdminLeague\Library;

use League\Model\League;

class Filter implements \Admin\Iface\ObjectFilter
{
    static function filter(array $cond): ?array{
        $cnd = [];
        if(isset($cond['q']) && $cond['q'])
            $cnd['q'] = (string)$cond['q'];
        $leagues = League::get($cnd, 15, 1, ['title'=>true]);
        if(!$leagues)
            return [];

        $result = [];
        foreach($leagues as $league){
            $result[] = [
                'id'    => (int)$league->id,
                'label' => $league->title,
                'info'  => $league->title,
                'icon'  => NULL
            ];
        }

        return $result;
    }

    static function lastError(): ?string{
        return null;
    }
}