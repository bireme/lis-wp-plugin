<?php
/*
Template Name: LIS Detail
*/
global $lis_service_url;

$lis_config = get_option('lis_config');
$resource_id   = $_GET['id'];

$site_language = strtolower(get_bloginfo('language'));
$lang_dir = substr($site_language,0,2);

$lis_disqus_id  = $lis_config['disqus_shortname'];
$lis_addthis_id = $lis_config['addthis_profile_id'];
$lis_service_request = $lis_service_url . 'api/resource/search/?id=main.resource.' .$resource_id . '&op=related&lang=' . $lang_dir;

$response = @file_get_contents($lis_service_request);

if ($response){
    $response_json = json_decode($response);

    $resource = $response_json->diaServerResponse[0]->match->docs[0];
    $related_list = $response_json->diaServerResponse[0]->response->docs;
}

//print_r($related_list);

?>

<?php get_header('lis'); ?>

<div id="content" class="row-fluid">
        <div class="ajusta2">
            <div class="row-fluid breadcrumb">
                <a href="<?php echo real_site_url(); ?>"><?php _e('Home','lis'); ?></a> >
                <a href="<?php echo real_site_url($lis_plugin_slug); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> >
                <?php _e('Resource','lis'); ?>
            </div>

            <section id="conteudo">
                <header class="row-fluid border-bottom">
                    <h1 class="h1-header"><?php echo $resource->title; ?></h1>
                </header>
                <div class="row-fluid">
                    <article class="conteudo-loop">
                        <div class="conteudo-loop-rates">
                            <div class="star" data-score="1"></div>
                        </div>

                        <p class="row-fluid margintop05">
                            <?php foreach($resource->link as $link): ?>
                                <a href="<?php echo $link; ?>"><?php echo $link; ?></a><br/>
                            <?php endforeach; ?>
                        </p>

                        <p class="row-fluid">
                            <?php echo $resource->abstract; ?>
                        </p>

                        <?php if ($resource->author): ?>
                            <span class="row-fluid margintop05">
                                <span class="conteudo-loop-data-tit"><?php _e('Author(s)','lis'); ?>:</span>
                                <?php echo implode(", ", $resource->author); ?>
                            </span>
                        <?php endif; ?>

                        <span class="row-fluid margintop05">
                            <span class="conteudo-loop-data-tit"><?php _e('Originator(s)','lis'); ?>:</span>
                            <?php echo implode(", ", $resource->originator); ?>
                        </span>

                        <?php if ($resource->created_date): ?>
                            <div id="conteudo-loop-data" class="row-fluid margintop05">
                                <span class="conteudo-loop-data-tit"><?php _e('Resource added in','lis'); ?>:</span>
                               <?php echo print_formated_date($resource->created_date); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($resource->objective): ?>
                            <span class="row-fluid margintop05">
                                <span class="conteudo-loop-data-tit"><?php _e('Objective','lis'); ?>:</span>
                                <?php echo $resource->objective; ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($resource->source_language_display): ?>
                            <div id="conteudo-loop-idiomas" class="row-fluid">
                               <span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
                               <?php print_lang_value($resource->source_language_display, $site_language); ?>
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

                        <footer class="row-fluid margintop05">
                            <ul class="conteudo-loop-icons">
                                <li class="conteudo-loop-icons-li">
                                    <i class="ico-compartilhar"></i>
                                    <!-- AddThis Button BEGIN -->
                                    <a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=<?php echo $lis_addthis_id; ?>"><?php _e('Share','lis'); ?></a>
                                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $lis_addthis_id; ?>"></script>
                                    <!-- AddThis Button END -->
                                    <!--
                                    <a href="#">
                                        <?php _e('Share','lis'); ?>
                                    </a>
                                    -->
                                </li>

                                <li class="conteudo-loop-icons-li">
                                    <span class="sugerir-tag-open">
                                        <i class="ico-tag"></i>
                                        <?php _e('Suggest tag','lis'); ?>
                                    </span>
                                    <div class="sugerir-tag">
                                        <div class="sugerir-form">
                                            <form action="<?php echo $lis_service_url ?>suggest-tag" id="tagForm">
                                                <input type="hidden" name="resource_id" value="<?php echo $resource_id; ?>"/>
                                                <div class="sugerir-tag-close">[X]</div>
                                                <span class="sugerir-tag-tit"><?php _e('Suggestions','lis'); ?></span>

                                                <div class="row-fluid margintop05 marginbottom10">
                                                    <input type="text" name="txtTag" class="sugerir-tag-input" id="txtTag">
                                                </div>

                                                <div class="row-fluid margintop05">
                                                    <span class="sugerir-tag-separator"><?php _e('Separated by comma','lis'); ?></span>
                                                    <button class="pull-right colaboracion-enviar"><?php _e('Send','lis'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sugerir-tag-result">
                                            <div class="sugerir-tag-close">[X]</div>
                                            <div id="result-ok">
                                                <?php _e('Thank you for your suggestion.','lis'); ?>
                                            </div>
                                            <div id="result-problem">
                                                <?php _e('Communication problem. Please try again later.','lis'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="conteudo-loop-icons-li">
                                    <span class="reportar-erro-open">
                                        <i class="ico-reportar"></i>
                                        <?php _e('Report error','lis'); ?>
                                    </span>

                                    <div class="reportar-erro">
                                        <div class="erro-form">
                                            <form action="<?php echo $lis_service_url ?>report-error" id="reportErrorForm">
                                                <input type="hidden" name="resource_id" value="<?php echo $resource_id; ?>"/>
                                                <div class="reportar-erro-close">[X]</div>
                                                <span class="reportar-erro-tit"><?php _e('Reason','lis'); ?></span>

                                                <div class="row-fluid margintop05">
                                                    <input type="radio" name="code" id="txtMotivo1" value="0">
                                                    <label class="reportar-erro-lbl" for="txtMotivo1"><?php _e('Invalid Link','lis'); ?></label>
                                                </div>

                                                <div class="row-fluid">
                                                    <input type="radio" name="code" id="txtMotivo2" value="1">
                                                    <label class="reportar-erro-lbl" for="txtMotivo2"><?php _e('Bad content','lis'); ?></label>
                                                </div>

                                                <div class="row-fluid">
                                                    <input type="radio" name="code" id="txtMotivo3" value="3">
                                                    <label class="reportar-erro-lbl" for="txtMotivo3"><?php _e('Other','lis'); ?></label>
                                                </div>

                                                <div class="row-fluid margintop05">
                                                    <textarea name="description" id="txtArea" class="reportar-erro-area" cols="20" rows="2"></textarea>
                                                </div>

                                                <div class="row-fluid border-bottom2"></div>

                                                <span class="reportar-erro-tit margintop05"><?php _e('New Link (Optional)','lis'); ?></span>
                                                <div class="row-fluid margintop05">
                                                    <textarea name="new_link" id="txtUrl" class="reportar-erro-area" cols="20" rows="2"></textarea>
                                                </div>

                                                <div class="row-fluid border-bottom2"></div>

                                                <div class="row-fluid margintop05">
                                                    <button class="pull-right reportar-erro-btn"><?php _e('Send','lis'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="error-report-result">
                                            <div class="reportar-erro-close">[X]</div>
                                            <div id="result-ok">
                                                <?php _e('Thank you for your report.','lis'); ?>
                                            </div>
                                            <div id="result-problem">
                                                <?php _e('Communication problem. Please try again later.','lis'); ?>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </footer>

                        <?php if ($lis_disqus_id != '') :?>
                            <div id="disqus_thread" class="row-fluid margintop25"></div>
                            <script type="text/javascript">
                                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                var disqus_shortname = '<?php echo $lis_disqus_id; ?>'; // required: replace example with your forum shortname

                                /* * * DON'T EDIT BELOW THIS LINE * * */
                                (function() {
                                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                            <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                        <?php endif; ?>

                    </article>
                </div>
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
                <section class="row-fluid marginbottom25 widget_categories">
                    <header class="row-fluid border-bottom marginbottom15">
                        <h1 class="h1-header"><?php _e('Related','lis'); ?></h1>
                    </header>
                    <ul>
                        <?php foreach ( $related_list as $related) { ?>
                            <?php if ($related->django_ct == 'main.resource' && $related->status == '1') : ?>
                                <li class="cat-item">
                                    <a href="<?php echo real_site_url($lis_plugin_slug); ?>resource/?id=<?php echo $related->django_id; ?>"><?php echo $related->title ?></a>
                                </li>
                            <?php endif; ?>
                        <?php } ?>
                    </ul>
                </section>
            </aside>

        </div>
    </div>

<?php get_footer();?>
