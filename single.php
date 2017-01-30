<?php
	get_header();
	$key_value = get_post_meta( $post->ID,'tp_post_counter', true );
	$jogos_meta_data = get_post_meta($post->ID);
?>

<section class="container-fluid">
	<?php if( have_posts() ) { ?>
		<div class="row-fluid conteudo-single">
			<?php while( have_posts() ) {
				the_post(); ?>
				<h1 class="single-title title-taxonomy"><?php the_title(); ?></h1>
				<img src="<?= the_post_thumbnail_url(); ?>" alt="" class="img-responsive single-image">
				<p class="contador"><span class="label label-default">Visualizações: <?php echo $key_value ?></span></p>
				<div class="container">
			 		<table class="table table-infos">
					  <thead>
					    <tr>
					      <th><i class="material-icons">people</i> <p><?= "PLAYERS: ".$jogos_meta_data['players'][0];?></p></th>
					      <th><i class="material-icons">language</i> <p><?= "ONLINE: ".$jogos_meta_data['online'][0];?></p></th>
					      <th><i class="material-icons">save</i> <p><?= "ARMAZENAMENTO: ".$jogos_meta_data['armazenamento'][0];?></p></th>
					      <th><i class="material-icons">tv</i> <p><?= "RESOLUÇÃO: ".$jogos_meta_data['resolucao'][0];?></p></th>
					    </tr>
					  </thead>
					</table>
			 	</div>
			 	<div class="row"></div>
			 	<p><?php the_content(); ?></p>
			<?php	} ?>
		</div>
	<?php } ?>
</section>

<?php
	
	$terms = get_the_terms( $post->ID, 'plataformas'); 
  $plataforma = $terms[0]->slug;

	$taxonomy_args = array(
		array(
			'taxonomy' => 'plataformas',
			'field' => 'slug',
			'terms' => $plataforma,
			
		)
	);

?>

	<h2></h2>

<?php

	$args = array(
		'post_type' => 'jogos',
		'posts_per_page'	=> 6,
		'tax_query' => $taxonomy_args,
		'post__not_in' => array($post->ID),
		'orderby'   => 'rand',
	);
?>

<?php $loop = new WP_Query( $args );

if($loop -> have_posts() ) { ?>
<section class="container-fluid ultimos-adicionados">
	<h1 class="mais-vistos">Jogos Relacionados</h1>
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