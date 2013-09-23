<?php
/*
Template Name: LIS Home
*/
?>
<?php get_header();?>
	<div id="content" class="row-fluid">
		<div class="ajusta2">
			<div class="row-fluid">
				<section class="header-search">
					<form role="search" method="get" id="searchform" action="<?php echo get_option('home'); ?>">
						<input value="" name="s" class="input-search" id="s" type="text" placeholder="Pesquisar...">
	          			<input id="searchsubmit" value="" type="submit" class="b-search">
					</form>
				</section>

				<div class="pull-right">
					<a href="enviar-colaboracion" class="header-colabore">Indique um site</a>
				</div>
			</div>
				
			<section id="conteudo">
				<header class="row-fluid border-bottom">
					<h1 class="h1-header">Más Recientes</h1>
					<div class="pull-right">
						<a href="#" class="ico-feeds"></a>
						<form action="">
							<select name="txtRegistros" id="txtRegistros" class="select-input-home">
								<option value="10 Registros">10 registros</option>`
								<option value="20 Registros">20 registros</option>
								<option value="50 Registros">50 registros</option>
							</select>

							<select name="txtOrder" id="txtOrder" class="select-input-home">
								<option value="">Ordenar por</option>
								<option value="Mais Recentes">Mais Recentes</option>
								<option value="Mais Lidas">Mais Lidas</option>
							</select>
						</form>
					</div>
				</header>
				<div class="row-fluid">
					<article class="conteudo-loop">
						<div class="row-fluid">
							<h2 class="h2-loop-tit">Estratégia governamental para internalização de fármacos e medicamentos em doenças negligenciadas</h2>
						</div>
						<div class="conteudo-loop-rates">
							<div class="star" data-score="1"></div>
						</div>
						<span class="row-fluid margintop05">
							<a href="http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf">http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf</a>	
						</span>
						<p class="row-fluid">
							A tese aborda seis doenças negligenciadas, elencadas como prioritárias pelo Ministério da Saúde ...<br />
							<span class="more"><a href="../record.html">Ver mais...</a></span>
						</p>
						<div id="conteudo-loop-data" class="row-fluid margintop05">
							<span class="conteudo-loop-data-tit">Sugerido em:</span>
							22/05/2013
						</div>
						<div id="conteudo-loop-idiomas" class="row-fluid">
							<span class="conteudo-loop-idiomas-tit">Idiomas disponíveis:</span>
							Português, English, Español
						</div>
						<div id="conteudo-loop-tags" class="row-fluid margintop10">
							<i class="ico-tags"></i>
							Chagas, Dengue, Hanseníase, Leishmaniose, Malária
						</div>
					</article>
					<article class="conteudo-loop">
						<div class="row-fluid">
							<h2 class="h2-loop-tit">Maecenas tincidunt quam purus, non luctus dolor convallis quis</h2>
						</div>
						<div class="conteudo-loop-rates">
							<div class="star" data-score="1"></div>
						</div>
						<span class="row-fluid margintop05">
							<a href="http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf">http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf</a>	
						</span>
						<p class="row-fluid">
							Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae ...<br />
							<span class="more"><a href="../record.html">Ver mais...</a></span>
						</p>
						<div id="conteudo-loop-data" class="row-fluid margintop05">
							<span class="conteudo-loop-data-tit">Sugerido em:</span>
							22/05/2013
						</div>
						<div id="conteudo-loop-idiomas" class="row-fluid">
							<span class="conteudo-loop-idiomas-tit">Idiomas disponíveis:</span>
							Português, English, Español
						</div>
						<div id="conteudo-loop-tags" class="row-fluid margintop10">
							<i class="ico-tags"></i>
							Donec est justo, Dapibus, Nulla dictum, Etiam suscipit
						</div>
					</article>
					<article class="conteudo-loop">
						<div class="row-fluid">
							<h2 class="h2-loop-tit">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae</h2>
						</div>
						<div class="conteudo-loop-rates">
							<div class="star" data-score="1"></div>
						</div>
						<span class="row-fluid margintop05">
							<a href="http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf">http://tpqb.eq.ufrj.br/download/farmacos-e-medicamentos-em-doencas-negligenciadas.pdf</a>	
						</span>
						<p class="row-fluid">
							Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae ...<br />
							<span class="more"><a href="../record.html">Ver mais...</a></span>
						</p>
						<div id="conteudo-loop-data" class="row-fluid margintop05">
							<span class="conteudo-loop-data-tit">Sugerido em:</span>
							22/05/2013
						</div>
						<div id="conteudo-loop-idiomas" class="row-fluid">
							<span class="conteudo-loop-idiomas-tit">Idiomas disponíveis:</span>
							Português, English, Español
						</div>
						<div id="conteudo-loop-tags" class="row-fluid margintop10">
							<i class="ico-tags"></i>
							Donec est justo, Dapibus, Nulla dictum, Etiam suscipit
						</div>
					</article>
				</div>
			</section>
			<aside id="sidebar">
				<section class="row-fluid marginbottom25 widget_categories">
					<header class="row-fluid border-bottom marginbottom15">
						<h1 class="h1-header">Categorias</h1>
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