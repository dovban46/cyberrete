<?php
/**
 * Flexible layout: technology_stack
 *
 * ACF group: technology_stack_section
 *   - technology_stack_title (text)
 *   - technology_stack_intro (textarea / wysiwyg)
 *   - technology_stack_items (repeater)
 *       - item_icon (image)
 *       - item_title (text)
 *       - item_text (textarea / wysiwyg)
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

if ( ! function_exists( 'cyberrete_technology_stack_title_html' ) ) {
	/**
	 * Wrap last two words with gradient span.
	 *
	 * @param string $title Raw title.
	 * @return string
	 */
	function cyberrete_technology_stack_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$total = count( $words );
		if ( $total < 2 ) {
			return esc_html( implode( ' ', $words ) );
		}

		$html_words = array();
		foreach ( $words as $index => $word ) {
			if ( $index >= $total - 2 ) {
				$html_words[] = '<span class="technology-stack__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html_words[] = esc_html( $word );
			}
		}

		return implode( ' ', $html_words );
	}
}
?>
<section class="technology-stack">
	<div class="technology-stack__container js-technology-stack-section js-animate">
		<?php if ( have_rows( 'technology_stack_section' ) ) : ?>
			<?php
			while ( have_rows( 'technology_stack_section' ) ) :
				the_row();

				$title = get_sub_field( 'technology_stack_title' );
				$intro = get_sub_field( 'technology_stack_intro' );
				?>

				<div class="technology-stack__top">
					<?php if ( $title ) : ?>
						<h2 class="technology-stack__title js-stagger-item">
							<?php
							echo wp_kses(
								cyberrete_technology_stack_title_html( $title ),
								array(
									'span' => array( 'class' => true ),
								)
							);
							?>
						</h2>
					<?php endif; ?>

					<?php if ( $intro ) : ?>
						<div class="technology-stack__intro js-stagger-item">
							<?php echo wp_kses_post( wpautop( $intro ) ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( have_rows( 'technology_stack_items' ) ) : ?>
					<div class="technology-stack__slider-layout js-stagger-item">
						<div class="technology-stack__nav" aria-hidden="false">
							<button
								type="button"
								class="technology-stack__nav-btn technology-stack__nav-btn--prev js-technology-stack-prev"
								aria-label="<?php esc_attr_e( 'Previous item', 'cyberrete' ); ?>"
							>
								<span class="technology-stack__nav-visual" aria-hidden="true">
									<img
										src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
										alt=""
										class="technology-stack__nav-svg technology-stack__nav-svg--active"
										width="32"
										height="32"
										decoding="async"
									>
									<img
										src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
										alt=""
										class="technology-stack__nav-svg technology-stack__nav-svg--block"
										width="32"
										height="32"
										decoding="async"
									>
								</span>
							</button>
							<button
								type="button"
								class="technology-stack__nav-btn technology-stack__nav-btn--next js-technology-stack-next"
								aria-label="<?php esc_attr_e( 'Next item', 'cyberrete' ); ?>"
							>
								<span class="technology-stack__nav-visual" aria-hidden="true">
									<img
										src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
										alt=""
										class="technology-stack__nav-svg technology-stack__nav-svg--active"
										width="32"
										height="32"
										decoding="async"
									>
									<img
										src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
										alt=""
										class="technology-stack__nav-svg technology-stack__nav-svg--block"
										width="32"
										height="32"
										decoding="async"
									>
								</span>
							</button>
						</div>

						<div class="technology-stack__slider swiper js-technology-stack-slider">
							<div class="technology-stack__track swiper-wrapper">
								<?php
								while ( have_rows( 'technology_stack_items' ) ) :
									the_row();

									$item_icon  = get_sub_field( 'item_icon' );
									$item_title = get_sub_field( 'item_title' );
									$item_text  = get_sub_field( 'item_text' );

									if ( ! $item_title && ! $item_text && empty( $item_icon ) ) {
										continue;
									}
									?>
									<div class="technology-stack__slide swiper-slide">
										<article class="technology-stack__item">
											<?php if ( ! empty( $item_icon['url'] ) ) : ?>
												<div class="technology-stack__icon-wrap">
													<img
														src="<?php echo esc_url( $item_icon['url'] ); ?>"
														alt="<?php echo esc_attr( ! empty( $item_icon['alt'] ) ? $item_icon['alt'] : '' ); ?>"
														class="technology-stack__icon"
														width="52"
														height="52"
														loading="lazy"
														decoding="async"
													>
												</div>
											<?php endif; ?>

											<div class="technology-stack__item-content">
												<?php if ( $item_title ) : ?>
													<h3 class="technology-stack__item-title"><?php echo esc_html( $item_title ); ?></h3>
												<?php endif; ?>

												<?php if ( $item_text ) : ?>
													<div class="technology-stack__item-text">
														<?php echo wp_kses_post( wpautop( $item_text ) ); ?>
													</div>
												<?php endif; ?>
											</div>
										</article>
									</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</section>
