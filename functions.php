<?php 

//Suporte para Imagens de destaque
add_theme_support( 'post-thumbnails' );

//Pegar tituto da p;agina
function get_titulo() {
	if( is_home() ) {
		bloginfo('name');
	} else {
		bloginfo('name');
		echo ' | ';
		the_title();
	}
}

//Função para limitar resumo
function get_excerpt(){
	$excerpt = get_the_content();
	$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, 150);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	return $excerpt;
}

// Registro do Custom Post Jogos
add_action( 'init', 'custom_post_type_jogos', 0 );
function custom_post_type_jogos() {

	$labels = array(
		'name'                  => 'Jogos',
		'singular_name'         => 'Jogo',
		'menu_name'             => 'Jogos',
		'all_items'             => 'Todos os jogos',
		'add_new_item'          => 'Adicionar novo jogo',
		'add_new'               => 'Adicionar novo jogo',
		'new_item'              => 'Novo jogo',
		'edit_item'             => 'Editar jogo',
		'update_item'           => 'Alterar jogo',
		'view_item'             => 'Ver jogo',
		'view_items'            => 'Ver jogos',
		'search_items'          => 'Procurar jogo',
		'not_found'             => 'Jogo não encontrado',
		'featured_image'        => 'Adicionar imagem do jogo',
		'set_featured_image'    => 'Adicionar imagem do jogo',
		'remove_featured_image' => 'Remover imagem do jogo',
		'items_list'            => 'Listar Jogos',
	);
	$args = array(
		'label'                 => 'Jogo',
		'description'           => 'Pos Type de Jogos',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields',),
		'public'                => true,
		'menu_position'         => 5,
		'capability_type'       => 'page',
		'menu_icon'   => 'dashicons-editor-kitchensink',
	);
	register_post_type( 'jogos', $args );

}

// Registro das Plataformas
add_action( 'init', 'custom_taxonomy_plataformas', 0 );
function custom_taxonomy_plataformas() {

	$labels = array(
		'name'                       => 'Plataformas',
		'singular_name'              => 'Plataforma',
		'menu_name'                  => 'Plataformas',
		'all_items'                  => 'Todas as plataformas',
		'new_item_name'              => 'Nova plataforma',
		'add_new_item'               => 'Adicionar nova plataforma',
		'edit_item'                  => 'Editar plataforma',
		'update_item'                => 'Alterar plataforma',
		'view_item'                  => 'Ver plataforma',
		'add_or_remove_items'        => 'Adicionar ou remover plataformas',
		'choose_from_most_used'      => 'Escolher a plataforma mais usada',
		'popular_items'              => 'Plataformas populares',
		'search_items'               => 'Pesquisar plataformas',
		'not_found'                  => 'Plataforma não encontrada',
		'no_terms'                   => 'Nenhuma plataforma',
		'items_list'                 => 'Lista das plataformas',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
	);
	register_taxonomy( 'plataformas', array( 'jogos' ), $args );

}

//Função para selecionar o option dos jogos
function selecionado( $value, $selecionado ){
    return $value==$selecionado ? ' selected="selected"' : '';
}

// Registro dos Generos
add_action( 'init', 'custom_taxonomy_generos', 0 );
function custom_taxonomy_generos() {

	$labels = array(
		'name'                       => 'Generos',
		'singular_name'              => 'Genero',
		'menu_name'                  => 'Generos',
		'all_items'                  => 'Todos os generos',
		'new_item_name'              => 'Novo genero',
		'add_new_item'               => 'Adicionar novo genero',
		'edit_item'                  => 'Editar genero',
		'update_item'                => 'Alterar genero',
		'view_item'                  => 'Ver genero',
		'add_or_remove_items'        => 'Adicionar ou remover generos',
		'choose_from_most_used'      => 'Escolher o genero mais usado',
		'popular_items'              => 'Generos populares',
		'search_items'               => 'Pesquisar generos',
		'not_found'                  => 'Genero não encontrado',
		'no_terms'                   => 'Nenhum genero',
		'items_list'                 => 'Lista dos generos',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
	);
	register_taxonomy( 'generos', array( 'jogos' ), $args );

}

