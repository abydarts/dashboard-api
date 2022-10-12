<?php
/**
 * Filter
 * @package admin-match
 * @version 0.0.1
 */

namespace AdminMatch\Library;

use Match\Model\Matches;

class Filter implements \Admin\Iface\ObjectFilter
{
    static function filter(array $cond): ?array{
        $cnd = [];
        if(isset($cond['q']) && $cond['q'])
            $cnd['q'] = (string)$cond['q'];
        $matchs = Matches::get($cnd, 15, 1, ['title'=>true]);
        if(!$matchs)
            return [];

        $result = [];
        foreach($matchs as $match){
            $result[] = [
                'id'    => (int)$match->id,
                'label' => $match->title,
                'info'  => $match->title,
                'icon'  => NULL
            ];
        }

        return $result;
    }

    static function lastError(): ?string{
        return null;
    }
}