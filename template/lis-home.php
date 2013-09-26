<?php
/*
Template Name: LIS Home
*/

$lis_config = get_option('lis_config');
$lis_service_url = $lis_config['service_url'];

$query = $_GET['s'];

$lis_service_request = $lis_service_url . 'api/resource/search/?q=' . urlencode($query);

$response = @file_get_contents($lis_service_request);
if ($response){
    $response_json = json_decode($response);
    $resource_list = $response_json->diaServerResponse[0]->response->docs;
}
?>

<?php get_header();?>
	<div id="content" class="row-fluid">
		<div class="ajusta2">
            <div class="row-fluid">
                <a href="<?php echo home_url(); ?>"><?php _e('Home','lis'); ?></a> > <?php _e('Health Information Locator', 'lis') ?>
            </div>
			<div class="row-fluid">
                    <div class="pull-left">
                        <a href="#" class="ico-feeds"></a>
                        <form action="">
                            <select name="txtRegistros" id="txtRegistros" class="select-input-home">
                                <option value="10 Registros">10 <?php _e('resources', 'lis'); ?></option>`
                                <option value="20 Registros">20 <?php _e('resources', 'lis'); ?></option>
                                <option value="50 Registros">50 <?php _e('resources', 'lis'); ?></option>
                            </select>

                            <select name="txtOrder" id="txtOrder" class="select-input-home">
                                <option value=""><?php _e('Order by', 'lis'); ?></option>
                                <option value="Mais Recentes"><?php _e('More relevant','lis'); ?></option>
                                <option value="Mais Lidas"><?php _e('Most recent','lis'); ?></option>
                            </select>
                        </form>
                    </div>
				    <div class="pull-right">
    					<a href="enviar-colaboracion" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>
	   			    </div>   
			</div>
				
			<section id="conteudo">
				<header class="row-fluid border-bottom">
					<h1 class="h1-header"><?php _e('Most recent','lis'); ?></h1>
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
    						<span class="row-fluid margintop05">
    							<a href="<?php echo $resource->link; ?>"><?php echo $resource->link; ?></a>	
    						</span>
    						<p class="row-fluid">
    							<?php echo $resource->abstract; ?><br/>
    							<span class="more"><a href="resource/<?php echo $resource->django_id; ?>"><?php _e('See more details','lis'); ?>...</a></span>
    						</p>
    						<div id="conteudo-loop-data" class="row-fluid margintop05">
    							<span class="conteudo-loop-data-tit"><?php _e('Resource added in','lis'); ?>:</span>
    							22/05/2013
    						</div>
    						<div id="conteudo-loop-idiomas" class="row-fluid">
    							<span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
    							Português, English, Español
    						</div>
    						<div id="conteudo-loop-tags" class="row-fluid margintop10">
    							<i class="ico-tags"></i>
    							Chagas, Dengue, Hanseníase, Leishmaniose, Malária
    						</div>
    					</article>
                    <?php } ?>
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
				<?php get_sidebar();?>
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