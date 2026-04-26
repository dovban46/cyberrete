<?php
/**
 * Flexible layout: about_page_supported
 *
 * ACF group: about_page_supported_section
 *  - about_page_supported_backed (text)
 *  - about_page_supported_backed_items (repeater)
 *      - item_backed_image (image)
 *  - about_page_supported_members (text)
 *  - about_page_supported_members_items (repeater)
 *      - item_member_image (image)
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_supported_section' );
if ( ! is_array( $section ) ) {
	return;
}

$backed_title = isset( $section['about_page_supported_backed'] ) ? trim( (string) $section['about_page_supported_backed'] ) : '';
$member_title = isset( $section['about_page_supported_members'] ) ? trim( (string) $section['about_page_supported_members'] ) : '';

$backed_items = isset( $section['about_page_supported_backed_items'] ) && is_array( $section['about_page_supported_backed_items'] ) ? $section['about_page_supported_backed_items'] : array();
$member_items = isset( $section['about_page_supported_members_items'] ) && is_array( $section['about_page_supported_members_items'] ) ? $section['about_page_supported_members_items'] : array();

if ( '' === $backed_title && '' === $member_title && empty( $backed_items ) && empty( $member_items ) ) {
	return;
}
?>

<section class="about-page-supported">
	<div class="about-page-supported__container js-animate">
		<div class="about-page-supported__grid">
			<div class="about-page-supported__group about-page-supported__group--backed">
				<?php if ( '' !== $backed_title ) : ?>
					<p class="about-page-supported__title"><?php echo esc_html( $backed_title ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $backed_items ) ) : ?>
					<div class="about-page-supported__logos">
						<?php foreach ( $backed_items as $item ) : ?>
							<?php
							$image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_backed_image'] ) ? $item['item_backed_image'] : null ) : null;
							if ( ! $image || empty( $image['url'] ) ) {
								continue;
							}
							?>
							<div class="about-page-supported__logo-item">
								<img
									src="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( isset( $image['alt'] ) ? $image['alt'] : '' ); ?>"
									class="about-page-supported__logo"
									loading="lazy"
									decoding="async"
								>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="about-page-supported__group about-page-supported__group--members">
				<?php if ( '' !== $member_title ) : ?>
					<p class="about-page-supported__title"><?php echo esc_html( $member_title ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $member_items ) ) : ?>
					<div class="about-page-supported__logos">
						<?php foreach ( $member_items as $item ) : ?>
							<?php
							$image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_member_image'] ) ? $item['item_member_image'] : null ) : null;
							if ( ! $image || empty( $image['url'] ) ) {
								continue;
							}
							?>
							<div class="about-page-supported__logo-item">
								<img
									src="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( isset( $image['alt'] ) ? $image['alt'] : '' ); ?>"
									class="about-page-supported__logo"
									loading="lazy"
									decoding="async"
								>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
