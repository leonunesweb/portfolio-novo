<?php
/**
 * SEO — meta tags, dados estruturados (JSON-LD), robots.txt e llms.txt.
 *
 * Não instala nenhum plugin de SEO: usa apenas recursos nativos do WordPress
 * mais os campos ACF da Página Inicial (aba "SEO").
 */

/**
 * Esconde a versão do WordPress no <head> (não ajuda o SEO em si, mas
 * evita expor a versão exata do core para quem quer explorar vulnerabilidades
 * conhecidas de versões antigas).
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Meta description + Open Graph + Twitter Card.
 */
function leo_seo_meta_tags() {

	$is_home = is_front_page();

	$titulo      = $is_home ? leo_home_field( 'seo_titulo', '' ) : '';
	$descricao   = $is_home
		? leo_home_field( 'seo_descricao', get_bloginfo( 'description' ) )
		: wp_trim_words( wp_strip_all_tags( get_the_excerpt() ?: get_the_content() ), 30, '…' );
	$imagem      = $is_home ? leo_home_field( 'seo_imagem', '' ) : ( has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '' );
	$url_atual   = $is_home ? home_url( '/' ) : ( is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) ) );
	$titulo_site = $titulo ?: ( $is_home ? get_bloginfo( 'name' ) . ' — ' . get_bloginfo( 'description' ) : wp_get_document_title() );

	if ( ! $descricao ) {
		$descricao = get_bloginfo( 'description' );
	}

	echo "\n<!-- SEO meta (tema) -->\n";

	if ( $descricao ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $descricao ) );
	}

	printf( '<meta property="og:type" content="%s">' . "\n", $is_home ? 'website' : 'article' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $titulo_site ) );
	if ( $descricao ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $descricao ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url_atual ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	if ( $imagem ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $imagem ) );
	}

	printf( '<meta name="twitter:card" content="%s">' . "\n", $imagem ? 'summary_large_image' : 'summary' );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $titulo_site ) );
	if ( $descricao ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $descricao ) );
	}
	if ( $imagem ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $imagem ) );
	}
}
add_action( 'wp_head', 'leo_seo_meta_tags', 1 );

/**
 * Dados estruturados (JSON-LD) — Schema.org Person, só na página inicial.
 * Ajuda o Google a entender quem é você e a exibir "rich results".
 */
