<?php
/*
Plugin Name: LIS
Plugin URI: http://reddes.bvsalud.org/projects/lis/
Description: Create a Health Information Locator Site
Author: BIREME/OPAS/OMS
Version: 0.2
Author URI: http://reddes.bvsalud.org/
*/

define('LIS_VERSION', '0.4' );

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
require_once(LIS_PLUGIN_PATH . '/template-functions.php');


if(!class_exists('LIS_Plugin')) {
    class LIS_Plugin {
        private $plugin_slug = 'lis';
        private $service_url = 'https://fi-admin.bvsalud.org/';
        private $similar_docs_url = 'http://similardocs.bireme.org/SDService';
        /**
         * Construct the plugin object
         */
        public function __construct() {
            // register actions
            add_action( 'init', array(&$this, 'load_translation'));
            add_action( 'admin_menu', array(&$this, 'admin_menu'));
            add_action( 'plugins_loaded', array(&$this, 'plugin_init'));
            add_action( 'wp_head', array(&$this, 'google_analytics_code'));
            add_action( 'template_redirect', array(&$this, 'template_redirect'));
            add_action( 'widgets_init', array(&$this, 'register_sidebars'));
            add_filter( 'get_search_form', array(&$this, 'search_form'));
            add_filter( 'document_title_parts', array(&$this, 'theme_slug_render_title'));
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate
        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate


        function load_translation(){
            // Translations
            load_plugin_textdomain( 'lis', false,  LIS_PLUGIN_DIR . '/languages' );
        }

        function plugin_init() {
            global $plugin_slug;
            $lis_config = get_option('lis_config');

            if ($lis_config && $lis_config['plugin_slug'] != ''){
                $this->plugin_slug = $lis_config['plugin_slug'];
            }
        }

        function admin_menu() {
            add_options_page(__('LIS Settings', 'lis'), __('LIS', 'lis'), 'manage_options', 'lis.php', 'lis_page_admin');
            //call register settings function
            add_action( 'admin_init', array(&$this, 'register_settings'));
        }

        function template_redirect() {
            global $wp, $lis_plugin_slug, $lis_service_url;

            // check if request contains plugin slug string
            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);
            }

            if ( is_404() && $pos_slug !== false ){
                $lis_service_url = $this->service_url;
                $lis_plugin_slug = $this->plugin_slug;

                if ($pagename == $this->plugin_slug || $pagename == $this->plugin_slug . '/resource'
                    || $pagename == $this->plugin_slug . '/suggest-site'
                    || $pagename == $this->plugin_slug . '/suggest-site-details'
                    || $pagename == $this->plugin_slug . '/lis-feed'
                    ) {

                    add_action( 'wp_enqueue_scripts', array(&$this, 'page_template_styles_scripts'));

                    if ($pagename == $this->plugin_slug){
                        $template = LIS_PLUGIN_PATH . '/template/lis-home.php';
                    }elseif ($pagename == $this->plugin_slug . '/suggest-site'){
                        $template = LIS_PLUGIN_PATH . '/template/lis-suggest-site.php';
                    }elseif ($pagename == $this->plugin_slug . '/suggest-site-details'){
                        $template = LIS_PLUGIN_PATH . '/template/lis-suggest-site-details.php';
                    }elseif ($pagename == $this->plugin_slug . '/lis-feed'){
                        header("Content-Type: text/xml; charset=UTF-8");
                        $template = LIS_PLUGIN_PATH . '/template/rss.php';
                    }else{
                        $template = LIS_PLUGIN_PATH . '/template/lis-resource.php';
                    }
                    // force status to 200 - OK
                    status_header(200);

                    // redirect to page and finish execution
                    include($template);
                    die();
                }
            }
        }

        function register_sidebars(){
            $args = array(
                'name' => __('LIS sidebar', 'lis'),
                'id'   => 'lis-home',
                'description' => 'LIS Area',
                'before_widget' => '<section id="%1$s" class="row-fluid marginbottom25 widget_categories">',
                'after_widget'  => '</section>',
                'before_title'  => '<header class="row-fluid border-bottom marginbottom15"><h1 class="h1-header">',
                'after_title'   => '</h1></header>',
            );
            register_sidebar( $args );
        }

        function theme_slug_render_title( $title_parts ) {
            global $wp, $lis_plugin_title;

            $pagename = '';
            // check if request contains plugin slug string
            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);
            }
            if ( is_404() && $pos_slug !== false ){
                $lis_config = get_option('lis_config');
                if ( function_exists( 'pll_the_languages' ) ) {
                    $current_lang = pll_current_language();
                    $lis_plugin_title = $lis_config['plugin_title_' . $current_lang];
                }else{
                    $lis_plugin_title = $lis_config['plugin_title'];
                }
                $title_parts['title'] = $lis_plugin_title . " | " . get_bloginfo('name');
            }

            return $title_parts;
        }

        function search_form( $form ) {
            global $wp;

            $pagename = '';
            // check if request contains plugin slug string
            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);
            }

            if ($pagename == $this->plugin_slug || $pagename == $this->plugin_slug .'/resource') {
                $form = preg_replace('/action="([^"]*)"(.*)/','action="' . home_url($this->plugin_slug) . '"',$form);
            }
            return $form;
        }

        function page_template_styles_scripts(){
            wp_enqueue_script('lis-page',    LIS_PLUGIN_URL . 'template/js/functions.js');
            wp_enqueue_script('jquery-raty', LIS_PLUGIN_URL . 'template/js/jquery.raty.min.js', array( 'jquery' ));
            wp_enqueue_style ('lis-page',    LIS_PLUGIN_URL . 'template/css/style.css');
        }

        function register_settings(){
            register_setting('lis-settings-group', 'lis_config');
            wp_enqueue_style ('lis_config' ,  LIS_PLUGIN_URL . 'template/css/admin.css');
            wp_enqueue_script('lis_config' ,  LIS_PLUGIN_URL . 'template/js/jquery-ui.js');
        }

        function google_analytics_code(){
            global $wp;

            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);

                $lis_config = get_option('lis_config');
                // check if is defined GA code and pagename starts with plugin slug
                if ($lis_config['google_analytics_code'] != ''
                    && strpos($pagename, $this->plugin_slug) === 0){

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
              } //endif lis_config
           }// endif pos_slug
        } // end function google_analytics_code

    } // END class LIS_Plugin
} // END if(!class_exists('LIS_Plugin'))

if(class_exists('LIS_Plugin'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('LIS_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('LIS_Plugin', 'deactivate'));
    // instantiate the plugin class
    $wp_plugin_template = new LIS_Plugin();
}

?>
