<?php ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle d-xl-none bi bi-list"></i>

    <?php
      $leo_avatar     = leo_home_field( 'header_avatar', get_template_directory_uri() . '/assets/img/avatar.jpg' );
      $leo_nome       = leo_home_field( 'header_nome', 'Léo Nunes' );
      $leo_whatsapp   = leo_home_field( 'link_whatsapp', '' );
      $leo_linkedin   = leo_home_field( 'link_linkedin', '' );
      $leo_facebook   = leo_home_field( 'link_facebook', '' );
      $leo_instagram  = leo_home_field( 'link_instagram', '' );
      $leo_google     = leo_home_field( 'link_google', '' );
      $leo_git        = leo_home_field( 'link_git', '' );
    ?>

    <div class="profile-img">
      <img src="<?php echo esc_url( $leo_avatar ); ?>" alt="" class="img-fluid rounded-circle">
    </div>

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo d-flex align-items-center justify-content-center">
      <h1 class="sitename"><?php echo esc_html( $leo_nome ); ?></h1>
    </a>

    <div class="social-links text-center">
      <?php if ( $leo_whatsapp ) : ?>
        <a href="<?php echo esc_url( $leo_whatsapp ); ?>" target="_blank" class="twitter"><i class="bi bi-whatsapp"></i></a>
      <?php endif; ?>
      <?php if ( $leo_linkedin ) : ?>
        <a href="<?php echo esc_url( $leo_linkedin ); ?>" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
      <?php endif; ?>
      <?php if ( $leo_facebook ) : ?>
        <a href="<?php echo esc_url( $leo_facebook ); ?>" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
      <?php endif; ?>
      <?php if ( $leo_instagram ) : ?>
        <a href="<?php echo esc_url( $leo_instagram ); ?>" target="_blank" class="instagram"><i class="bi bi-instagram"></i></a>
      <?php endif; ?>
      <?php if ( $leo_google ) : ?>
        <a href="<?php echo esc_url( $leo_google ); ?>" target="_blank" class="google-plus"><i class="bi bi-google"></i></a>
      <?php endif; ?>
      <?php if ( $leo_git ) : ?>
        <a href="<?php echo esc_url( $leo_git ); ?>" target="_blank" class="github"><i class="bi bi-github"></i></a>
      <?php endif; ?>
    </div>

    <nav id="navmenu" class="navmenu">
      <?php $leo_home_url = esc_url( home_url( '/' ) ); ?>
      <ul>
        <li><a href="<?php echo is_front_page() ? '#hero' : $leo_home_url; ?>" class="active"><i class="bi bi-house navicon"></i>Ínicio</a></li>
        <li><a href="<?php echo is_front_page() ? '#portfolio' : $leo_home_url . '#portfolio'; ?>"><i class="bi bi-images navicon"></i> Portfolio</a></li>
        <li><a href="<?php echo is_front_page() ? '#services' : $leo_home_url . '#services'; ?>"><i class="bi bi-hdd-stack navicon"></i> Serviços</a></li>
        <li><a href="<?php echo is_front_page() ? '#about' : $leo_home_url . '#about'; ?>"><i class="bi bi-person navicon"></i> Sobre</a></li>
        <li><a href="<?php echo is_front_page() ? '#resume' : $leo_home_url . '#resume'; ?>"><i class="bi bi-file-earmark-text navicon"></i> Resumo</a></li>
        <!--
        <li class="dropdown"><a href="<?php echo get_template_directory_uri(); ?>/assets/#"><i class="bi bi-menu-button navicon"></i> <span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Dropdown 1</a></li>
            <li class="dropdown"><a href="<?php echo get_template_directory_uri(); ?>/assets/#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Deep Dropdown 1</a></li>
                <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Deep Dropdown 2</a></li>
                <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Deep Dropdown 3</a></li>
                <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Deep Dropdown 4</a></li>
                <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Deep Dropdown 5</a></li>
              </ul>
            </li>
            <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Dropdown 2</a></li>
            <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Dropdown 3</a></li>
            <li><a href="<?php echo get_template_directory_uri(); ?>/assets/#">Dropdown 4</a></li>
          </ul>
        </li>
        -->
        <li><a href="<?php echo is_front_page() ? '#contact' : $leo_home_url . '#contact'; ?>"><i class="bi bi-envelope navicon"></i> Contato</a></li>
      </ul>
    </nav>

  </header>
  <!--
<header class="site-header">
  <div class="container">
    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php if (has_custom_logo()) { the_custom_logo(); } else { bloginfo('name'); } ?>
    </a>
    <?php
      wp_nav_menu([
        'theme_location'=>'primary',
        'container'=>'nav',
        'menu_class'=>'menu nav',
        'fallback_cb'=>false
      ]);
    ?>
  </div>
</header>
-->
<main role="main">
