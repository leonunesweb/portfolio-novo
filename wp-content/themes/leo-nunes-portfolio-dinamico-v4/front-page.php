<?php
/* Front Page generated from HTML template (static sections; scripts enqueued) */
get_header();
?>
<!-- BEGIN TEMPLATE CONTENT -->

  <main class="main">

    <!-- Hero Section -->
    <?php
      $leo_hero_bg     = leo_home_field( 'hero_bg', get_template_directory_uri() . '/assets/img/bg2.jpg' );
      $leo_hero_titulo = leo_home_field( 'hero_titulo', 'Bem vindo ao meu portfólio' );
      $leo_hero_typed  = leo_home_field( 'hero_typed', 'Analista, Desenvolvedor, Freelancer, Profissional, Antenado!, Gente boa!, Muito curioso' );
    ?>
    <section id="hero" class="hero section dark-background">

      <img src="<?php echo esc_url( $leo_hero_bg ); ?>" alt="" data-aos="fade-in" class="">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h2><?php echo esc_html( $leo_hero_titulo ); ?></h2>
        <p>Eu sou <span class="typed" data-typed-items="<?php echo esc_attr( $leo_hero_typed ); ?>">Desenvolvedor</span><span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span><span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span></p>
      </div>

    </section><!-- /Hero Section -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Portfolio</h2>
        <p>Confira alguns dos projetos e trabalhos que já desenvolvi.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <?php
          $leo_pf_terms = get_terms( [
            'taxonomy'   => 'portfolio_categoria',
            'hide_empty' => true,
          ] );
          $leo_pf_query = new WP_Query( [
            'post_type'      => 'portfolio',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
          ] );
          $leo_pf_ids      = wp_list_pluck( $leo_pf_query->posts, 'ID' );
          $leo_pf_per_page = (int) leo_home_field( 'portfolio_por_pagina', 6 );
          if ( $leo_pf_per_page <= 0 ) {
            $leo_pf_per_page = count( $leo_pf_ids );
          }
          $leo_pf_first_ids = array_slice( $leo_pf_ids, 0, $leo_pf_per_page );
          $leo_pf_rest_ids  = array_slice( $leo_pf_ids, $leo_pf_per_page );
          $leo_pf_btn_texto = leo_home_field( 'portfolio_texto_botao', 'Ver mais' );
        ?>

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <?php if ( ! is_wp_error( $leo_pf_terms ) && ! empty( $leo_pf_terms ) ) : ?>
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php foreach ( $leo_pf_terms as $leo_term ) : ?>
            <li data-filter=".filter-<?php echo esc_attr( $leo_term->slug ); ?>"><?php echo esc_html( $leo_term->name ); ?></li>
            <?php endforeach; ?>
          </ul><!-- End Portfolio Filters -->
          <?php endif; ?>

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            <?php if ( $leo_pf_first_ids ) : ?>
              <?php foreach ( $leo_pf_first_ids as $leo_pf_id ) { echo leo_portfolio_item_html( $leo_pf_id ); } ?>
            <?php else : ?>
              <p class="text-center">Nenhum item de portfólio cadastrado ainda. Adicione em <strong>Portfólio → Adicionar novo item de portfólio</strong> no admin.</p>
            <?php endif; ?>

          </div><!-- End Portfolio Container -->

          <?php if ( $leo_pf_rest_ids ) : ?>
          <template id="portfolio-extra-items">
            <?php foreach ( $leo_pf_rest_ids as $leo_pf_id ) { echo leo_portfolio_item_html( $leo_pf_id ); } ?>
          </template>
          <div class="text-center mt-4" data-aos="fade-up">
            <button type="button" id="portfolio-load-more" class="btn-load-more"><?php echo esc_html( $leo_pf_btn_texto ); ?> <i class="bi bi-arrow-down-circle ms-1"></i></button>
          </div>
          <?php endif; ?>

        </div>

      </div>

    </section><!-- /Portfolio Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Serviços</h2>
        <p>Confira os serviços que ofereço como desenvolvedor.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <?php
            $leo_srv_query = new WP_Query( [
              'post_type'      => 'servico',
              'posts_per_page' => -1,
              'orderby'        => 'menu_order date',
              'order'          => 'DESC',
            ] );
            $leo_srv_delay = 0;
          ?>
          <?php if ( $leo_srv_query->have_posts() ) : ?>
            <?php while ( $leo_srv_query->have_posts() ) : $leo_srv_query->the_post();
              $leo_srv_delay += 100;
              $leo_srv_icone = get_field( 'srv_icone' ) ?: 'bi bi-briefcase';
              $leo_srv_desc  = get_field( 'srv_descricao' );
              $leo_srv_link  = get_field( 'srv_link' );
            ?>
            <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="<?php echo (int) $leo_srv_delay; ?>">
              <div class="icon flex-shrink-0"><i class="<?php echo esc_attr( $leo_srv_icone ); ?>"></i></div>
              <div>
                <h4 class="title">
                  <?php if ( $leo_srv_link ) : ?>
                  <a href="<?php echo esc_url( $leo_srv_link ); ?>" class="stretched-link" target="_blank"><?php the_title(); ?></a>
                  <?php else : ?>
                  <?php the_title(); ?>
                  <?php endif; ?>
                </h4>
                <?php if ( $leo_srv_desc ) : ?><p class="description"><?php echo esc_html( $leo_srv_desc ); ?></p><?php endif; ?>
              </div>
            </div><!-- End Service Item -->
            <?php endwhile; wp_reset_postdata(); ?>
          <?php else : ?>
            <p class="text-center">Nenhum serviço cadastrado ainda. Adicione em <strong>Serviços → Adicionar novo serviço</strong> no admin.</p>
          <?php endif; ?>

        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- About Section -->
    <?php
      $leo_about_sub    = leo_home_field( 'about_subtitulo', 'Desenvolvedor front-end há mais de 15 anos, com histórico consistente entregando interfaces web em produção — de agências e e-commerces a uma confederação nacional. Meu foco é traduzir design em código limpo, responsivo e de fácil manutenção' );
      $leo_about_img    = leo_home_field( 'about_imagem', get_template_directory_uri() . '/assets/img/bg-header.png' );
      $leo_about_titulo2 = leo_home_field( 'about_titulo2', 'Analísta & Desenvolvedor Web.' );
      $leo_about_par1   = leo_home_field( 'about_paragrafo1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' );
      $leo_about_birthday  = leo_home_field( 'about_birthday', '1 May 1995' );
      $leo_about_website   = leo_home_field( 'about_website', 'www.example.com' );
      $leo_about_phone     = leo_home_field( 'about_phone', '+123 456 7890' );
      $leo_about_city      = leo_home_field( 'about_city', 'New York, USA' );
      $leo_about_age       = leo_home_field( 'about_age', '30' );
      $leo_about_degree    = leo_home_field( 'about_degree', 'Master' );
      $leo_about_email     = leo_home_field( 'about_email', 'email@example.com' );
      $leo_about_freelance = leo_home_field( 'about_freelance', 'Available' );
      $leo_about_par2      = leo_home_field( 'about_paragrafo2', 'Officiis eligendi itaque labore et dolorum mollitia officiis optio vero. Quisquam sunt adipisci omnis et ut. Nulla accusantium dolor incidunt officia tempore. Et eius omnis. Cupiditate ut dicta maxime officiis quidem quia. Sed et consectetur qui quia repellendus itaque neque.' );
    ?>
    <section id="about" class="about section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Sobre mim...</h2>
        <p><?php echo esc_html( $leo_about_sub ); ?></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4">
            <img src="<?php echo esc_url( $leo_about_img ); ?>" class="img-fluid" alt="" style="border-radius: 30px;">
          </div>
          <div class="col-lg-8 content">
            <h2><?php echo esc_html( $leo_about_titulo2 ); ?></h2>
            <p class="fst-italic py-3">
              <?php echo esc_html( $leo_about_par1 ); ?>
            </p>
            <div class="row">
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Nascimento:</strong> <span><?php echo esc_html( $leo_about_birthday ); ?></span></li>
                  <!--<li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span><?php echo esc_html( $leo_about_website ); ?></span></li>-->
                  <li><i class="bi bi-chevron-right"></i> <strong>Telefone:</strong> <span><?php echo esc_html( $leo_about_phone ); ?></span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Cidade:</strong> <span><?php echo esc_html( $leo_about_city ); ?></span></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Idade:</strong> <span><?php echo esc_html( $leo_about_age ); ?></span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Formação:</strong> <span><?php echo esc_html( $leo_about_degree ); ?></span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span><?php echo esc_html( $leo_about_email ); ?></span></li>
                  <!--<li><i class="bi bi-chevron-right"></i> <strong>Freelancer:</strong> <span><?php echo esc_html( $leo_about_freelance ); ?></span></li>-->
                </ul>
              </div>
            </div>
            <p class="py-3">
              <?php echo esc_html( $leo_about_par2 ); ?>
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Resume Section -->
    <section id="resume" class="resume section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Um Resumo da minha carreira profissional</h2>
        <p>Abaixo segue uma lista de várias experiências profissionais que tive ao longo da minha carreira, passando por algumas agências e empresas.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <?php
          $leo_resume_nome     = leo_home_field( 'resume_nome', 'Brandon Johnson' );
          $leo_resume_headline = leo_home_field( 'resume_headline', 'Innovative and deadline-driven Graphic Designer with 3+ years of experience designing and developing user-centered digital/print marketing material from initial concept to final, polished deliverable.' );
          $leo_resume_endereco = leo_home_field( 'resume_endereco', 'Portland par 127, Orlando, FL' );
          $leo_resume_telefone = leo_home_field( 'resume_telefone', '(123) 456-7891' );
          $leo_resume_email    = leo_home_field( 'resume_email', 'alice.barkley@example.com' );
        ?>

        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <?php
              $leo_experiencias = new WP_Query( [
                'post_type'      => 'experiencia',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'ASC',
              ] );
            ?>

            <div class="swiper init-swiper timeline-swiper">

              <script type="application/json" class="swiper-config">
              {
                "loop": false,
                "speed": 600,
                "autoplay": {
                  "delay": 6000,
                  "disableOnInteraction": false
                },
                "slidesPerView": 1,
                "spaceBetween": 30,
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": ".swiper-button-next",
                  "prevEl": ".swiper-button-prev"
                },
                "breakpoints": {
                  "768": {
                    "slidesPerView": 2,
                    "spaceBetween": 40
                  }
                }
              }
              </script>

              <div class="swiper-wrapper">

                <?php if ( $leo_experiencias->have_posts() ) : ?>
                  <?php while ( $leo_experiencias->have_posts() ) : $leo_experiencias->the_post();
                    $leo_exp_itens = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'exp_itens' ) ) ) );
                    $leo_exp_link  = get_field( 'exp_link_empresa' );
                  ?>
                  <div class="swiper-slide">
                    <div class="resume-item">
                      <h4><?php the_title(); ?></h4>
                      <h5><?php echo esc_html( get_field( 'exp_periodo' ) ); ?></h5>
                      <p>
                        <em>
                          <?php if ( $leo_exp_link ) : ?>
                          <a href="<?php echo esc_url( $leo_exp_link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_field( 'exp_empresa' ) ); ?></a>
                          <?php else : ?>
                          <?php echo esc_html( get_field( 'exp_empresa' ) ); ?>
                          <?php endif; ?>
                        </em>
                      </p>
                      <?php if ( $leo_exp_itens ) : ?>
                      <ul>
                        <?php foreach ( $leo_exp_itens as $leo_item ) : ?>
                        <li><?php echo esc_html( $leo_item ); ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <?php endif; ?>
                    </div>
                  </div><!-- End timeline slide -->
                  <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                  <div class="swiper-slide">
                    <div class="resume-item">
                      <h4>Senior graphic design specialist</h4>
                      <h5>2019 - Present</h5>
                      <p><em>Experion, New York, NY</em></p>
                      <p>Cadastre sua experiência no admin em "Experiência Profissional" → Adicionar nova.</p>
                    </div>
                  </div>
                <?php endif; ?>

              </div><!-- End swiper-wrapper -->

              <div class="swiper-pagination"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>

            </div><!-- End timeline swiper -->

          </div>


        </div>

      </div>

    </section><!-- /Resume Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Skills</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <?php
          $leo_skills_defaults = [
            1 => [ 'nome' => 'HTML',           'percentual' => 100 ],
            2 => [ 'nome' => 'CSS',             'percentual' => 95 ],
            3 => [ 'nome' => 'JavaScript',      'percentual' => 75 ],
            4 => [ 'nome' => 'React',           'percentual' => 50 ],
            5 => [ 'nome' => 'Angular',         'percentual' => 76 ],
            6 => [ 'nome' => 'PHP',             'percentual' => 80 ],
            7 => [ 'nome' => 'WordPress/CMS',   'percentual' => 90 ],
            8 => [ 'nome' => 'Photoshop',       'percentual' => 55 ],
            9 => [ 'nome' => 'Figma',           'percentual' => 77 ],
          ];
          $leo_skills = [];
          foreach ( $leo_skills_defaults as $i => $def ) {
            $skill = wp_parse_args( leo_home_field( "skill_$i", $def ), $def );
            if ( trim( $skill['nome'] ) !== '' ) {
              $leo_skills[] = $skill;
            }
          }
          $leo_skills_metade = ceil( count( $leo_skills ) / 2 );
          $leo_skills_col1   = array_slice( $leo_skills, 0, $leo_skills_metade );
          $leo_skills_col2   = array_slice( $leo_skills, $leo_skills_metade );
        ?>

        <div class="row skills-content skills-animation">

          <div class="col-lg-6">
            <?php foreach ( $leo_skills_col1 as $skill ) : ?>
            <div class="progress">
              <span class="skill"><span><?php echo esc_html( $skill['nome'] ); ?></span> <i class="val"><?php echo (int) $skill['percentual']; ?>%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo (int) $skill['percentual']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div><!-- End Skills Item -->
            <?php endforeach; ?>
          </div>

          <div class="col-lg-6">
            <?php foreach ( $leo_skills_col2 as $skill ) : ?>
            <div class="progress">
              <span class="skill"><span><?php echo esc_html( $skill['nome'] ); ?></span> <i class="val"><?php echo (int) $skill['percentual']; ?>%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo (int) $skill['percentual']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div><!-- End Skills Item -->
            <?php endforeach; ?>
          </div>

        </div>

      </div>

    </section><!-- /Skills Section -->

    <!-- Stats Section -->
    <?php
      $leo_stats_defaults = [
        1 => [ 'icone' => 'bi bi-emoji-smile',       'numero' => 232,  'label' => 'Happy Clients',      'descricao' => 'consequuntur quae' ],
        2 => [ 'icone' => 'bi bi-journal-richtext',  'numero' => 521,  'label' => 'Projects',           'descricao' => 'adipisci atque cum quia aut' ],
        3 => [ 'icone' => 'bi bi-headset',           'numero' => 1453, 'label' => 'Hours Of Support',   'descricao' => 'aut commodi quaerat' ],
        4 => [ 'icone' => 'bi bi-people',            'numero' => 32,   'label' => 'Hard Workers',       'descricao' => 'rerum asperiores dolor' ],
      ];
    ?>
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <?php foreach ( $leo_stats_defaults as $i => $def ) :
            $stat = leo_home_field( "stat_$i", $def );
            $stat = wp_parse_args( $stat, $def );
          ?>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item">
              <i class="<?php echo esc_attr( $stat['icone'] ); ?>"></i>
              <span data-purecounter-start="0" data-purecounter-end="<?php echo (int) $stat['numero']; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong><?php echo esc_html( $stat['label'] ); ?></strong> <span><?php echo esc_html( $stat['descricao'] ); ?></span></p>
            </div>
          </div><!-- End Stats Item -->
          <?php endforeach; ?>

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>O que dizem sobre o meu trabalho</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <?php
          $leo_dep_query = new WP_Query( [
            'post_type'      => 'depoimento',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
          ] );
        ?>

        <div class="swiper init-swiper">

          <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 5000,
              "disableOnInteraction": false
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            }
          }
          </script>

          <div class="swiper-wrapper">

            <?php if ( $leo_dep_query->have_posts() ) : ?>
              <?php while ( $leo_dep_query->have_posts() ) : $leo_dep_query->the_post();
                $leo_dep_cargo = get_field( 'dep_cargo' );
                $leo_dep_texto = get_field( 'dep_texto' );
                $leo_dep_img   = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                if ( ! $leo_dep_img ) {
                  $leo_dep_img = get_template_directory_uri() . '/assets/img/testimonials/testimonials-1.jpg';
                }
              ?>
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span><?php echo esc_html( $leo_dep_texto ); ?></span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                  <img src="<?php echo esc_url( $leo_dep_img ); ?>" class="testimonial-img" alt="<?php the_title_attribute(); ?>">
                  <h3><?php the_title(); ?></h3>
                  <?php if ( $leo_dep_cargo ) : ?><h4><?php echo esc_html( $leo_dep_cargo ); ?></h4><?php endif; ?>
                </div>
              </div><!-- End testimonial item -->
              <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <p>Cadastre depoimentos em <strong>Depoimentos → Adicionar novo depoimento</strong> no admin.</p>
                </div>
              </div>
            <?php endif; ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contato</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <?php
        $leo_contact_endereco = leo_home_field( 'contact_endereco', 'A108 Adam Street, New York, NY 535022' );
        $leo_contact_telefone = leo_home_field( 'contact_telefone', '+1 5589 55488 55' );
        $leo_contact_email    = leo_home_field( 'contact_email', 'info@example.com' );
        $leo_contact_mapa     = leo_home_field( 'contact_mapa_embed', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus' );
      ?>
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">

            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Endereço</h3>
                  <p><?php echo esc_html( $leo_contact_endereco ); ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Telefone</h3>
                  <p><?php echo esc_html( $leo_contact_telefone ); ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p><?php echo esc_html( $leo_contact_email ); ?></p>
                </div>
              </div><!-- End Info Item -->

              <iframe src="<?php echo esc_url( $leo_contact_mapa ); ?>" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-7">
            <?php
              $leo_wa_link  = leo_home_field( 'link_whatsapp', '' );
              $leo_wa_phone = '';
              if ( $leo_wa_link && preg_match( '/(?:phone=|wa\.me\/)(\d+)/', $leo_wa_link, $leo_wa_matches ) ) {
                $leo_wa_phone = $leo_wa_matches[1];
              }
            ?>
            <form method="post" class="php-email-form" data-whatsapp-phone="<?php echo esc_attr( $leo_wa_phone ); ?>" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Seu nome</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>

                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Seu Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Assunto</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Mensagem</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" maxlength="1000" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Enviando</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Abrindo o WhatsApp para você confirmar o envio...</div>

                  <button type="submit">Enviar</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <?php $leo_footer_nome = leo_home_field( 'footer_nome_site', 'Léo Nunes' ); ?>
  <footer id="footer" class="footer position-relative light-background">

    <div class="container">
      <div class="copyright text-center ">
        <p>© <span>Copyright</span> <strong class="px-1 sitename"><?php echo esc_html( $leo_footer_nome ); ?></strong> <span>Todos Direitos Reservados</span></p>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] 
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a>-->
      </div>
    </div>

  </footer>

<!-- END TEMPLATE CONTENT -->
<?php get_footer(); ?>
