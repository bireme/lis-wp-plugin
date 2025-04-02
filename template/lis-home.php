<?php
/*
Template Name: LIS Home
*/
global $lis_service_url;

require_once(LIS_PLUGIN_PATH . '/lib/Paginator.php');

$lis_config = get_option('lis_config');
$lis_initial_filter = $lis_config['initial_filter'];

$site_language = strtolower(get_bloginfo('language'));
$lang_dir = substr($site_language,0,2);

// set query using default param q (query) or s (wordpress search) or newexpr (metaiah)
$query = sanitize_text_field($_GET['s'] . $_GET['q'] . $_GET['newexpr']);
$query = stripslashes( trim($query) );

$sanitize_user_filter = sanitize_text_field($_GET['filter']);
$user_filter = stripslashes($sanitize_user_filter);
$page = ( isset($_GET['pg']) ? sanitize_text_field($_GET['pg']) : 1 );
$total = 0;
$count = 10;
$filter = '';

if ($lis_initial_filter != ''){
    if ($user_filter != ''){
        $filter = $lis_initial_filter . ' AND ' . $user_filter;
    }else{
        $filter = $lis_initial_filter;
    }
}else{
    $filter = $user_filter;
}
$start = ($page * $count) - $count;

$lis_service_request = $lis_service_url . 'api/resource/search/?q=' . urlencode($query) . '&fq=' .urlencode($filter) . '&start=' . $start . '&lang=' . $lang_dir;

// echo "<pre>"; print_r($lis_service_request); echo "</pre>"; die();

$response = @file_get_contents($lis_service_request);
if ($response){
    $response_json = json_decode($response);
    // echo "<pre>"; print_r($response_json); echo "</pre>"; die();
    $total = $response_json->diaServerResponse[0]->response->numFound;
    $start = $response_json->diaServerResponse[0]->response->start;
    $resource_list = $response_json->diaServerResponse[0]->response->docs;
    $language_list = $response_json->diaServerResponse[0]->facet_counts->facet_fields->language;
    $descriptor_list = $response_json->diaServerResponse[0]->facet_counts->facet_fields->descriptor_filter;
    $thematic_area_list = $response_json->diaServerResponse[0]->facet_counts->facet_fields->thematic_area_display;
}

$page_url_params = real_site_url($lis_plugin_slug) . '?q=' . urlencode($query) . '&filter=' . urlencode($filter);
$feed_url = real_site_url($lis_plugin_slug) . 'lis-feed?q=' . urlencode($query) . '&filter=' . urlencode($filter);

$pages = new Paginator($total, $start);
$pages->paginate($page_url_params);

?>

<?php get_header('lis');?>
    <div id="content" class="row-fluid">
        <div class="ajusta2">
            <div class="row-fluid breadcrumb">
                <a href="<?php echo real_site_url(); ?>"><?php _e('Home','lis'); ?></a> >
                <?php if ($query == '' && $filter == ''): ?>
                    <?php _e('Health Information Locator', 'lis') ?>
                <?php else: ?>
                    <a href="<?php echo real_site_url($lis_plugin_slug); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> >
                    <?php _e('Search result', 'lis') ?>
                <?php endif; ?>
            </div>