//Função para registrar menu
add_action( 'init', 'registrar_menu_navegacao');
function registrar_menu_navegacao() {
	register_nav_menu('header-menu', 'Menu Header');
}

//Função para os posts mais vistos
add_action( 'init', 'tutsup_session_start' );
function tutsup_session_start() {
    // Inicia uma sessão PHP
    if ( ! session_id() ) session_start();
}

// Conta os views do post
add_action( 'get_header', 'tp_count_post_views' );
function tp_count_post_views () {	
  // Garante que vamos tratar apenas de posts
  if ( is_single() ) {    
    // Precisamos da variável $post global para obter o ID do post
    global $post;        
    // Se a sessão daquele posts não estiver vazia
    if ( empty( $_SESSION[ 'tp_post_counter_' . $post->ID ] ) ) {            
      // Cria a sessão do posts
      $_SESSION[ 'tp_post_counter_' . $post->ID ] = true;  
      // Cria ou obtém o valor da chave para contarmos
      $key = 'tp_post_counter';
      $key_value = get_post_meta( $post->ID, $key, true );      
      // Se a chave estiver vazia, valor será 1
      if ( empty( $key_value ) ) { // Verifica o valor
          $key_value = 1;
          update_post_meta( $post->ID, $key, $key_value );
      } else {
          // Caso contrário, o valor atual + 1
          $key_value += 1;
          update_post_meta( $post->ID, $key, $key_value );
      } // Verifica o valor    
    } // Checa a sessão    
  } // is_single
  return;  
}

//Meta-boxes dos Jogos
add_action('add_meta_boxes', 'registra_meta_info_jogo');

function registra_meta_info_jogo(){
	add_meta_box(
		'infos-adicionais',
		'Informações Adicionais',
		'informacoes_jogo_view',
		'jogos',
		'normal',
		'low'
	);
}

function informacoes_jogo_view($post){ 
	$jogos_meta_data = get_post_meta($post->ID);
?>
	<style>
		.metabox-lista {
			width: 100%;
		}
		.metabox-item label {
			font-size: 16px;
			margin-right: 20px;
		}
		.metabox-item{
			margin: 20px;
		}
		.metabox-input{
			float: right;
		}
	</style>
	<section class="metabox-lista">
		<div class="metabox-item">
			<label for="players"><b>Qtd. de Players (1/1-2/1-4): </b></label>
			<input id="players" class="metabox-input" type="text" name="players" value="<?= $jogos_meta_data['players'][0]; ?>">
		</div>
		<div class="metabox-item">
			<label for="online"><b>Opção Online (Sim/Não): </b></label>
			<input id="online" class="metabox-input" type="text" name="online" value="<?= $jogos_meta_data['online'][0]; ?>">
		</div>
		<div class="metabox-item">
			<label for="armazenamento"><b>Armazenamento (Local): </b></label>
			<input id="armazenamento" class="metabox-input" type="text" name="armazenamento" value="<?= $jogos_meta_data['armazenamento'][0]; ?>">
		</div>
		<div class="metabox-item">
			<label for="resolucao"><b>Resolução (Pixels): </b></label>
			<input id="resolucao" class="metabox-input" type="text" name="resolucao" value="<?= $jogos_meta_data['resolucao'][0]; ?>">
		</div>
	</section>
<?php }

add_action('save_post', 'salvar_meta_info_jogos');
function salvar_meta_info_jogos($post_id) {
	if(isset($_POST['players'])){
		update_post_meta($post_id, 'players', sanitize_text_field($_POST['players']) );
	}
	if(isset($_POST['online'])){
		update_post_meta($post_id, 'online', sanitize_text_field($_POST['online']));
	}
	if(isset($_POST['armazenamento'])){
		update_post_meta($post_id, 'armazenamento', sanitize_text_field($_POST['armazenamento']));
	}
	if(isset($_POST['resolucao'])){
		update_post_meta($post_id, 'resolucao', sanitize_text_field($_POST['resolucao']));
	}
}

//Função para a paginação

function paginacao() {
	global $wp_query;
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	$big = 999999999;
 
	return paginate_links(
		array(
			'base' => @add_query_arg('paged','%#%'),
			'format' => '?paged=%#%',
			'current' => $current,
			'total' => $wp_query->max_num_pages,
			'prev_next'    => false
		)
	);
}

?>