function leo_seo_json_ld() {
	if ( ! is_front_page() ) {
		return;
	}

	$nome      = leo_home_field( 'header_nome', get_bloginfo( 'name' ) );
	$avatar    = leo_home_field( 'header_avatar', '' );
	$headline  = leo_home_field( 'resume_headline', get_bloginfo( 'description' ) );
	$email     = leo_home_field( 'contact_email', '' );
	$telefone  = leo_home_field( 'contact_telefone', '' );

	$sameas = array_filter( [
		leo_home_field( 'link_linkedin', '' ),
		leo_home_field( 'link_facebook', '' ),
		leo_home_field( 'link_instagram', '' ),
		leo_home_field( 'link_google', '' ),
		leo_home_field( 'link_git', '' ),
	] );

	$data = [
		'@context'  => 'https://schema.org',
		'@type'     => 'Person',
		'name'      => $nome,
		'url'       => home_url( '/' ),
		'jobTitle'  => leo_home_field( 'about_titulo2', '' ),
		'description' => wp_strip_all_tags( $headline ),
	];

	if ( $avatar ) {
		$data['image'] = $avatar;
	}
	if ( $email ) {
		$data['email'] = $email;
	}
	if ( $telefone ) {
		$data['telephone'] = $telefone;
	}
	if ( $sameas ) {
		$data['sameAs'] = array_values( $sameas );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>' . "\n";
}
add_action( 'wp_head', 'leo_seo_json_ld', 2 );

/**
 * Corrige um bug do WordPress em que /wp-sitemap.xml (e as demais URLs de
 * sitemap nativas) respondem com status 404 mesmo servindo o XML certo no
 * corpo — o WP_Query não reconhece a query var "sitemap" antes de decidir
 * se a página é 404. Sem isso, o Google Search Console descarta o sitemap
 * por causa do status HTTP errado, mesmo o conteúdo estando correto.
 */
function leo_seo_fix_sitemap_404( $preempt, $wp_query ) {
	if ( get_query_var( 'sitemap' ) || get_query_var( 'sitemap-stylesheet' ) ) {
		return true;
	}
	return $preempt;
}
add_filter( 'pre_handle_404', 'leo_seo_fix_sitemap_404', 10, 2 );

/**
 * robots.txt — o WordPress já gera um robots.txt "virtual" em /robots.txt.
 * Aqui só adicionamos a linha do Sitemap (o WP já gera um sitemap XML
 * nativo, sem plugin, disponível em /wp-sitemap.xml desde a versão 5.5).
 */
function leo_seo_robots_txt( $output, $public ) {
	if ( '0' === (string) $public ) {
		// Site marcado como "Desencorajar mecanismos de busca" em Ajustes → Leitura: não mexe.
		return $output;
	}
	$output .= "\nSitemap: " . home_url( '/wp-sitemap.xml' ) . "\n";
	return $output;
}
add_filter( 'robots_txt', 'leo_seo_robots_txt', 10, 2 );

/**
 * llms.txt — arquivo em texto simples na raiz do site (/llms.txt), no
 * mesmo espírito do robots.txt, mas voltado a ferramentas de IA/LLM que
 * queiram entender do que o site trata. É um padrão ainda emergente
 * (não é garantido que toda IA o leia), mas não tem custo nenhum ter.
 */
function leo_llms_txt_rewrite() {
	add_rewrite_rule( '^llms\.txt$', 'index.php?leo_llms_txt=1', 'top' );
}
add_action( 'init', 'leo_llms_txt_rewrite' );

function leo_llms_txt_query_vars( $vars ) {
	$vars[] = 'leo_llms_txt';
	return $vars;
}
add_filter( 'query_vars', 'leo_llms_txt_query_vars' );

function leo_llms_txt_render() {
	if ( ! get_query_var( 'leo_llms_txt' ) ) {
		return;
	}

	header( 'Content-Type: text/plain; charset=utf-8' );

	$nome      = leo_home_field( 'header_nome', get_bloginfo( 'name' ) );
	$headline  = wp_strip_all_tags( leo_home_field( 'resume_headline', get_bloginfo( 'description' ) ) );
	$sobre     = wp_strip_all_tags( leo_home_field( 'about_paragrafo2', '' ) );

	echo "# {$nome}\n\n";
	echo "> {$headline}\n\n";
	if ( $sobre ) {
		echo "{$sobre}\n\n";
	}

	echo "## Páginas\n\n";
	echo '- [Início](' . home_url( '/' ) . ")\n";
	echo '- [Portfólio](' . home_url( '/#portfolio' ) . ")\n";
	echo '- [Serviços](' . home_url( '/#services' ) . ")\n";
	echo '- [Contato](' . home_url( '/#contact' ) . ")\n";

	$paginas = get_pages( [ 'sort_column' => 'menu_order' ] );
	if ( $paginas ) {
		foreach ( $paginas as $pagina ) {
			if ( (int) get_option( 'page_on_front' ) === $pagina->ID ) {
				continue;
			}
			echo '- [' . esc_html( $pagina->post_title ) . '](' . get_permalink( $pagina ) . ")\n";
		}
	}

	echo "\n## Sitemap\n\n" . home_url( '/wp-sitemap.xml' ) . "\n";

	exit;
}
add_action( 'template_redirect', 'leo_llms_txt_render' );

/**
 * Garante que as regras de rewrite (usadas pelo /llms.txt) sejam
 * regravadas quando o tema for ativado, senão a URL dá 404 até o admin
 * salvar os links permanentes manualmente uma vez.
 */
function leo_seo_flush_rewrites() {
	leo_llms_txt_rewrite();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'leo_seo_flush_rewrites' );
