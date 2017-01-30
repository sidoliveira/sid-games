<?php get_header(); ?>

<section class="row-fluid">
	<?php
		$args = array(
			's'	=> $_GET['s']
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
		<?php } else { ?>
		<h1 class="not-found">Nenhum resultado encontrado :(</h1>
	<?php } ?>
</section>

<?php get_footer(); ?>