<?php if ($lis_config['page_layout'] != 'whole_page' || $_GET['q'] != '' || $_GET['filter'] != '' ) : ?>

            <section id="conteudo">
                <?php if ( isset($total) && strval($total) == 0) :?>
                    <h1 class="h1-header"><?php _e('No results found','lis'); ?></h1>
                <?php else :?>
                    <header class="row-fluid border-bottom">
                        <?php if ( ( $query != '' || $user_filter != '' ) && strval($total) > 0) :?>
                           <h1 class="h1-header"><?php _e('Resources found','lis'); ?>: <?php echo $total; ?></h1>
                        <?php else: ?>
                           <h1 class="h1-header"><?php _e('Total of resources','lis'); echo ': ' . $total; ?></h1>
                        <?php endif; ?>
                        <div class="pull-right">
                            <a href="<?php echo $feed_url; ?>" target="blank"><img src="<?php echo LIS_PLUGIN_URL ?>template/images/icon_rss.png" class="rss_feed" /></a>
                        </div>
                    </header>
                    <div class="row-fluid">
                        <?php foreach ( $resource_list as $resource) { ?>
                            <article class="conteudo-loop">
                                <div class="row-fluid">
                                    <h2 class="h2-loop-tit"><?php echo $resource->title; ?></h2>
                                </div>
                                <div class="conteudo-loop-rates">
                                    <div class="star" data-score="1"></div>
                                </div>
                                <p class="row-fluid">
                                    <?php echo ( strlen($resource->abstract) > 200 ? substr($resource->abstract,0,200) . '...' : $resource->abstract); ?><br/>
                                    <span class="more"><a href="<?php echo real_site_url($lis_plugin_slug); ?>resource/?id=<?php echo $resource->django_id; ?>"><?php _e('See more details','lis'); ?></a></span>
                                </p>

                                <?php if ($resource->created_date): ?>
                                    <div id="conteudo-loop-data" class="row-fluid margintop05">
                                        <span class="conteudo-loop-data-tit"><?php _e('Resource added in','lis'); ?>:</span>
                                        <?php echo print_formated_date($resource->created_date); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($resource->source_language_display): ?>
                                    <div id="conteudo-loop-idiomas" class="row-fluid">
                                        <span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
                                        <?php lis_print_lang_value($resource->source_language_display, $site_language); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($resource->descriptor || $resource->keyword ) : ?>
                                    <div id="conteudo-loop-tags" class="row-fluid margintop10">
                                        <i class="ico-tags"> </i>
                                            <?php
                                                $descriptors = (array)$resource->descriptor;
                                                $keywords = (array)$resource->keyword;
                                            ?>
                                            <?php echo implode(", ", array_merge( $descriptors, $keywords) ); ?>
                                      </div>
                                <?php endif; ?>

                            </article>
                        <?php } ?>
                    </div>
                    <div class="row-fluid">
                        <?php echo $pages->display_pages(); ?>
                    </div>
                <?php endif; ?>
            </section>
            <aside id="sidebar">
                <section class="header-search">
                    <?php if ($lis_config['show_form']) : ?>
                        <form role="search" method="get" id="searchform" action="<?php echo real_site_url($lis_plugin_slug); ?>">
                            <input value='<?php echo $query ?>' name="q" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                            <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                        </form>
                    <?php endif; ?>
                </section>
                <a href="<?php echo real_site_url($lis_plugin_slug); ?>suggest-site" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>

                <?php dynamic_sidebar('lis-home');?>

                <?php
                    $order = explode(';', $lis_config['available_filter']);
                    foreach($order as $key => $value) {
                ?>

                <?php if ( $value == 'Subjects' ) : ?>
                    <section class="row-fluid marginbottom25 widget_categories">
                        <header class="row-fluid border-bottom marginbottom15">
                            <h1 class="h1-header"><?php _e('Subjects','lis'); ?></h1>
                        </header>
                        <ul class="filter-list">
                            <?php foreach ( $descriptor_list as $descriptor ) : ?>
                                <?php
                                    $filter_link = '?';
                                    if ($query != ''){
                                        $filter_link .= 'q=' . $query . '&';
                                    }
                                    $filter_link .= 'filter=descriptor:"' . $descriptor[0] . '"';
                                    if ($user_filter != ''){
                                        $filter_link .= ' AND ' . $user_filter ;
                                    }
                                ?>
                                <?php $class = ( filter_var($descriptor[0], FILTER_VALIDATE_INT) === false ) ? 'cat-item' : 'cat-item hide'; ?>
                                <li class="<?php echo $class; ?>">
                                    <a href='<?php echo $filter_link ?>'><?php echo $descriptor[0] ?></a>
                                    <span class="cat-item-count"><?php echo $descriptor[1] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ( count($descriptor_list) == 20 ) : ?>
                        <div class="show-more text-center">
                            <a href="javascript:void(0)" class="btn-ajax" data-fb="30" data-cluster="descriptor_filter"><?php _e('show more','lis'); ?></a>
                            <a href="javascript:void(0)" class="loading"><?php _e('loading','lis'); ?>...</a>
                        </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
                <?php if ( $value == 'Thematic area' ) : ?>
                    <section class="row-fluid marginbottom25 widget_categories">
                        <header class="row-fluid border-bottom marginbottom15">
                            <h1 class="h1-header"><?php _e('Thematic area','lis'); ?></h1>
                        </header>
                        <ul class="filter-list">
                        <?php foreach ( $thematic_area_list as $ta ) { ?>
                            <?php
                                $filter_link = '?';
                                if ($query != ''){
                                    $filter_link .= 'q=' . $query . '&';
                                }
                                $filter_link .= 'filter=thematic_area_display:"' . $ta[0] . '"';
                                if ($user_filter != ''){
                                    $filter_link .= ' AND ' . $user_filter ;
                                }
                            ?>
                            <li class="cat-item">
                                <a href='<?php echo $filter_link; ?>'><?php lis_print_lang_value($ta[0], $site_language); ?></a>
                                <span class="cat-item-count"><?php echo $ta[1] ?></span>
                            </li>
                        <?php } ?>
                        </ul>
                        <?php if ( count($thematic_area_list) == 20 ) : ?>
                        <div class="show-more text-center">
                            <a href="javascript:void(0)" class="btn-ajax" data-fb="30" data-cluster="thematic_area_display"><?php _e('show more','lis'); ?></a>
                            <a href="javascript:void(0)" class="loading"><?php _e('loading','lis'); ?>...</a>
                        </div>
                        <?php endif; ?>
                     </section>
                <?php endif; ?>
                <?php if ( $value == 'Language' ) : ?>
                    <section class="row-fluid marginbottom25 widget_categories">
                        <header class="row-fluid border-bottom marginbottom15">
                            <h1 class="h1-header"><?php _e('Language','lis'); ?></h1>
                        </header>
                        <ul class="filter-list">
                        <?php foreach ( $language_list as $language ) { ?>
                            <?php
                                $filter_link = '?';
                                if ($query != ''){
                                    $filter_link .= 'q=' . $query . '&';
                                }
                                $filter_link .= 'filter=language:"' . $language[0] . '"';
                                if ($user_filter != ''){
                                    $filter_link .= ' AND ' . $user_filter ;
                                }
                            ?>
                            <li class="cat-item">
                                <a href='<?php echo $filter_link; ?>'><?php lis_print_lang_value($language[0], $site_language); ?></a>
                                <span class="cat-item-count"><?php echo $language[1] ?></span>
                            </li>
                        <?php } ?>
                        </ul>
                        <?php if ( count($thematic_area_list) == 20 ) : ?>
                        <div class="show-more text-center">
                            <a href="javascript:void(0)" class="btn-ajax" data-fb="30" data-cluster="language"><?php _e('show more','lis'); ?></a>
                            <a href="javascript:void(0)" class="loading"><?php _e('loading','lis'); ?>...</a>
                        </div>
                        <?php endif; ?>
                     </section>
                <?php endif; ?>
            <?php } ?>
            </aside>

            <div class="spacer"></div>

