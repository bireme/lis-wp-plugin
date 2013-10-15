<?php
/*
Template Name: LIS Detail
*/

$lis_config = get_option('lis_config');

$request_uri = $_SERVER["REQUEST_URI"];
$request_parts = explode('/', $request_uri);
$resource_id = end($request_parts);

$lis_service_url = $lis_config['service_url'];
$lis_disqus_id  = $lis_config['disqus_shortname'];
$lis_addthis_id = $lis_config['addthis_profile_id'];
$lis_service_request = $lis_service_url . 'api/resource/search/?q=id:"main.resource.' .$resource_id . '"';

$response = @file_get_contents($lis_service_request);

if ($response){
    $response_json = json_decode($response);
    $resource = $response_json->diaServerResponse[0]->response->docs[0];
}

?>

<?php get_header(); ?>

<div id="content" class="row-fluid">
        <div class="ajusta2">
            <div class="row-fluid">
                <a href="<?php echo home_url(); ?>"><?php _e('Home','lis'); ?></a> > 
                <a href="<?php echo home_url($plugin_slug); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> > 
                <?php _e('Resource','lis'); ?>
            </div>
            <div class="row-fluid">
                <section class="header-search">
                    <?php if ($lis_config['show_form']) : ?>
                        <form role="search" method="get" id="searchform" action="<?php echo home_url($plugin_slug); ?>">
                            <input value="<?php echo $query ?>" name="q" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                            <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                        </form>
                    <?php endif; ?>
                </section>
                <div class="pull-right">
                    <a href="<?php echo home_url($plugin_slug); ?>/suggest" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>
                </div>   
            </div>

            <section id="conteudo">
                <header class="row-fluid border-bottom">
                    <h1 class="h1-header"><?php echo $resource->title; ?></h1>
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style addthis_32x32_style row-fluid">
                    <a class="addthis_button_preferred_1"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>                    
                    </div>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $lis_addthis_id; ?>"></script>
                    <!-- AddThis Button END -->
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
                               <?php echo $resource->created_date; ?>                           
                            </div>
                        <?php endif; ?>

                        <?php if ($resource->objective): ?>
                            <span class="row-fluid margintop05">
                                <span class="conteudo-loop-data-tit"><?php _e('Objective','lis'); ?>:</span>
                                <?php echo $resource->objective; ?> 
                            </span>
                        <?php endif; ?>


                        <div id="conteudo-loop-idiomas" class="row-fluid">
                            <span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
                            Português, English, Español
                        </div>

                        <?php if ($resource->descriptors || $resource->keywords ) : ?>
                            <div id="conteudo-loop-tags" class="row-fluid margintop10">
                                <i class="ico-tags"> </i>   
                                    <?php 
                                        $descriptors = (array)$resource->descriptors;
                                        $keywords = (array)$resource->keywords;
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
                                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $lis_addthis_id; ?>"></script>
                                    <!-- AddThis Button END -->
                                    <!--
                                    <a href="#">                                       
                                        <?php _e('Share','lis'); ?>
                                    </a>
                                    -->
                                </li>

                                <li class="conteudo-loop-icons-li">
                                    <a href="#">
                                        <i class="ico-tag"></i>
                                        <?php _e('Suggest tag','lis'); ?>
                                    </a>
                                </li>

                                <li class="conteudo-loop-icons-li">
                                    <span class="reportar-erro-open">
                                        <i class="ico-reportar"></i>
                                        <?php _e('Report error','lis'); ?>
                                    </span>

                                    <div class="reportar-erro"> 
                                        <form action="">
                                            <div class="reportar-erro-close">[X]</div>
                                            <span class="reportar-erro-tit">Motivo</span>

                                            <div class="row-fluid margintop05">
                                                <input type="radio" name="txtMotivo" id="txtMotivo1">
                                                <label class="reportar-erro-lbl" for="txtMotivo1">Motivo 01</label>
                                            </div>

                                            <div class="row-fluid">
                                                <input type="radio" name="txtMotivo" id="txtMotivo2">
                                                <label class="reportar-erro-lbl" for="txtMotivo2">Motivo 02</label>
                                            </div>

                                            <div class="row-fluid">
                                                <input type="radio" name="txtMotivo" id="txtMotivo3">
                                                <label class="reportar-erro-lbl" for="txtMotivo3">Motivo 03</label>
                                            </div>

                                            <div class="row-fluid margintop05">
                                                <textarea name="txtArea" id="txtArea" class="reportar-erro-area" cols="20" rows="2"></textarea>
                                            </div>

                                            <div class="row-fluid border-bottom2"></div>

                                            <span class="reportar-erro-tit margintop05">Nueva URL (Opcional)</span>
                                            <div class="row-fluid margintop05">
                                                <textarea name="txtUrl" id="txtUrl" class="reportar-erro-area" cols="20" rows="2"></textarea>
                                            </div>

                                            <div class="row-fluid border-bottom2"></div>

                                            <div class="row-fluid margintop05">
                                                <button class="pull-right reportar-erro-btn">Enviar</button>
                                            </div>
                                        </form>
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

        </div>
    </div>
    <script>

        $('.star').raty({
            path: '/lis/wp-content/themes/lis/Js/raty-2.5.2/lib/img/',
            score: function() {
            return $(this).attr('data-score');
          }
        });
    </script>

<?php get_footer();?>