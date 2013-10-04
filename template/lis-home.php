<?php
/*
Template Name: LIS Home
*/

$lis_config = get_option('lis_config');
$lis_service_url = $lis_config['service_url'];
$lis_initial_filter = $lis_config['initial_filter'];

$query = $_GET['s'];
$page = ( isset($_GET['page']) ? $_GET['page'] : 1 );
$total = 0;
$count = 20;

$start = ($page * $count) - $count;

$lis_service_request = $lis_service_url . 'api/resource/search/?q=' . urlencode($query) . '&fq=' . $lis_initial_filter . '&start=' . $start;

$response = @file_get_contents($lis_service_request);
if ($response){
    $response_json = json_decode($response);
    //var_dump($response_json);
    $total = $response_json->diaServerResponse[0]->response->numFound;
    $resource_list = $response_json->diaServerResponse[0]->response->docs;
    $topic_list = $response_json->diaServerResponse[0]->facet_counts->facet_fields->descriptors;
}
?>

<?php get_header();?>
	<div id="content" class="row-fluid">
		<div class="ajusta2">
            <div class="row-fluid">
                <a href="<?php echo home_url(); ?>"><?php _e('Home','lis'); ?></a> >
                <?php if ($query == ''): ?>
                    <?php _e('Health Information Locator', 'lis') ?>
                <?php else: ?>                    
                    <a href="<?php echo home_url('lis/'); ?>"><?php _e('Health Information Locator', 'lis') ?> </a> >
                    <?php _e('Search result', 'lis') ?>
                <?php endif; ?>
            </div>
			<div class="row-fluid">
                <section class="header-search">
                    <?php if ($lis_config['show_form']) : ?>
                        <form role="search" method="get" id="searchform" action="<?php echo home_url('lis/'); ?>">
                            <input value="<?php echo $query ?>" name="s" class="input-search" id="s" type="text" placeholder="<?php _e('Search', 'lis'); ?>...">
                            <input id="searchsubmit" value="<?php _e('Search', 'lis'); ?>" type="submit">
                        </form>
                    <?php endif; ?>
                </section>
                <div class="pull-right">
                    <a href="enviar-colaboracion" class="header-colabore"><?php _e('Suggest a site','lis'); ?></a>
                </div>   
            </div>
				
			<section id="conteudo">
                <?php if ( isset($total) && strval($total) == 0) :?>
                    <h1 class="h1-header"><?php _e('No results found','lis'); ?></h1>
                <?php else :?>
    				<header class="row-fluid border-bottom">
                        <?php if ( isset($query) && strval($total) > 0) :?>
    					   <h1 class="h1-header"><?php _e('Resources found','lis'); ?>: <?php echo $total; ?></h1>
                        <?php else: ?>
                           <h1 class="h1-header"><?php _e('Most recent','lis'); ?></h1>
                        <?php endif; ?>    
                        <div class="pull-right">
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
        						<p class="row-fluid margintop05">
                                    <?php foreach($resource->link as $link): ?>
        							    <a href="<?php echo $link; ?>"><?php echo $link; ?></a><br/>
                                    <?php endforeach; ?>
        						</p>
        						<p class="row-fluid">
        							<?php echo $resource->abstract; ?><br/>
        							<span class="more"><a href="resource/<?php echo $resource->django_id; ?>"><?php _e('See more details','lis'); ?>...</a></span>
        						</p>

                                <?php if ($resource->created_date): ?>
            						<div id="conteudo-loop-data" class="row-fluid margintop05">
            							<span class="conteudo-loop-data-tit"><?php _e('Resource added in','lis'); ?>:</span>
            							<?php echo $resource->created_date; ?>
            						</div>
                                <?php endif; ?>

        						<div id="conteudo-loop-idiomas" class="row-fluid">
        							<span class="conteudo-loop-idiomas-tit"><?php _e('Available languages','lis'); ?>:</span>
        							Português, English, Español
        						</div>

                                <?php if ($resource->descriptors || $resource->keywords ) : ?>
                                    <div id="conteudo-loop-tags" class="row-fluid margintop10">
                                        <i class="ico-tags"></i>                                  
                                            <?php echo implode(", ", array_merge($resource->descriptors, $resource->keywords) ); ?>
                                      </div>
                                <?php endif; ?>

        					</article>
                        <?php } ?>
    				</div>
                    <div class="row-fluid">
                        <ul class="pager">
                            <li  <?php if ($page == 1) echo ' class="disabled" ';?>><a href="<?php if ($page > 1) echo '?s=' . $query . '&page=' . strval($page-1); ?>" ><?php _e('Previous','lis'); ?></a></li>
                            <li><a href="<?php echo '?s=' . $query . '&page=' . strval($page+1); ?>"><?php _e('Next','lis'); ?></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
			</section>
			<aside id="sidebar">
                <?php if (strval($total) > 0) :?>
    				<section class="row-fluid marginbottom25 widget_categories">
    					<header class="row-fluid border-bottom marginbottom15">
    						<h1 class="h1-header"><?php _e('Subjects','lis'); ?></h1>
    					</header>
    					<ul>
                            <?php foreach ( $topic_list as $topic) { ?>
                                <li class="cat-item">
                                    <a href="#"><?php echo $topic[0] ?></a><span class="cat-item-count"><?php echo $topic[1] ?></span>
                                </li>
                            <?php } ?>
    					</ul>
    				</section>
                <?php endif; ?>
				<?php dynamic_sidebar('lis-home');?>
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