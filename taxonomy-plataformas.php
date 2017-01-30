<?php get_header(); ?>

<section class="row-fluid">
	<h2 class="title-taxonomy">Jogos - <?= single_cat_title(); ?></h2>
	
	<?php $taxonomies = get_terms('generos'); ?>
	<form class="form-genero" action="<?= bloginfo('url').$_SERVER["REQUEST_URI"]; ?>" method="get">
		<div class="generos-select">
			<select name="generos">
				<option  value="todos">Todos os generos</option>
				<?php foreach($taxonomies as $taxonomy) { ?>
				<option value="<?= $taxonomy->slug; ?>" <?php echo selecionado( $taxonomy->slug, $_GET['generos']); ?>><?= $taxonomy->name; ?></option>
				<?php } ?>
			</select>
		</div>
		<button class="btn btn-default btn-lg center-block" type="submit">Filtrar</button>
	</form>

	<?php
		if( $_GET['generos'] != "todos" && $_GET['generos'] != "") {
			$taxonomy_args = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'generos',
					'field' => 'slug',
					'terms' => $_GET['generos'],
				),
				array(
					'taxonomy' => 'plataformas',
					'field' => 'slug',
					'terms' => get_query_var('term'),
				)
			);
		}
		else{
			$taxonomy_args = array(
				array(
					'taxonomy' => 'plataformas',
					'field' => 'slug',
					'terms' => get_query_var('term'),
				)
			);
		}
	
		$args = array(
			'post_type' => 'jogos',
			'tax_query' => $taxonomy_args,
		);
	?>

		<?php $loop = new WP_Query( $args );
	 	if($loop ->have_posts() ) { ?>
		<section class="col-sm-12 ultimos-adicionados">
				<?php while( $loop -> have_posts() ) {
					$loop ->the_post(); ?>
					<div class="jogo" id=<?= get_the_ID(); ?>><a href="<?= the_permalink(); ?>">
						<img src="<?= the_post_thumbnail_url(); ?>" class="imagem-destaque img-responsive">
						<h1><?php the_title(); ?></h1>
						<p><?= get_excerpt(). "..." ?></p>
					</a></div>
				<?php } ?>
		</section>
		<?php } else { ?>
			<h1 class="not-found">Nenhum jogo encontrado :(</h1>
		<?php } ?>
</section>
<?php get_footer(); ?>