<?php
/**
 * Flexible layout: secure_deployment
 *
 * ACF: secure_deployment_section
 *   - secure_deployment_title (text)
 *   - secure_deployment_items (repeater)
 *       - item_title (text)
 *       - item_text (textarea / WYSIWYG)
 *       - item_hover_image (image)
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'cyberrete_secure_deployment_title_html' ) ) {
	/**
	 * Wraps 1st, 4th and 5th words in gradient span.
	 *
	 * @param string $title Section title.
	 * @return string
	 */
	function cyberrete_secure_deployment_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$gradient_indexes = array( 0, 3); // 1st, 4th, 5th (0-based).
		$html_words       = array();

		foreach ( $words as $index => $word ) {
			if ( in_array( $index, $gradient_indexes, true ) ) {
				$html_words[] = '<span class="secure-deployment__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html_words[] = esc_html( $word );
			}
		}

		return implode( ' ', $html_words );
	}
}

$section = get_sub_field( 'secure_deployment_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title = isset( $section['secure_deployment_title'] ) ? $section['secure_deployment_title'] : '';
$items = isset( $section['secure_deployment_items'] ) && is_array( $section['secure_deployment_items'] ) ? $section['secure_deployment_items'] : array();
$valid_items = array();

foreach ( $items as $item ) {
	$item_title = isset( $item['item_title'] ) ? trim( (string) $item['item_title'] ) : '';
	$item_text  = isset( $item['item_text'] ) ? trim( wp_strip_all_tags( (string) $item['item_text'] ) ) : '';
	$item_image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_hover_image'] ) ? $item['item_hover_image'] : null ) : null;
	$item_bg    = ( $item_image && ! empty( $item_image['url'] ) ) ? $item_image['url'] : '';

	if ( '' === $item_title && '' === $item_text && '' === $item_bg ) {
		continue;
	}

	$valid_items[] = array(
		'item_title' => $item_title,
		'item_text'  => isset( $item['item_text'] ) ? $item['item_text'] : '',
		'item_bg'    => $item_bg,
	);
}

if ( ! $title && empty( $valid_items ) ) {
	return;
}
?>

<section class="secure-deployment">
	<div class="secure-deployment__container js-animate">
		<div class="secure-deployment__top">
			<?php if ( $title ) : ?>
				<h2 class="secure-deployment__title">
					<?php
					echo wp_kses(
						cyberrete_secure_deployment_title_html( $title ),
						array(
							'span' => array( 'class' => true ),
						)
					);
					?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $valid_items ) ) : ?>
				<div class="secure-deployment__nav secure-deployment__nav--desktop" aria-hidden="false">
					<button
						type="button"
						class="secure-deployment__nav-btn secure-deployment__nav-btn--prev js-secure-deployment-prev"
						aria-label="<?php esc_attr_e( 'Previous item', 'cyberrete' ); ?>"
					>
						<span class="secure-deployment__nav-visual" aria-hidden="true">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
								alt=""
								class="secure-deployment__nav-svg secure-deployment__nav-svg--active"
								width="32"
								height="32"
								decoding="async"
							>
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
								alt=""
								class="secure-deployment__nav-svg secure-deployment__nav-svg--block"
								width="32"
								height="32"
								decoding="async"
							>
						</span>
					</button>
					<button
						type="button"
						class="secure-deployment__nav-btn secure-deployment__nav-btn--next js-secure-deployment-next"
						aria-label="<?php esc_attr_e( 'Next item', 'cyberrete' ); ?>"
					>
						<span class="secure-deployment__nav-visual" aria-hidden="true">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
								alt=""
								class="secure-deployment__nav-svg secure-deployment__nav-svg--active"
								width="32"
								height="32"
								decoding="async"
							>
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
								alt=""
								class="secure-deployment__nav-svg secure-deployment__nav-svg--block"
								width="32"
								height="32"
								decoding="async"
							>
						</span>
					</button>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $valid_items ) ) : ?>
			<div class="secure-deployment__slider swiper js-secure-deployment-slider">
				<div class="secure-deployment__track swiper-wrapper">
					<?php foreach ( $valid_items as $item ) : ?>
						<?php
						$item_title      = isset( $item['item_title'] ) ? $item['item_title'] : '';
						$item_text       = isset( $item['item_text'] ) ? $item['item_text'] : '';
						$item_bg         = isset( $item['item_bg'] ) ? $item['item_bg'] : '';
						$card_classes    = 'secure-deployment__card' . ( $item_bg ? ' secure-deployment__card--has-hover-image' : '' );
						$card_style_attr = $item_bg ? '--secure-hover-image:url(\'' . esc_url( $item_bg ) . '\');' : '';
						?>
						<div class="secure-deployment__slide swiper-slide">
							<article class="<?php echo esc_attr( $card_classes ); ?>"<?php echo $card_style_attr ? ' style="' . esc_attr( $card_style_attr ) . '"' : ''; ?>>

								<?php if ( $item_title ) : ?>
									<h3 class="secure-deployment__card-title"><?php echo esc_html( $item_title ); ?></h3>
								<?php endif; ?>

								<?php if ( $item_text ) : ?>
									<div class="secure-deployment__card-text"><?php echo wp_kses_post( wpautop( $item_text ) ); ?></div>
								<?php endif; ?>
							</article>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="secure-deployment__pagination swiper-pagination"></div>
			</div>

			<div class="secure-deployment__nav secure-deployment__nav--mobile" aria-hidden="false">
				<button
					type="button"
					class="secure-deployment__nav-btn secure-deployment__nav-btn--prev js-secure-deployment-prev"
					aria-label="<?php esc_attr_e( 'Previous item', 'cyberrete' ); ?>"
				>
					<span class="secure-deployment__nav-visual" aria-hidden="true">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
							alt=""
							class="secure-deployment__nav-svg secure-deployment__nav-svg--active"
							width="32"
							height="32"
							decoding="async"
						>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
							alt=""
							class="secure-deployment__nav-svg secure-deployment__nav-svg--block"
							width="32"
							height="32"
							decoding="async"
						>
					</span>
				</button>
				<button
					type="button"
					class="secure-deployment__nav-btn secure-deployment__nav-btn--next js-secure-deployment-next"
					aria-label="<?php esc_attr_e( 'Next item', 'cyberrete' ); ?>"
				>
					<span class="secure-deployment__nav-visual" aria-hidden="true">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
							alt=""
							class="secure-deployment__nav-svg secure-deployment__nav-svg--active"
							width="32"
							height="32"
							decoding="async"
						>
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
							alt=""
							class="secure-deployment__nav-svg secure-deployment__nav-svg--block"
							width="32"
							height="32"
							decoding="async"
						>
					</span>
				</button>
			</div>
		<?php endif; ?>
	</div>
</section>
