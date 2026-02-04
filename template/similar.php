<?php
    include "../../../../wp-load.php";

    $lang = sanitize_text_field($_GET['lang']);
    $similar_docs_url = sanitize_text_field($_GET['query']);

    // get similar docs
    $similar_docs_xml = @file_get_contents($similar_docs_url);
    // transform to php array
    $xml = simplexml_load_string($similar_docs_xml,'SimpleXMLElement',LIBXML_NOCDATA);
    $json = json_encode($xml);
    $similar_docs = json_decode($json, TRUE);

    if ( $similar_docs && array_key_exists('document', $similar_docs) ) {
        if ( array_key_exists('id', $similar_docs['document']) ) {
            $similar_docs['document'] = array($similar_docs['document']);
        }
        
        foreach ( $similar_docs['document'] as $similar) {
            ?>
            <!--<li class="cat-item">-->


                <div class="divRelacionados">
                    <b>
                <?php
                    $preferred_lang_list = array($lang, 'en', 'es', 'pt');
                    $similar_title = '';
                    // start with more generic title
                    if (isset($similar['ti'])){
                        $similar_title = is_array($similar['ti']) ? $similar['ti'][0] : $similar['ti'];
                    }
                    // search for title in different languages
                    foreach ($preferred_lang_list as $lang){
                        $ti_lang = 'ti_' . $lang;
                        if (isset($similar[$ti_lang])){
                            $similar_title = $similar[$ti_lang];
                            break;
                        }
                    }
                    echo $similar_title;
                ?>
                </b>
                <BR><BR>
                <span class="more">
                <a href="http://pesquisa.bvsalud.org/portal/resource/<?php echo $lang . '/' . $similar['id']; ?>"><?php _e('See more details','lis'); ?></a>
                </span>
                


                </div>
                <!--
                <article class="conteudo-loop divRelacionados">
                                <div class="row-fluid">
                                    <h2 class="h2-loop-tit">
teste
                <?php
                    $preferred_lang_list = array($lang, 'en', 'es', 'pt');
                    $similar_title = '';
                    // start with more generic title
                    if (isset($similar['ti'])){
                        $similar_title = is_array($similar['ti']) ? $similar['ti'][0] : $similar['ti'];
                    }
                    // search for title in different languages
                    foreach ($preferred_lang_list as $lang){
                        $ti_lang = 'ti_' . $lang;
                        if (isset($similar[$ti_lang])){
                            $similar_title = $similar[$ti_lang];
                            break;
                        }
                    }
                    echo $similar_title;
                ?>
             

                                    </h2>
                                </div>
                                <div class="conteudo-loop-rates">
                                    <div class="star" data-score="1"></div>
                                </div>
                                <p class="row-fluid">
                <span class="more">
                <a href="http://pesquisa.bvsalud.org/portal/resource/<?php echo $lang . '/' . $similar['id']; ?>"><?php _e('See more details','lis'); ?></a>
                </span>
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
                                                $keywords = isset($resource->keyword) ? $resource->keyword : [];
                                            ?>
                                            <?php echo implode(", ", array_merge( $descriptors, $keywords) ); ?>
                                      </div>
                                <?php endif; ?>

                            </article>
                                -->
            <!--</li>-->
            <?php
        }
    } else {
        echo '<li>' . __('No related documents', 'lis') . '</li>';
    }
?>