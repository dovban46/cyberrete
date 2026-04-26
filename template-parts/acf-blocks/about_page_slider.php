<?php
/**
 * Flexible layout: about_page_slider
 *
 * ACF group: about_page_slider_section
 *  - about_page_slider_items (repeater)
 *      - item_image (image)
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_slider_section' );
if ( ! is_array( $section ) ) {
	return;
}

$items = isset( $section['about_page_slider_items'] ) && is_array( $section['about_page_slider_items'] ) ? $section['about_page_slider_items'] : array();
if ( empty( $items ) ) {
	return;
}
?>

<section class="about-page-slider">
	<div class="about-page-slider__container js-animate">
		<div class="about-page-slider__wrapper swiper js-logo-slider">
			<div class="about-page-slider__track swiper-wrapper">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_image'] ) ? $item['item_image'] : null ) : null;
					if ( ! $image || empty( $image['url'] ) ) {
						continue;
					}
					?>
					<div class="about-page-slider__slide swiper-slide">
						<div class="about-page-slider__item">
							<img
								src="<?php echo esc_url( $image['url'] ); ?>"
								alt="<?php echo esc_attr( isset( $image['alt'] ) ? $image['alt'] : '' ); ?>"
								class="about-page-slider__image"
								loading="lazy"
								decoding="async"
							>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
