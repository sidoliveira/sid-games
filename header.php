<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title><?php get_titulo(); ?></title>
	<?php $src = get_template_directory_uri(); ?>
	<link rel="stylesheet" href="<?= $src. '/style.css' ?>">
	<link rel="stylesheet" href="<?= $src. '/css/bootstrap.min.css' ?>">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body>
	<header>
		<div class="logo row-fluid">
			<a href="<?= bloginfo('url') ?>"><img src="<?= $src.'/imgs/logo.png' ?>" alt="Logo - Sid Games"></a>
		</div>
		<nav class="menu">
			<div class="conteudo-pesquisa">
			  <div id="custom-search-input">
			    <form class="input-group col-md-12" action="<?php echo home_url( '/' ); ?>" role="search" method="get">
			      <input type="search" class="form-control input-lg" placeholder="Buscar" value="<?php echo get_search_query() ?>" name="s" />
			      <span class="input-group-btn">
			        <button class="btn btn-info btn-lg" type="submit" value="Pesquisar">
			          <i class="glyphicon glyphicon-search"></i>
			        </button>
			      </span>
			    </form>
			  </div>
			</div>
			<?php
				$args = array( 'theme_location' => 'header-menu');
				wp_nav_menu( $args ); 
			?>
		</nav>	
	</header>