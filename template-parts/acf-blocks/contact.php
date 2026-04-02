<?php
/**
 * Flexible layout: contact
 *
 * ACF: layout `contact`; група `contact_section` →
 * contact_title, contact_text, contact_form (шорткод CF7).
 *
 * @package cyberrete
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$contact_section = get_sub_field( 'contact_section' );

$title    = '';
$text     = '';
$form_raw = '';

if ( is_array( $contact_section ) ) {
	if ( ! empty( $contact_section['contact_title'] ) ) {
		$title = $contact_section['contact_title'];
	}
	if ( ! empty( $contact_section['contact_text'] ) ) {
		$text = $contact_section['contact_text'];
	}
	if ( ! empty( $contact_section['contact_form'] ) ) {
		$form_raw = $contact_section['contact_form'];
	}
}

if ( ! $title && ! $text && ! $form_raw ) {
	return;
}
?>

<section class="contact">
	<div class="contact__container js-animate">

		<div class="contact__layout">

			<div class="contact__col contact__col--content">
				<?php if ( $title ) : ?>
					<h2 class="contact__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( $text ) : ?>
					<div class="contact__text">
						<?php echo wp_kses_post( $text ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="contact__col contact__col--form">
				<?php if ( $form_raw ) : ?>
					<div class="contact__form-box">
						<div class="contact__form">
							<?php echo do_shortcode( $form_raw ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>

	</div>
</section>
