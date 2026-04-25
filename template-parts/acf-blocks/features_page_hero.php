<?php
/**
 * Flexible layout: features_page_hero
 *
 * ACF group: features_page_hero_section
 *  - features_page_hero_title
 *  - features_page_hero_text
 *  - features_page_hero_btn
 *  - features_page_hero_bg_image
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'features_page_hero_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title = isset( $section['features_page_hero_title'] ) ? $section['features_page_hero_title'] : '';
$text  = isset( $section['features_page_hero_text'] ) ? $section['features_page_hero_text'] : '';
$btn   = isset( $section['features_page_hero_btn'] ) ? $section['features_page_hero_btn'] : null;
$bg    = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $section['features_page_hero_bg_image'] ) ? $section['features_page_hero_bg_image'] : null ) : null;
$bg_url = ( $bg && ! empty( $bg['url'] ) ) ? $bg['url'] : '';

if ( ! $title && ! $text && empty( $btn ) && ! $bg_url ) {
	return;
}
?>

<section class="features-page-hero">
	<?php if ( $bg_url ) : ?>
		<div class="features-page-hero__bg" style="background-image: url('<?php echo esc_url( $bg_url ); ?>');" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="features-page-hero__container js-animate">
		<div class="features-page-hero__content">
			<?php if ( $title ) : ?>
				<h1 class="features-page-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="features-page-hero__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
			<?php endif; ?>

			<?php if ( is_array( $btn ) && ! empty( $btn['url'] ) ) : ?>
				<?php
				$btn_title  = ! empty( $btn['title'] ) ? $btn['title'] : __( 'Learn more', 'cyberrete' );
				$btn_target = ! empty( $btn['target'] ) ? $btn['target'] : '_self';
				?>
				<a
					href="<?php echo esc_url( $btn['url'] ); ?>"
					class="features-page-hero__btn"
					target="<?php echo esc_attr( $btn_target ); ?>"
					<?php echo '_blank' === $btn_target ? ' rel="noopener noreferrer"' : ''; ?>
				>
					<?php echo esc_html( $btn_title ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
