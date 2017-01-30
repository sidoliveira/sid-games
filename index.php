<?php get_header(); ?>

<section class="container-fluid destaques">
	<?php
		$args = array(
			'post_type' => 'jogos',
			'posts_per_page'      => 4,                 // Máximo de 5 artigos
      'no_found_rows'       => true,              // Não conta linhas
      'orderby'             => 'meta_value_num',  // Ordena pelo valor da post meta
      'meta_key'            => 'tp_post_counter', // A nossa post meta
      'order'               => 'DESC'             // Ordem decrescente
		);

		$mais_vistos = new WP_Query( $args );
		
		if($mais_vistos -> have_posts() ) { ?>
		<div class="row-fluid">
			<h1 class="mais-vistos">Mais Vistos</h1>
			<?php while($mais_vistos -> have_posts() ) {
				$mais_vistos -> the_post(); 
				$key_value = get_post_meta( get_the_ID(),'tp_post_counter', true ); ?>
				<div class="col-sm-3 destaque" id=<?= get_the_ID(); ?>><a href="<?= the_permalink(); ?>">
					<img src="<?= the_post_thumbnail_url(); ?>" class="imagem-destaque img-responsive">
					<h1><?php the_title(); ?></h1>
					<p class="contador-index"><span class="label label-default">Visualizações: <?php echo $key_value ?></span></p>
				</a></div>
			<?php } ?>
		</div>
	<?php } ?>
</section>
<section class="row-fluid">
	<?php
		$args = array(
			'post_type' => 'jogos',
			'posts_per_page' => 20,
		);

		$loop = new WP_Query( $args );

	 	if($loop -> have_posts() ) { ?>
			<section class="col-sm-12 ultimos-adicionados">
				<h1 class="mais-vistos">Ultimos Lançamentos</h1>
				<?php while($loop -> have_posts() ) {
					$loop-> the_post(); ?>
					<div class="jogo" id=<?= get_the_ID(); ?>><a href="<?= the_permalink(); ?>">
						<img src="<?= the_post_thumbnail_url(); ?>" class="imagem-destaque img-responsive">
						<h1><?php the_title(); ?></h1>
						<p><?php echo get_excerpt(). "..." ?></p>
					</a></div>
				<?php } ?>
			</section>
		<?php } ?>
</section>

<?php get_footer(); ?>