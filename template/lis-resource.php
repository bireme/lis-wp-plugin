<?php
/*
Template Name: LIS Detail
*/

$lis_config = get_option('lis_config');

$request_uri = $_SERVER["REQUEST_URI"];
$request_parts = explode('/', $request_uri);
$resource_id = end($request_parts);

$lis_service_url = $lis_config['service_url'];
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
                <a href="<?php echo home_url('lis/'); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> > 
                <?php _e('Resource','lis'); ?>
            </div>        
            <div class="row-fluid">
                <div class="pull-right">
                    <a href="enviar-colaboracion" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>
                </div>
            </div>

            <section id="conteudo">
                <header class="row-fluid border-bottom">
                    <h1 class="h1-header"><?php _e('Details','lis'); ?></h1>
                </header>
                <div class="row-fluid">
                    <article class="conteudo-loop">
                        <div class="row-fluid">
                            <h2 class="h2-loop-tit"><?php echo $resource->title; ?></h2>
                        </div>
                            <div class="conteudo-loop-rates">
                                <div class="star" data-score="1"></div>
                            </div>
                            <span class="row-fluid margintop05">
                                <a href="<?php echo $resource->link; ?>"><?php echo $resource->link; ?></a>   
                            </span>
                            <p class="row-fluid">
                                <?php echo $resource->abstract; ?>
                            </p>

                            <div id="conteudo-loop-data" class="row-fluid margintop05">
                                <span class="conteudo-loop-data-tit"><?php _e('Resource added in','lis'); ?>:</span>
                                29/07/2013 - 5h33                           
                            </div>

                            <div id="conteudo-loop-idiomas" class="row-fluid">
                                <span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
                                Português, English, Español
                            </div>

                            <div id="conteudo-loop-tags" class="row-fluid margintop10">
                                <i class="ico-tags"></i>
                                <a href="#" rel="tag">Chagas</a>, <a href="#" rel="tag">Dengue</a>, <a href="#" rel="tag">Hanseníase</a>, <a href="#" rel="tag">Leishmaniose</a>, <a href="#" rel="tag">Malária</a><br />
                            </div>

                            <footer class="row-fluid margintop5">
                                <ul class="conteudo-loop-icons">
                                    <li class="conteudo-loop-icons-li">
                                        <a href="#">
                                            <i class="ico-compartilhar"></i>
                                            <?php _e('Share','lis'); ?>
                                        </a>
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

                                    <li class="conteudo-loop-icons-li">
                                        <a href="#">
                                            <i class="ico-comentar"></i>
                                            <?php _e('Comments','lis'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </footer>
                        </article>
                    </div>

            </section>

            <aside id="sidebar">
                <section class="row-fluid marginbottom25 widget_categories">
                    <header class="row-fluid border-bottom marginbottom15">
                        <h1 class="h1-header"><?php _e('Subjects','lis'); ?></h1>
                    </header>
                    <ul>
                        <li class="cat-item"><a href="http://localhost/lis/category/educacao/">Educação</a><span class="cat-item-count">3</span>
                        </li>
                        <li class="cat-item"><a href="http://localhost/lis/category/gestao-em-saude/">Gestão em Saúde</a><span class="cat-item-count">1</span>
                        </li>
                        <li class="cat-item"><a href="http://localhost/lis/category/politica/">Política</a><span class="cat-item-count">3</span>
                        </li>
                        <li class="cat-item"><a href="http://localhost/lis/category/saude/">Saúde</a><span class="cat-item-count">2</span>
                        </li>
                        <li class="cat-item"><a href="http://localhost/lis/category/servicos-de-saude/">Serviços de Saúde</a><span class="cat-item-count">1</span>
                        </li>
                    </ul>
                </section>
            </aside>

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