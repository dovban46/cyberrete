<?php
/**
 * Flexible layout: about_page_missions
 *
 * ACF group: about_page_missions_section
 *  - about_page_missions_items (repeater)
 *      - about_page_missions_title
 *      - about_page_missions_text
 *      - about_page_missions_image_bg
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_missions_section' );
if ( ! is_array( $section ) ) {
	return;
}

$items = isset( $section['about_page_missions_items'] ) && is_array( $section['about_page_missions_items'] ) ? $section['about_page_missions_items'] : array();
if ( empty( $items ) ) {
	return;
}
?>

<section class="about-page-missions">
	<div class="about-page-missions__container js-animate">
		<div class="about-page-missions__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$title     = isset( $item['about_page_missions_title'] ) ? trim( (string) $item['about_page_missions_title'] ) : '';
				$text      = isset( $item['about_page_missions_text'] ) ? $item['about_page_missions_text'] : '';
				$text_plain = trim( wp_strip_all_tags( (string) $text ) );
				$image     = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['about_page_missions_image_bg'] ) ? $item['about_page_missions_image_bg'] : null ) : null;
				$image_url = ( $image && ! empty( $image['url'] ) ) ? $image['url'] : '';

				if ( '' === $title && '' === $text_plain && '' === $image_url ) {
					continue;
				}
				?>
				<article class="about-page-missions__item"<?php echo $image_url ? ' style="--mission-bg-image:url(\'' . esc_url( $image_url ) . '\')"' : ''; ?>>
					<div class="about-page-missions__overlay" aria-hidden="true"></div>
					<div class="about-page-missions__content">
						<?php if ( '' !== $title ) : ?>
							<h3 class="about-page-missions__title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>

						<?php if ( '' !== $text_plain ) : ?>
							<div class="about-page-missions__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
