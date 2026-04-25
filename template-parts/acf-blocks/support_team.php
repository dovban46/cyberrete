<?php
/**
 * Flexible layout: support_team
 *
 * ACF group: support_team_section
 *  - support_team_title
 *  - support_team_items (repeater)
 *      - item_title
 *      - item_text
 *      - item_image
 *      - item_hover_image
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'support_team_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title = isset( $section['support_team_title'] ) ? $section['support_team_title'] : '';
$items = isset( $section['support_team_items'] ) && is_array( $section['support_team_items'] ) ? $section['support_team_items'] : array();

if ( ! $title && empty( $items ) ) {
	return;
}
?>

<section class="support-team">
	<div class="support-team__container js-animate">
		<?php if ( $title ) : ?>
			<h2 class="support-team__title"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="support-team__grid">
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					$item_title      = isset( $item['item_title'] ) ? trim( (string) $item['item_title'] ) : '';
					$item_text       = isset( $item['item_text'] ) ? trim( wp_strip_all_tags( (string) $item['item_text'] ) ) : '';
					$item_text_raw   = isset( $item['item_text'] ) ? $item['item_text'] : '';
					$item_image_data = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_image'] ) ? $item['item_image'] : null ) : null;
					$hover_image_data = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $item['item_hover_image'] ) ? $item['item_hover_image'] : null ) : null;

					$item_image_url = ( $item_image_data && ! empty( $item_image_data['url'] ) ) ? $item_image_data['url'] : '';
					$hover_image_url = ( $hover_image_data && ! empty( $hover_image_data['url'] ) ) ? $hover_image_data['url'] : '';

					$has_title_text = ( '' !== $item_title ) || ( '' !== $item_text );
					$has_any_image  = ( '' !== $item_image_url ) || ( '' !== $hover_image_url );
					$full_image_url = '' !== $item_image_url ? $item_image_url : $hover_image_url;
					$show_only_image = $has_any_image && ! $has_title_text;
					$show_inline_image = $has_title_text && '' !== $item_image_url;

					$card_classes = 'support-team__card js-support-team-card';
					if ( $show_only_image ) {
						$card_classes .= ' support-team__card--image-only';
					}
					if ( ! $show_inline_image && $has_title_text ) {
						$card_classes .= ' support-team__card--text-only';
					}
					if ( '' !== $hover_image_url ) {
						$card_classes .= ' support-team__card--has-hover-image';
					}

					$style_parts = array();
					if ( '' !== $hover_image_url ) {
						$style_parts[] = '--support-hover-image:url(\'' . esc_url( $hover_image_url ) . '\')';
					}
					if ( $show_only_image && '' !== $full_image_url ) {
						$style_parts[] = '--support-full-image:url(\'' . esc_url( $full_image_url ) . '\')';
					}
					$style_attr = ! empty( $style_parts ) ? implode( ';', $style_parts ) : '';
					?>
					<article class="<?php echo esc_attr( $card_classes ); ?>"<?php echo $style_attr ? ' style="' . esc_attr( $style_attr ) . '"' : ''; ?>>
						<?php if ( $show_only_image && '' !== $full_image_url ) : ?>
							<div class="support-team__full-image" aria-hidden="true"></div>
						<?php else : ?>
							<?php if ( '' !== $item_title ) : ?>
								<h3 class="support-team__card-title"><?php echo esc_html( $item_title ); ?></h3>
							<?php endif; ?>

							<?php if ( $show_inline_image ) : ?>
								<div class="support-team__image-wrap" aria-hidden="true">
									<div class="support-team__image-overlay"></div>
									<img src="<?php echo esc_url( $item_image_url ); ?>" alt="" class="support-team__image" loading="lazy" decoding="async">
								</div>
							<?php endif; ?>

							<?php if ( '' !== $item_text ) : ?>
								<div class="support-team__card-text"><?php echo wp_kses_post( wpautop( $item_text_raw ) ); ?></div>
							<?php endif; ?>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
