<?php
/*
Template Name: LIS Detail
*/
global $lis_service_url, $similar_docs_url;

$lis_config = get_option('lis_config');
$resource_id = sanitize_text_field($_GET['id']);

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

    // create param to find similars
    $similar_text = $resource->title;
    if (isset($resource->mj)){
        $similar_text .= ' ' . implode(' ', $resource->mj);
    }

    $similar_docs_url = $similar_docs_url . '?adhocSimilarDocs=' . urlencode($similar_text);
    $similar_docs_request = ( $lis_config['default_filter_db'] ) ? $similar_docs_url . '&sources=' . $lis_config['default_filter_db'] : $similar_docs_url;
    $similar_query = urlencode($similar_docs_request);
    $related_query = urlencode($similar_docs_url);
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

    <?php function gerarImagemTableau($url) {
    $parsed = parse_url($url);
    $path = trim($parsed['path'], '/');
    $partes = explode('/', $path);

    // Esperado: app/profile/{perfil}/viz/{projeto}/{visualizacao}
    if (count($partes) < 6 || $partes[3] !== 'viz') {
        return null; // formato inesperado
    }

    $projeto = $partes[4];
    $visualizacao = $partes[5];
    $prefixo = substr($projeto, 0, 2);

    return "https://public.tableau.com/static/images/{$prefixo}/{$projeto}/{$visualizacao}/1_rss.png";
}

function temTableauNoLink($url) {
    return strpos($url, 'public.tableau.com') !== false;
}
?><script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


                    <p class="row-fluid margintop05">
                        <?php foreach($resource->link as $link): ?>
                            <a href="<?php echo $link; ?>" style= "  word-break: break-word; overflow-wrap: anywhere; white-space: normal; display: inline-block;"><?php echo $link; ?></a><br/>
                            <BR>
                        <?php
                        
                    $saida = gerarImagemTableau($link);
                    ?>


                        
                        <?php endforeach; ?>
                    </p>

                    <p class="row-fluid">
                        <?php echo $resource->abstract; ?>
                    </p>
                    <BR>
                          <style>
#sidebar{width:1050px; float:left;}
#conteudo{width:1050px; float:left; margin-bottom: 20px}
.conteudo-loop{width:1050px; }
                        </style>
                    <?php
                    if (temTableauNoLink($saida)) { ?>


                        <div class='tableauPlaceholder' id='viz1769085678237' style='position: relative'><BR><noscript>
                        <a href='#'>
                        <img alt='Estratégias de Promoção da Vacinação Infantil - Mapa de EvidênciasDECIT/SCTIE/MS; BIREME/OPAS/OMS ' 
                        src='<?=$saida;?>' style='border: none' /></a>
                        </noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='vacinas-pt/evidence-map' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='<?=$saida;?>' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='pt-BR' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1769085678237');                    var vizElement = divElement.getElementsByTagName('object')[0];                    vizElement.style.width='1050px';vizElement.style.height='1227px';                    var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>
                        
                    <BR>
                        <?php } ?>
                    
                    
                    <?php if (isset($resource->author)): ?>
                    <?php if ($resource->author): ?>
                        <span class="row-fluid margintop05">
                            <span class="conteudo-loop-data-tit"><?php _e('Author(s)','lis'); ?>:</span>
                            <?php echo implode(", ", $resource->author); ?>
                        </span>
                    <?php endif; ?>
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

                    <?php if ($resource->source_language_display): ?>
                        <div id="conteudo-loop-idiomas" class="row-fluid">
                           <span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
                           <?php lis_print_lang_value($resource->source_language_display, $site_language); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($resource->objective)): ?>
                    <?php if ($resource->objective): ?>
                        <span class="row-fluid margintop05">
                            <span class="conteudo-loop-data-tit"><?php _e('Objective','lis'); ?>:</span>
                            <?php echo $resource->objective; ?>
                        </span>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($resource->descriptor || $resource->keyword ) : ?>
                        <div id="conteudo-loop-tags" class="row-fluid margintop10">
                            <i class="ico-tags"> </i>
                                <?php
                                    $descriptors = (array)$resource->descriptor;
                                    $keywords = isset($resource->keyword) ? $resource->keyword : [];
                                ?>
                                <?php echo implode(", ", array_merge( $descriptors, $keywords) ); ?>
                          </div>
                    <?php endif; ?>

                    <footer class="row-fluid margintop05">
                        <ul class="conteudo-loop-icons">
                            <li class="conteudo-loop-icons-li">
                                <!------------------------------------------------->
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<?php
$urlcompartilhamento = real_site_url($direve_plugin_slug) . 'resource/?id=' . $resource->django_id;
//$urlcompartilhamento = rawurlencode($urlcompartilhamento);
?>

