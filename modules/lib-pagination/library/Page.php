<?php
/**
 * Single page object
 * @package lib-pagination
 * @version 0.0.1
 */

namespace LibPagination\Library;

class Page
{
    private $label;
    private $link;
    private $active;
    private $prev_btn;
    private $next_btn;

    public function __construct(
        string $base_url,
        string $link_label,
        int    $page_number,
        array  $query_parameters = [],
        bool   $prev_btn = false,
        bool   $next_btn = false
    ){
        $this->label  = $link_label;
        $this->active = !$page_number;
        $this->prev_btn = $prev_btn;
        $this->next_btn = $next_btn;

        if($page_number === 0)
            $this->link = '#';
        else{
            if($page_number > 1)
                $query_parameters['page'] = $page_number;
            $used_url = '?' . http_build_query($query_parameters);
            if($page_number === 1)
                $used_url = $base_url . ($used_url==='?'?'':$used_url);
            $this->link = $used_url;
        }
    }

    public function __get($name){
        return $this->$name ?? null;
    }
}