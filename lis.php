<?php
/*
Plugin Name: LIS
Plugin URI: http://reddes.bvsalud.org/projects/lis/
Description: Create a Health Information Locator Site
Author: BIREME/OPAS/OMS
Version: 0.1
Author URI: http://reddes.bvsalud.org/
*/

define('LIS_VERSION', '0.1' );

define('LIS_SYMBOLIC_LINK', false );
define('LIS_PLUGIN_DIRNAME', 'lis-page' );

if(LIS_SYMBOLIC_LINK == true) {
    define('LIS_PLUGIN_PATH',  ABSPATH . 'wp-content/plugins/' . LIS_PLUGIN_DIRNAME );
} else {
    define('LIS_PLUGIN_PATH',  plugin_dir_path(__FILE__) );
}

define('LIS_PLUGIN_DIR',   plugin_basename( LIS_PLUGIN_PATH ) );
define('LIS_PLUGIN_URL',   plugin_dir_url(__FILE__) );


require_once(LIS_PLUGIN_PATH . '/settings.php');

function lis_theme_redirect() {
    global $wp;
    $pagename = $wp->query_vars["pagename"];

    if ($pagename == 'lis' || $pagename == 'lis/resource') {
        add_action( 'wp_enqueue_scripts', 'page_template_styles_scripts' );

        if ($pagename == 'lis'){
            $template = LIS_PLUGIN_PATH . '/template/lis-home.php';
        }else{
            $template = LIS_PLUGIN_PATH . '/template/lis-resource.php';
        }
        // redirect to page and finish execution
        include($template);
        die();
    }
}

function page_template_styles_scripts(){
    wp_enqueue_script('lis-page',    LIS_PLUGIN_URL . 'template/js/functions.js');
    wp_enqueue_script('jquery-raty', LIS_PLUGIN_URL . 'template/js/jquery.raty.min.js', array( 'jquery' ));
    wp_enqueue_style ('lis-page',    LIS_PLUGIN_URL . 'template/css/style.css');
}

function lis_init() {

}

function lis_load_translation(){
    // Translations
    load_plugin_textdomain( 'lis', false,  LIS_PLUGIN_DIR . '/languages' );
}

function lis_add_admin_menu() {

    add_submenu_page( 'options-general.php', __('LIS Settings', 'lis'), __('LIS', 'lis'), 'manage_options', 'lis',
                      'lis_page_admin');

    //call register settings function
    add_action( 'admin_init', 'lis_register_settings' );

}

function lis_register_settings(){

    register_setting('lis-settings-group', 'lis_config');

}

function lis_google_analytics_code(){
    $lis_config = get_option('lis_config');
    if ($lis_config['google_analytics_code'] != ''){
?>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $lis_config['google_analytics_code'] ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php
    } //endif
}

function lis_search_form( $form ) {
    global $wp;
    $pagename = $wp->query_vars["pagename"];


    if ($pagename == 'lis' || $pagename == 'lis/resource') {
        $form = preg_replace('/action="([^"]*)"(.*)/','action="' . home_url('lis/') . '"',$form);
    }

    return $form;
}


add_action( 'init', 'lis_load_translation' );
add_action( 'admin_menu', 'lis_add_admin_menu');
add_action( 'plugins_loaded','lis_init' );
add_action( 'wp_head', 'lis_google_analytics_code');
add_action( 'template_redirect', 'lis_theme_redirect');

add_filter( 'get_search_form', 'lis_search_form' );

?>
