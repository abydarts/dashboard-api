<?php
/**
 * Paginator constructor
 * @package lib-pagination
 * @version 0.0.1
 */

namespace LibPagination\Library;

class Paginator implements \Iterator
{
    private $position = 0;
    private $pages = [];

    private $first;
    private $last;
    private $prev;
    private $next;

    public function __construct(
        string $base_url,
        int $total_items,
        int $current_page = 1,
        int $items_per_page = 12,
        int $page_link_to_show = 10,
        array $query_parameters = [],
        string $prev_label = '&#171;',
        string $next_label = '&#187;'
    ){
        if($items_per_page >= $total_items)
            return;

        $total_page = ceil($total_items / $items_per_page);

        $first_page = $current_page - floor( $page_link_to_show / 2 );
        if($first_page < 1)
            $first_page = 1;

        $last_page = $first_page + ( $page_link_to_show - 1 );
        if($last_page > $total_page)
            $last_page = $total_page;

        $first_page = $last_page - ( $page_link_to_show - 1 );
        if($first_page < 1)
            $first_page = 1;

        // prev link
        $prev = $current_page - 1;
        if($prev < 1)
            $prev = 0;

        $this->pages[] = $this->prev = new Page($base_url, $prev_label, $prev, $query_parameters, true, false);

        // in between pages
        for($i=$first_page;$i<=$last_page;$i++){
            $i_page = $i;
            if($i == $current_page)
                $i_page = 0;
            $this->pages[] = new Page($base_url, (string)$i, $i_page, $query_parameters);
        }

        // next link
        $next = $current_page + 1;
        if($next > $total_page)
            $next = 0;
        $this->pages[] = $this->next = new Page($base_url, $next_label, $next, $query_parameters, false, true);

        // last link
        $this->last = new Page($base_url, (string)$total_page, $total_page, $query_parameters);

        // fist link
        $this->first = new Page($base_url, (string)'1', 1, $query_parameters);
    }

    public function rewind(){
        $this->position = 0;
    }

    public function current(){
        return $this->pages[$this->position];
    }

    public function key(){
        return $this->position;
    }

    public function next(){
        ++$this->position;
    }

    public function valid(){
        return isset($this->pages[$this->position]);
    }

    public function getFirst(): ?object{
        return $this->first;
    }

    public function getNext(): ?object{
        return $this->next;
    }

    public function getLast(): ?object{
        return $this->last;
    }

    public function getPrev(): ?object{
        return $this->prev;
    }
}