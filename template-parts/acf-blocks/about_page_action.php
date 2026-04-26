<?php
/**
 * Flexible layout: about_page_action
 *
 * ACF group: about_page_action_section
 *  - about_page_action_title
 *  - about_page_action_text
 *  - about_page_action_btn
 *  - about_page_action_image_bg
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_action_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title = isset( $section['about_page_action_title'] ) ? trim( (string) $section['about_page_action_title'] ) : '';
$text  = isset( $section['about_page_action_text'] ) ? $section['about_page_action_text'] : '';
$text_plain = trim( wp_strip_all_tags( (string) $text ) );

$bg_image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $section['about_page_action_image_bg'] ) ? $section['about_page_action_image_bg'] : null ) : null;
$bg_url   = ( $bg_image && ! empty( $bg_image['url'] ) ) ? $bg_image['url'] : '';

$button       = isset( $section['about_page_action_btn'] ) ? $section['about_page_action_btn'] : null;
$button_url   = '';
$button_title = '';
$button_target = '_self';

if ( is_array( $button ) ) {
	$button_url    = isset( $button['url'] ) ? trim( (string) $button['url'] ) : '';
	$button_title  = isset( $button['title'] ) ? trim( (string) $button['title'] ) : '';
	$button_target = ! empty( $button['target'] ) ? (string) $button['target'] : '_self';
}

if ( '' === $button_title && '' !== $button_url ) {
	$button_title = __( 'Learn More', 'cyberrete' );
}

if ( '' === $title && '' === $text_plain && '' === $button_url && '' === $bg_url ) {
	return;
}
?>

<section class="about-page-action"<?php echo $bg_url ? ' style="--about-action-bg-image:url(\'' . esc_url( $bg_url ) . '\')"' : ''; ?>>
	<div class="about-page-action__overlay" aria-hidden="true"></div>

	<div class="about-page-action__container js-animate">
		<?php if ( '' !== $title ) : ?>
			<h2 class="about-page-action__title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( '' !== $text_plain ) : ?>
			<div class="about-page-action__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
		<?php endif; ?>

		<?php if ( '' !== $button_url && '' !== $button_title ) : ?>
			<a
				class="about-page-action__btn"
				href="<?php echo esc_url( $button_url ); ?>"
				target="<?php echo esc_attr( $button_target ); ?>"
			>
				<?php echo esc_html( $button_title ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