<?php

$url = $urlcompartilhamento ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Encode seguro: remove encode anterior (se houver) e aplica rawurlencode uma vez
function li_safe_encode($u){ return rawurlencode(rawurldecode($u)); }
$enc = li_safe_encode($url);

// Endpoints
$li_primary = "https://www.linkedin.com/sharing/share-offsite/?url={$enc}";
$li_fallback = "https://www.linkedin.com/shareArticle?mini=true&url={$enc}";

?>

<a class="addthis_button"><?php _e('Share','lis'); ?>:</a>

<!-- Facebook -->
<a class="badge facebook"
   href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($urlcompartilhamento)?>&quote=<?=urlencode('Confira isso!')?>"
   target="_blank" rel="noopener noreferrer">
  <i class="fa-brands fa-facebook-f"></i>
</a>

<!-- X (Twitter) -->
<a class="badge x"
   href="https://twitter.com/intent/tweet?url=<?=urlencode($urlcompartilhamento)?>&text=<?=urlencode('Confira isso!')?>"
   target="_blank" rel="noopener noreferrer">
  <i class="fa-brands fa-x-twitter"></i>
</a>

<!-- WhatsApp (funciona no mobile e desktop web) -->
<a class="badge whatsapp"
   href="https://wa.me/?text=<?=urlencode('Confira isso: '.$urlcompartilhamento)?>"
   target="_blank" rel="noopener noreferrer">
  <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
</a>

<a class="badge copy" 
   href="javascript:void(0);"
   onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link da página copiado!'))">
  <i class="fa-regular fa-copy"></i>
</a>
                    <!-- -->

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
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    <?php _e('Report error','lis'); ?>
                                </span>

                                <div class="reportar-erro">
                                    <div class="erro-form">
                                        <form action="https://fi-admin.bvsalud.org/report-error" id="reportErrorForm">
                                            <input type="hidden" name="resource_type" value="event"/>
                                            <input type="hidden" name="resource_id" value="<?php echo $event_id; ?>"/>
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
<!--
                                            <span class="reportar-erro-tit margintop05"><?php _e('New Link (Optional)','lis'); ?></span>
                                            <div class="row-fluid margintop05">
                                                <textarea name="new_link" id="txtUrl" class="reportar-erro-area" cols="20" rows="2"></textarea>
                                            </div>
                    -->
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
            <!--
            <div class="row-fluid">
                <header class="row-fluid border-bottom marginbottom15">
                    <h1 class="h1-header"><?php _e('More related','lis'); ?></h1>
                </header>
                <div id="loader" class="loader" style="display: inline-block;"></div>
            </div>
            <div class="row-fluid">
                <div id="async" class="related-docs">

                </div>
            </div>-->
<?php
$sources = ( $lis_config['extra_filter_db'] ) ? $lis_config['extra_filter_db'] : '';
$url = LIS_PLUGIN_URL.'template/related.php?query='.$related_query.'&sources='.$sources.'&lang='.$lang_dir;
?>
<!--
<script type="text/javascript">
    show_related("<?php echo $url; ?>");
</script>-->
        </section>
        <aside id="sidebar">
            <section class="header-search">
                <?php if ($lis_config['show_form']) : ?>
                    <form role="search" method="get" id="searchform" action="<?php echo real_site_url($lis_plugin_slug); ?>">
                        <input value="<?php echo isset($query) ? esc_attr($query) : ''; ?>" name="q" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                        <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                    </form>
                <?php endif; ?>
            </section>
            <a href="<?php echo real_site_url($lis_plugin_slug); ?>suggest-site" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>
            <section class="row-fluid marginbottom25 widget_categories">
                <header class="row-fluid border-bottom marginbottom15">
                    <h1 class="h1-header"><?php _e('Related','lis'); ?></h1>
                </header>
            <ul id="ajax">

            </ul>
            </section>
<?php
$url = LIS_PLUGIN_URL.'template/similar.php?query='.$similar_query.'&lang='.$lang_dir . '&slug=' . $lis_plugin_slug;
?>
<script type="text/javascript">
    show_similar("<?php echo $url; ?>");
</script>
        </aside>
        <div class="spacer"></div>
    </div>
</div>

<?php get_footer();?>