<?php else : ?>

            <section id="">
                <?php if ( isset($total) && strval($total) == 0) :?>
                    <header class="row-fluid border-bottom">
                        <div class="list-header">
                            <h1 class="h1-header"><?php _e('No results found','lis'); ?></h1>
                            <?php if ($lis_config['show_form']) : ?>
                                <section class="header-search">
                                    <form role="search" method="get" id="searchform" action="<?php echo real_site_url($lis_plugin_slug); ?>">
                                        <input value='<?php echo $query; ?>' name="q" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                                        <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                                    </form>
                                </section>
                            <?php endif; ?>
                        </div>
                    </header>
                <?php else :?>
                    <header class="row-fluid border-bottom">
                        <div class="list-header">
                            <?php if ( ( $query != '' || $user_filter != '' ) && strval($total) > 0) :?>
                                <h1 class="h1-header"><?php _e('Resources found','lis'); ?>: <?php echo $total; ?></h1>
                            <?php else: ?>
                               <h1 class="h1-header"><?php _e('Total of resources','lis'); echo ': ' . $total; ?></h1>
                            <?php endif; ?>
                            <?php if ($lis_config['show_form']) : ?>
                                <section class="header-search">
                                    <form role="search" method="get" id="searchform" action="<?php echo real_site_url($lis_plugin_slug); ?>">
                                        <input value='<?php echo $query; ?>' name="q" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                                        <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                                    </form>
                                </section>
                            <?php endif; ?>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo $feed_url; ?>" target="blank"><img src="<?php echo LIS_PLUGIN_URL; ?>template/images/icon_rss.png" class="rss_feed" ></a>
                        </div>
                    </header>
                <?php endif; ?>
            </section>

            <aside id="sidebar">

                <a href="<?php echo real_site_url($lis_plugin_slug); ?>suggest-site" class="header-colabore pull-right"><?php _e('Suggest a site','lis'); ?></a>

                <?php if (strval($total) > 0) : ?>
                    <?php
                        $order = explode(';', $lis_config['available_filter']);
                        foreach ( $order as $key => $value) {
                    ?>
                        <?php if ( $value == 'Subjects' ) : ?>
                            <section class="row-fluid widget_categories">
                                <header class="row-fluid border-bottom marginbottom15">
                                    <h1 class="h1-header"><?php _e('Subjects','lis'); ?></h1>
                                </header>
                                <ul class="col3">
                                    <?php foreach ( $descriptor_list as $descriptor ) { ?>
                                        <?php
                                            $filter_link = '?';
                                            if ($query != ''){
                                                $filter_link .= 'q=' . $query . '&';
                                            }
                                            $filter_link .= 'filter=descriptor:"' . $descriptor[0] . '"';
                                            if ($user_filter != ''){
                                                $filter_link .= ' AND ' . $user_filter ;
                                            }
                                        ?>
                                        <?php $class = ( filter_var($descriptor[0], FILTER_VALIDATE_INT) === false ) ? 'cat-item' : 'cat-item hide'; ?>
                                        <li class="<?php echo $class; ?>">
                                            <a href='<?php echo $filter_link; ?>'><?php echo $descriptor[0]; ?></a>
                                            <span class="cat-item-count"><?php echo $descriptor[1] ?></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </section>
                        <?php endif; ?>
                        <?php if ( $value == 'Thematic area' ) : ?>
                            <section class="row-fluid marginbottom25 widget_categories">
                                <header class="row-fluid border-bottom marginbottom15">
                                    <h1 class="h1-header"><?php _e('Thematic area','lis'); ?></h1>
                                </header>
                                <ul class="col3">
                                <?php foreach ( $thematic_area_list as $ta ) { ?>
                                    <?php
                                        $filter_link = '?';
                                        if ($query != ''){
                                            $filter_link .= 'q=' . $query . '&';
                                        }
                                        $filter_link .= 'filter=thematic_area_display:"' . $ta[0] . '"';
                                        if ($user_filter != ''){
                                            $filter_link .= ' AND ' . $user_filter ;
                                        }
                                    ?>
                                    <li class="cat-item">
                                        <a href='<?php echo $filter_link; ?>'><?php lis_print_lang_value($ta[0], $site_language); ?></a>
                                        <span class="cat-item-count"><?php echo $ta[1] ?></span>
                                    </li>
                                <?php } ?>
                                </ul>
                             </section>
                        <?php endif; ?>
                        <?php if ( $value == 'Language' ) : ?>
                            <section class="row-fluid marginbottom25 widget_categories">
                                <header class="row-fluid border-bottom marginbottom15">
                                    <h1 class="h1-header"><?php _e('Language','lis'); ?></h1>
                                </header>
                                <ul class="col3">
                                <?php foreach ( $language_list as $language ) { ?>
                                    <?php
                                        $filter_link = '?';
                                        if ($query != ''){
                                            $filter_link .= 'q=' . $query . '&';
                                        }
                                        $filter_link .= 'filter=language:"' . $language[0] . '"';
                                        if ($user_filter != ''){
                                            $filter_link .= ' AND ' . $user_filter ;
                                        }
                                    ?>
                                    <li class="cat-item">
                                        <a href='<?php echo $filter_link; ?>'><?php lis_print_lang_value($language[0], $site_language); ?></a>
                                        <span class="cat-item-count"><?php echo $language[1] ?></span>
                                    </li>
                                <?php } ?>
                                </ul>
                             </section>
                        <?php endif; ?>
                    <?php } ?>
                <?php endif; ?>

                <?php dynamic_sidebar('lis-home');?>

            </aside>

            <div class="spacer marginbottom25"></div>

<?php endif; ?>

        </div>
    </div>

    <script type="text/javascript">
        jQuery(function ($) {
            $(document).on( "click", ".btn-ajax", function(e) {
                e.preventDefault();

                var _this = $(this);
                var fb = $(this).data('fb');
                var cluster = $(this).data('cluster');

                $(this).hide();
                $(this).next('.loading').show();

                $.ajax({ 
                    type: "POST",
                    url: lis_script_vars.ajaxurl,
                    data: {
                        action: 'lis_show_more_clusters',
                        lang: '<?php echo esc_url_raw($$lang_dir); ?>',
                        site_lang: '<?php echo esc_url_raw($site_language); ?>',
                        query: '<?php echo  esc_url_raw($query); ?>',
                        filter: '<?php echo  esc_url_raw($filter); ?>',
                        uf: '<?php echo  esc_url_raw($user_filter); ?>',
                        cluster: cluster,
                        fb: fb
                    },
                    success: function(response){
                        var html = $.parseHTML( response );
                        var this_len = _this.parent().siblings('.filter-list').find(".cat-item").length;
                        _this.parent().siblings('.filter-list').replaceWith( response );
                        _this.data('fb', fb+10);
                        _this.next('.loading').hide();

                        var response_len = $(html).find(".cat-item").length;
                        var mod = parseInt(response_len % 10);

                        if ( mod || response_len == this_len ) {
                            _this.remove();
                        } else {
                            _this.show();
                        }
                    },
                    error: function(error){ console.log(error) }
                });
            });
        });
    </script>

<?php get_footer();?>
