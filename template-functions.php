<?php

if ( !function_exists('lis_print_lang_value') ) {
    function lis_print_lang_value($value, $lang_code){
        $lang_code = substr($lang_code,0,2);
        if ( is_array($value) ){
            foreach($value as $current_value){
                $print_values[] = lis_get_lang_value($current_value, $lang_code);
            }
            echo implode(', ', $print_values);
        }else{
            echo lis_get_lang_value($value, $lang_code);
        }
        return;
    }
}

if ( !function_exists('lis_get_lang_value') ) {
    function lis_get_lang_value($string, $lang_code, $default_lang_code = 'en'){
        $lang_value = array();
        $occs = preg_split('/\|/', $string);

        foreach ($occs as $occ){
            $re_sep = (strpos($occ, '~') !== false ? '/\~/' : '/\^/');
            $lv = preg_split($re_sep, $occ);
            $lang = substr($lv[0],0,2);
            $value = $lv[1];
            $lang_value[$lang] = $value;
        }

        if ( isset($lang_value[$lang_code]) ){
            $translated = $lang_value[$lang_code];
        } elseif ( isset($lang_value[$default_lang_code]) ){
            $translated = $lang_value[$default_lang_code];
        } else {
            $translated = ltrim(strstr($string, '^'), '^');
            if ( !$translated ) $translated = $string;
        }

        return $translated;
    }
}

if ( !function_exists('print_formated_date') ) {
    function print_formated_date($string){
        echo substr($string,6,2)  . '/' . substr($string,4,2) . '/' . substr($string,0,4);
    }
}

if ( !function_exists('isUTF8') ) {
    function isUTF8($string){
        return (utf8_encode(utf8_decode($string)) == $string);
    }
}

if ( !function_exists('get_site_meta_tags') ) {
    function get_site_meta_tags($url){

        $site_title = array();

        $fp = @file_get_contents($url);

        if ($fp) {
            $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
            if ($res) {
                $site_title = preg_replace('/\s+/', ' ', $title_matches[1]);
                $site_title = trim($site_title);
            }

            $site_meta_tags = get_meta_tags($url);
            $site_meta_tags['title'] = $site_title;

            foreach ($site_meta_tags as $key => $value) {
                if (!isUTF8($value)){
                    $site_meta_tags[$key] = utf8_encode($value);
                }
            }
        }
        return $site_meta_tags;
    }
}

if ( !function_exists('real_site_url') ) {
    function real_site_url($path = ''){

        $site_url = get_site_url();

        // check for multi-language-framework plugin
        if ( function_exists('mlf_parseURL') ) {
            global $mlf_config;

            $current_language = substr( strtolower(get_bloginfo('language')),0,2 );

            if ( $mlf_config['default_language'] != $current_language ){
                $site_url .= '/' . $current_language;
            }
        }
        // check for polylang plugin
        elseif ( defined( 'POLYLANG_VERSION' ) ) {
            $default_language = pll_default_language();
            $current_language = pll_current_language();

            if ( $default_language != $current_language ){
                $site_url .= '/' . $current_language;
            }
        }

        if ($path != ''){
            $site_url .= '/' . $path;
        }

        $site_url .= '/';

        return $site_url;
    }
}

?>
