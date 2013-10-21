<?php

function print_lang_value($value, $lang_code){
    if ( is_array($value) ){
        foreach($value as $current_value){
            $print_values[] = get_lang_value($current_value, $lang_code);
        }
        echo implode(', ', $print_values);
    }else{
        echo get_lang_value($current_value, $lang_code);
    }
    return;
}

function get_lang_value($string, $lang_code){
    $lang_value = array();
    $occs = preg_split('/\|/', $string);
    
    foreach ($occs as $occ){
        $lv = preg_split('/\^/', $occ);
        $lang = $lv[0];
        $value = $lv[1];        
        $lang_value[$lang] = $value;        
    }
    return $lang_value[$lang_code];
}

function print_formated_date($string){

    echo substr($string,6,2)  . '/' . substr($string,4,2) . '/' . substr($string,0,4);

}



?>