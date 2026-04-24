<?php
/**
 * Flexible layout: how_it_works
 *
 * ACF: how_it_works_section
 *  - how_it_works_text
 *  - how_it_works_title
 *  - how_it_works_items (repeater)
 *      - item_title
 *      - item_text
 *      - items (repeater)
 *          - title
 *          - text
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'cyberrete_how_it_works_title_html' ) ) {
	/**
	 * Wrap only first word in gradient span.
	 *
	 * @param string $title Section title.
	 * @return string
	 */
	function cyberrete_how_it_works_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$html_words = array();
		foreach ( $words as $index => $word ) {
			if ( 0 === $index ) {
				$html_words[] = '<span class="how-it-works__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html_words[] = esc_html( $word );
			}
		}

		return implode( ' ', $html_words );
	}
}

$section = get_sub_field( 'how_it_works_section' );
if ( ! is_array( $section ) ) {
	return;
}

$lead_text = isset( $section['how_it_works_text'] ) ? $section['how_it_works_text'] : '';
$title     = isset( $section['how_it_works_title'] ) ? $section['how_it_works_title'] : '';
$items     = isset( $section['how_it_works_items'] ) && is_array( $section['how_it_works_items'] ) ? $section['how_it_works_items'] : array();

if ( ! $lead_text && ! $title && empty( $items ) ) {
	return;
}
?>

<section class="how-it-works">
	<div class="how-it-works__container js-animate">
		<?php if ( $lead_text ) : ?>
			<div class="how-it-works__text">
				<?php echo wp_kses_post( wpautop( $lead_text ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $title ) : ?>
			<h2 class="how-it-works__title">
				<?php
				echo wp_kses(
					cyberrete_how_it_works_title_html( $title ),
					array(
						'span' => array( 'class' => true ),
					)
				);
				?>
			</h2>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="how-it-works__content js-how-it-works">
				<div class="how-it-works__panels">
					<?php foreach ( $items as $item_index => $item ) : ?>
						<?php
						$item_title = isset( $item['item_title'] ) ? $item['item_title'] : '';
						$item_text  = isset( $item['item_text'] ) ? $item['item_text'] : '';
						$sub_items  = isset( $item['items'] ) && is_array( $item['items'] ) ? $item['items'] : array();
						$is_active  = 0 === $item_index;
						$panel_id   = 'how-it-works-panel-' . ( $item_index + 1 );
						?>
						<div
							id="<?php echo esc_attr( $panel_id ); ?>"
							class="how-it-works__panel<?php echo $is_active ? ' is-active' : ''; ?>"
							role="tabpanel"
							<?php echo $is_active ? '' : ' hidden'; ?>
						>
							<div class="how-it-works__orbit js-how-it-works-orbit">
								<div class="how-it-works__ring" aria-hidden="true"></div>

								<div class="how-it-works__center">
									<?php if ( $item_title ) : ?>
										<h3 class="how-it-works__center-title"><?php echo esc_html( $item_title ); ?></h3>
									<?php endif; ?>

									<?php if ( $item_text ) : ?>
										<div class="how-it-works__center-text">
											<?php echo wp_kses_post( wpautop( $item_text ) ); ?>
										</div>
									<?php endif; ?>
								</div>

								<div class="how-it-works__points">
									<?php foreach ( $sub_items as $sub_index => $sub_item ) : ?>
										<?php
										$sub_title = isset( $sub_item['title'] ) ? $sub_item['title'] : '';
										$sub_text  = isset( $sub_item['text'] ) ? $sub_item['text'] : '';

										if ( ! $sub_title && ! $sub_text ) {
											continue;
										}
										?>
										<article class="how-it-works__point js-how-it-works-point" data-point-index="<?php echo esc_attr( $sub_index ); ?>">
											<span class="how-it-works__point-dot" aria-hidden="true"></span>
											<div class="how-it-works__point-content">
												<?php if ( $sub_title ) : ?>
													<h4 class="how-it-works__point-title"><?php echo esc_html( $sub_title ); ?></h4>
												<?php endif; ?>
												<?php if ( $sub_text ) : ?>
													<div class="how-it-works__point-text"><?php echo wp_kses_post( wpautop( $sub_text ) ); ?></div>
												<?php endif; ?>
											</div>
										</article>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="how-it-works__tabs" role="tablist" aria-label="<?php esc_attr_e( 'How it works tabs', 'cyberrete' ); ?>">
					<?php foreach ( $items as $item_index => $item ) : ?>
						<?php
						$item_title = isset( $item['item_title'] ) ? $item['item_title'] : '';
						if ( ! $item_title ) {
							$item_title = sprintf( __( 'Tab %d', 'cyberrete' ), ( $item_index + 1 ) );
						}
						$is_active = 0 === $item_index;
						$panel_id  = 'how-it-works-panel-' . ( $item_index + 1 );
						?>
						<button
							type="button"
							class="how-it-works__tab<?php echo $is_active ? ' is-active' : ''; ?>"
							role="tab"
							aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
							data-panel-id="<?php echo esc_attr( $panel_id ); ?>"
						>
							<?php echo esc_html( $item_title ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
