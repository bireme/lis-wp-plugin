﻿<?php

class Paginator{
    var $total;
    var $start;
    var $output;
    var $pag = array();
    var $default_count = 10;
    var $current_page;

    function __construct($total, $start)
    {
        $this->total = $total;
        $this->start = $start;
        $this->count = ( !empty($_GET['count'] ) ? $_GET['count'] : $this->default_count );
        $this->current_page = ( !empty($_GET['pg'] ) ? $_GET['pg'] : 1);
    }

    function paginate($page_url_params){
        $pag['total'] = $this->total;
        $pag['total_formatted'] = number_format($pag['total'], 0, ',', '.');
        $pag['start'] = $this->start;
        $pag['total_pages'] = (($pag['total']/$this->count) % $this->count == 0) ? (int)($pag['total']/$this->count) : (int)($pag['total']/$this->count+1);
        $pag['count'] = $this->count;

        $range_min = (($this->current_page-5) > 0) ? $this->current_page-5 : 1;
        $range_max = (($range_min+7) > $pag['total_pages']) ? $pag['total_pages'] : $range_min+7;
        $pag['pages'] = range($range_min, $range_max);


        $this->output  = '<div class="pagination pagination-centered">';
        $this->output .= '<ul>';
        if ($pag['total_pages'] > 0){
            if ($this->current_page > 1){
                $this->output .= '<li><a href="' . $page_url_params . '&pg=1" title="' . __('go to page', 'lis') . ' 1">&laquo;&laquo;</a></li>';
                $this->output .= '<li><a href="' . $page_url_params . '&pg=' . ($this->current_page-1) . '" title="' .  __('go to page', 'lis') . ' ' . ($this->current_page-1) . '"> &laquo; </a></li>';
            }else{
                $this->output .= '<li class="disabled"><a href="#">&laquo;&laquo;</a></li>';
                $this->output .= '<li class="disabled"><a href="#"> &laquo; </a></li>';
            }

            for ($i=0; $i < count($pag['pages']); $i++){
                $for_page = $pag['pages'][$i];

                if ( $this->current_page != '' ){
                    if ($this->current_page != $for_page){
                        $this->output .= '<li><a href="' . $page_url_params . '&pg=' . $for_page . '" title="' . __('go to page','lis') . ' ' . $for_page . '">' . $for_page . '</a></li>';
                    }else{
                        $this->output .= '<li class="active"><a href="#">' . $for_page .'</a></li>';
                    }
                }else{
                    if ($for_page != 1){
                        $this->output .= '<li><a href="' . $page_url_params . '&pg=' . $for_page . '" title="' . __('go to page','lis') . ' ' . $for_page . '">' .$for_page . '</a></li>';
                    }else{
                        $this->output .= '<li> class="active"><a href="#">' . $for_page .'</a></li>';
                    }
                }
            }

            if ( $this->current_page != '' ){
                if ($this->current_page < $pag['total_pages']) {
                    $this->output .= '<li><a href="' . $page_url_params . '&pg=' . ($this->current_page+1) . '" title="' . __('go to page', 'lis') . ($this->current_page+1) . '"> &raquo; </a></li>';
                    $this->output .= '<li><a href="' . $page_url_params . '&pg=' . ($pag['total_pages']) . '" title="' . __('go to page', 'lis') . $pag['total_pages'] . '">&raquo;&raquo;</a></li>';
                }else{
                    $this->output .= '<li class="disabled"><a href="#">&raquo;</a></li>';
                    $this->output .= '<li class="disabled"><a href="#"> &raquo;&raquo; </a></li>';
                }
            } else {
                $this->output .= '<li><a href="' . $page_url_params . '&pg=2" title="' . __('go to page', 'lis') . ' 2"> &raquo; </a></li>';
                $this->output .= '<li><a href="' . $page_url_params . '&pg=' . $pag['total_pages'] .'" title="' . __('go to page') . ' ' . $pag['total_pages'] . '">&raquo;&raquo;</a></li>';
            }

        }

        $this->output .= '</ul>';
        $this->output .= '</div>';

    }


    function display_pages(){
        return $this->output;
    }
}
?>
