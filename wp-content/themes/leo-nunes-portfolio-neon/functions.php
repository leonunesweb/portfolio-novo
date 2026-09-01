<?php
/**
 * Enfileira os estilos do tema-filho Neon Cyberpunk por cima do tema pai.
 * Prioridade 20 (o pai usa a padrão, 10) garante que rode depois, e a
 * dependência explícita em "main" garante a ordem de saída no <head>
 * independentemente da prioridade do hook.
 */
function leo_neon_enqueue_assets() {
	$ver = (string) filemtime( get_stylesheet_directory() . '/assets/css/neon-theme.css' );

	wp_enqueue_style(
		'google-fonts-neon',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'leo-parent-style',
		get_template_directory_uri() . '/style.css',
		[ 'main' ],
		$ver
	);

	wp_enqueue_style(
		'leo-neon-tokens',
		get_stylesheet_directory_uri() . '/assets/css/theme-tokens.css',
		[ 'main', 'google-fonts-neon' ],
		$ver
	);

	wp_enqueue_style(
		'leo-neon-theme',
		get_stylesheet_directory_uri() . '/assets/css/neon-theme.css',
		[ 'leo-neon-tokens' ],
		$ver
	);
}
add_action( 'wp_enqueue_scripts', 'leo_neon_enqueue_assets', 20 );
