<?php
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/portfolio-helpers.php';
require_once get_template_directory() . '/inc/seo.php';

function leo_port_setup(){
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
  add_theme_support('align-wide');
  add_theme_support('custom-logo');
  register_nav_menus(['primary'=>__('Menu Principal','leo-nunes-portfolio')]);
}
add_action('after_setup_theme','leo_port_setup');

function leo_port_scripts(){
  $ver = wp_get_environment_type()==='production' ? '1.0.1' : time();
  wp_enqueue_style('favicon', get_template_directory_uri().'/assets/img/favicon.png', [], $ver);
  wp_enqueue_style('apple-touch-icon', get_template_directory_uri().'/assets/img/apple-touch-icon.png', [], $ver);
  wp_enqueue_style('bootstrap-min', get_template_directory_uri().'/assets/vendor/bootstrap/css/bootstrap.min.css', [], $ver);
  wp_enqueue_style('bootstrap-icons', get_template_directory_uri().'/assets/vendor/bootstrap-icons/bootstrap-icons.css', [], $ver);
  wp_enqueue_style('aos', get_template_directory_uri().'/assets/vendor/aos/aos.css', [], $ver);
  wp_enqueue_style('glightbox-min', get_template_directory_uri().'/assets/vendor/glightbox/css/glightbox.min.css', [], $ver);
  wp_enqueue_style('swiper-bundle-min', get_template_directory_uri().'/assets/vendor/swiper/swiper-bundle.min.css', [], $ver);
  wp_enqueue_style('main', get_template_directory_uri().'/assets/css/main.css', [], $ver);
  wp_enqueue_style('theme-style', get_stylesheet_uri(), [], $ver);
  wp_enqueue_script('bootstrap-bundle-min', get_template_directory_uri().'/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', [], $ver, true);
  wp_enqueue_script('leo-contact-whatsapp', get_template_directory_uri().'/assets/js/contact-whatsapp.js', [], $ver, true);
  wp_enqueue_script('aos', get_template_directory_uri().'/assets/vendor/aos/aos.js', [], $ver, true);
  wp_enqueue_script('typed-umd', get_template_directory_uri().'/assets/vendor/typed.js/typed.umd.js', [], $ver, true);
  wp_enqueue_script('purecounter_vanilla', get_template_directory_uri().'/assets/vendor/purecounter/purecounter_vanilla.js', [], $ver, true);
  wp_enqueue_script('noframework-waypoints', get_template_directory_uri().'/assets/vendor/waypoints/noframework.waypoints.js', [], $ver, true);
  wp_enqueue_script('glightbox-min', get_template_directory_uri().'/assets/vendor/glightbox/js/glightbox.min.js', [], $ver, true);
  wp_enqueue_script('imagesloaded-pkgd-min', get_template_directory_uri().'/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js', [], $ver, true);
  wp_enqueue_script('isotope-pkgd-min', get_template_directory_uri().'/assets/vendor/isotope-layout/isotope.pkgd.min.js', [], $ver, true);
  wp_enqueue_script('swiper-bundle-min', get_template_directory_uri().'/assets/vendor/swiper/swiper-bundle.min.js', [], $ver, true);
  wp_enqueue_script('main', get_template_directory_uri().'/assets/js/main.js', [], $ver, true);
  wp_enqueue_script('leo-portfolio-loadmore', get_template_directory_uri().'/assets/js/portfolio-loadmore.js', ['main','isotope-pkgd-min','imagesloaded-pkgd-min'], $ver, true);
}
add_action('wp_enqueue_scripts','leo_port_scripts');

/**
 * Busca um campo ACF gravado na Página Inicial (estática), com fallback.
 * Funciona em qualquer template (header.php, footer.php, front-page.php),
 * pois resolve o ID da página inicial em vez de depender do post atual.
 *
 * Requer: Ajustes > Leitura > "Sua página inicial exibe" = Uma página estática.
 */
function leo_home_field( $name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$front_id = (int) get_option( 'page_on_front' );
	if ( ! $front_id ) {
		return $default;
	}
	$value = get_field( $name, $front_id );
	if ( $value === '' || $value === null || $value === false ) {
		return $default;
	}
	return $value;
}
?>