<?php
/**
 * Renderiza o HTML de um item de portfólio (usado tanto no lote inicial
 * quanto no lote "escondido" que o botão Ver mais revela).
 */
function leo_portfolio_item_html( $post_id ) {
	$terms   = get_the_terms( $post_id, 'portfolio_categoria' );
	$classes = '';
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			$classes .= ' filter-' . $t->slug;
		}
	}

	$img = get_the_post_thumbnail_url( $post_id, 'large' );
	if ( ! $img ) {
		$img = get_template_directory_uri() . '/assets/img/portfolio/app-1.jpg';
	}

	$desc         = get_field( 'pf_descricao', $post_id );
	$link         = get_field( 'pf_link', $post_id );
	$img_lightbox = get_field( 'pf_imagem_lightbox', $post_id ) ?: $img;
	$title        = get_the_title( $post_id );

	ob_start();
	?>
	<div class="col-lg-4 col-md-6 portfolio-item isotope-item<?php echo esc_attr( $classes ); ?>">
		<div class="portfolio-content h-100">
			<img src="<?php echo esc_url( $img ); ?>" class="img-fluid" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
			<div class="portfolio-info">
				<h4><?php echo esc_html( $title ); ?></h4>
				<?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
				<a href="<?php echo esc_url( $img_lightbox ); ?>" title="<?php echo esc_attr( $title ); ?>" data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
				<?php if ( $link ) : ?>
				<a href="<?php echo esc_url( $link ); ?>" title="Mais detalhes" target="_blank" rel="noopener" class="details-link"><i class="bi bi-link-45deg"></i></a>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- End Portfolio Item -->
	<?php
	return ob_get_clean();
}
