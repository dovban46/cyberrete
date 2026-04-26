<?php
/**
 * Flexible layout: about_page_description
 *
 * ACF group: about_page_description_section
 *  - about_page_description_items (repeater)
 *      - item_text
 *      - item_image
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_description_section' );
if ( ! is_array( $section ) ) {
	return;
}

$items = isset( $section['about_page_description_items'] ) && is_array( $section['about_page_description_items'] ) ? $section['about_page_description_items'] : array();

if ( empty( $items ) ) {
	return;
}
?>

<section class="about-page-description">
	<div class="about-page-description__container js-animate">
		<div class="about-page-description__list">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$item_text       = isset( $item['item_text'] ) ? $item['item_text'] : '';
				$item_text_plain = trim( wp_strip_all_tags( (string) $item_text ) );
				$item_image      = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_image'] ) ? $item['item_image'] : null ) : null;
				$item_image_url  = ( $item_image && ! empty( $item_image['url'] ) ) ? $item_image['url'] : '';

				if ( '' === $item_text_plain && '' === $item_image_url ) {
					continue;
				}
				?>
				<article class="about-page-description__item js-about-page-description-item">
					<?php if ( '' !== $item_text_plain ) : ?>
						<div class="about-page-description__text">
							<?php echo wp_kses_post( wpautop( $item_text ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( '' !== $item_image_url ) : ?>
						<div class="about-page-description__media">
							<img
								src="<?php echo esc_url( $item_image_url ); ?>"
								alt=""
								class="about-page-description__image"
								loading="lazy"
								decoding="async"
							>
						</div>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
