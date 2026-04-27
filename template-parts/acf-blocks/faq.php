<?php
/**
 * Flexible layout: faq
 *
 * ACF group: faq_section
 *  - faq_title
 *  - faq_chapter (repeater)
 *      - chapter_title
 *      - chapter_images
 *      - chapter_items (repeater)
 *          - item_question
 *          - item_answer
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'faq_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title    = isset( $section['faq_title'] ) ? trim( (string) $section['faq_title'] ) : '';
$chapters = isset( $section['faq_chapter'] ) && is_array( $section['faq_chapter'] ) ? $section['faq_chapter'] : array();

if ( '' === $title && empty( $chapters ) ) {
	return;
}
?>

<section class="faq">
	<div class="faq__container js-animate" itemscope itemtype="https://schema.org/FAQPage">
		<?php if ( '' !== $title ) : ?>
			<h2 class="faq__title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $chapters ) ) : ?>
			<div class="faq__tabs" role="tablist" aria-label="<?php esc_attr_e( 'FAQ chapters', 'cyberrete' ); ?>">
				<?php foreach ( $chapters as $chapter_index => $chapter ) : ?>
					<?php
					$chapter_title = isset( $chapter['chapter_title'] ) ? trim( (string) $chapter['chapter_title'] ) : '';
					if ( '' === $chapter_title ) {
						$chapter_title = sprintf( __( 'Chapter %d', 'cyberrete' ), $chapter_index + 1 );
					}
					$is_active = 0 === $chapter_index;
					?>
					<button
						type="button"
						role="tab"
						class="faq__tab<?php echo $is_active ? ' is-active' : ''; ?>"
						id="faq-tab-<?php echo esc_attr( $chapter_index ); ?>"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="faq-panel-<?php echo esc_attr( $chapter_index ); ?>"
						data-faq-tab-index="<?php echo esc_attr( $chapter_index ); ?>"
					>
						<?php echo esc_html( $chapter_title ); ?>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="faq__panels">
				<?php foreach ( $chapters as $chapter_index => $chapter ) : ?>
					<?php
					$chapter_image   = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $chapter['chapter_images'] ) ? $chapter['chapter_images'] : null ) : null;
					$chapter_img_url = ( $chapter_image && ! empty( $chapter_image['url'] ) ) ? $chapter_image['url'] : '';
					$chapter_img_alt = ( $chapter_image && isset( $chapter_image['alt'] ) ) ? $chapter_image['alt'] : '';
					$chapter_items   = isset( $chapter['chapter_items'] ) && is_array( $chapter['chapter_items'] ) ? $chapter['chapter_items'] : array();
					$is_active_panel = 0 === $chapter_index;
					?>
					<div
						class="faq__panel<?php echo $is_active_panel ? ' is-active' : ''; ?>"
						id="faq-panel-<?php echo esc_attr( $chapter_index ); ?>"
						role="tabpanel"
						aria-labelledby="faq-tab-<?php echo esc_attr( $chapter_index ); ?>"
						data-faq-panel-index="<?php echo esc_attr( $chapter_index ); ?>"
						<?php echo $is_active_panel ? '' : ' hidden'; ?>
					>
						<div class="faq__questions">
							<?php foreach ( $chapter_items as $item_index => $item ) : ?>
								<?php
								$question = isset( $item['item_question'] ) ? trim( (string) $item['item_question'] ) : '';
								$answer   = isset( $item['item_answer'] ) ? $item['item_answer'] : '';
								$answer_plain = trim( wp_strip_all_tags( (string) $answer ) );
								if ( '' === $question && '' === $answer_plain ) {
									continue;
								}
								$item_id = $chapter_index . '-' . $item_index;
								?>
								<article class="faq__item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
									<button
										type="button"
										class="faq__question"
										aria-expanded="false"
										aria-controls="faq-answer-<?php echo esc_attr( $item_id ); ?>"
										id="faq-question-<?php echo esc_attr( $item_id ); ?>"
									>
										<span class="faq__question-text" itemprop="name"><?php echo esc_html( $question ); ?></span>
										<span class="faq__plus" aria-hidden="true"></span>
									</button>

									<div
										class="faq__answer-wrap"
										id="faq-answer-<?php echo esc_attr( $item_id ); ?>"
										role="region"
										aria-labelledby="faq-question-<?php echo esc_attr( $item_id ); ?>"
										hidden
									>
										<div class="faq__answer" itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
											<div itemprop="text"><?php echo wp_kses_post( wpautop( $answer ) ); ?></div>
										</div>
									</div>
								</article>
							<?php endforeach; ?>
						</div>

						<?php if ( '' !== $chapter_img_url ) : ?>
							<div class="faq__media">
								<div class="faq__media-overlay" aria-hidden="true"></div>
								<img
									src="<?php echo esc_url( $chapter_img_url ); ?>"
									alt="<?php echo esc_attr( $chapter_img_alt ); ?>"
									class="faq__image"
									loading="lazy"
									decoding="async"
								>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
