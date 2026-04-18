<?php
/**
 * Flexible layout: workflow_comparison
 *
 * ACF: workflow_comparison_section
 *   - workflow_comparison_title (text)
 *   - workflow_comparison_text (textarea / WYSIWYG) — інтро під заголовком; на всіх ширинах
 *   - workflow_comparison_groups (repeater)
 *       - group_heading (text)
 *       - group_text (textarea / WYSIWYG) — під заголовком картки
 *       - group_points (repeater)
 *           - point_text (text)
 *   - workflow_comparison_button (link) — CTA у шапці («Talk To An Expert»)
 *   - workflow_comparison_image (image) — фон блоку з картками
 *
 * (Застаріле: workflow_comparison_mobile_text — fallback; workflow_comparison_footer — не виводиться.)
 *
 * BEM: workflow-comparison
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'cyberrete_workflow_comparison_title_html' ) ) {
	/**
	 * Кожне 3-тє слово обгортається в span з градієнтом (стилі в SCSS).
	 *
	 * @param string $title Заголовок.
	 * @return string HTML (лише span + текст).
	 */
	function cyberrete_workflow_comparison_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$html = array();
		foreach ( $words as $i => $word ) {
			if ( ( $i + 1 ) % 3 === 0 ) {
				$html[] = '<span class="workflow-comparison__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html[] = esc_html( $word );
			}
		}

		return implode( ' ', $html );
	}
}

$workflow_comparison_check_url = get_template_directory_uri() . '/assets/images/Check.svg';
?>
<section class="workflow-comparison">
	<div class="workflow-comparison__container js-workflow-comparison-section">

		<?php if ( have_rows( 'workflow_comparison_section' ) ) : ?>
			<?php
			while ( have_rows( 'workflow_comparison_section' ) ) :
				the_row();

				$title = get_sub_field( 'workflow_comparison_title' );
				$intro = get_sub_field( 'workflow_comparison_text' );
				if ( $intro === null || $intro === '' ) {
					$intro = get_sub_field( 'workflow_comparison_mobile_text' );
				}
				$button = get_sub_field( 'workflow_comparison_button' );
				$image  = get_sub_field( 'workflow_comparison_image' );

				$stage_bg = '';
				if ( $image && ! empty( $image['url'] ) ) {
					$stage_bg = 'background-image: url(' . esc_url( $image['url'] ) . ');';
				}
				?>

				<?php if ( $title || $intro || ( $button && ! empty( $button['url'] ) ) ) : ?>
					<div class="workflow-comparison__top">
						<?php if ( $title ) : ?>
							<h2 class="workflow-comparison__title js-stagger-item">
								<?php
								echo wp_kses(
									cyberrete_workflow_comparison_title_html( $title ),
									array(
										'span' => array( 'class' => true ),
									)
								);
								?>
							</h2>
						<?php endif; ?>

						<?php if ( $intro ) : ?>
							<div class="workflow-comparison__intro js-stagger-item">
								<?php echo wp_kses_post( wpautop( $intro ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $button && ! empty( $button['url'] ) ) : ?>
							<?php
							$btn_url    = $button['url'];
							$btn_title  = ! empty( $button['title'] ) ? $button['title'] : __( 'Talk To An Expert', 'cyberrete' );
							$btn_target = ! empty( $button['target'] ) ? $button['target'] : '_self';
							?>
							<div class="workflow-comparison__cta-wrap js-stagger-item">
								<a
									href="<?php echo esc_url( $btn_url ); ?>"
									class="workflow-comparison__cta"
									target="<?php echo esc_attr( $btn_target ); ?>"
									<?php echo '_blank' === $btn_target ? ' rel="noopener noreferrer"' : ''; ?>
								>
									<?php echo esc_html( $btn_title ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( have_rows( 'workflow_comparison_groups' ) ) : ?>
					<div
						class="workflow-comparison__stage js-stagger-item"
						<?php echo $stage_bg ? ' style="' . esc_attr( $stage_bg ) . '"' : ''; ?>
					>
						<div class="workflow-comparison__cards">
							<?php
							$card_index = 0;
							while ( have_rows( 'workflow_comparison_groups' ) ) :
								the_row();
								$card_index++;

								$group_heading = get_sub_field( 'group_heading' );
								$group_text    = get_sub_field( 'group_text' );
								$offset_class  = ( 2 === $card_index ) ? ' workflow-comparison__card--offset' : '';
								?>
								<article class="workflow-comparison__card<?php echo esc_attr( $offset_class ); ?>">
									<?php if ( $group_heading ) : ?>
										<h3 class="workflow-comparison__group-heading"><?php echo esc_html( $group_heading ); ?></h3>
									<?php endif; ?>

									<?php if ( $group_text ) : ?>
										<div class="workflow-comparison__group-text">
											<?php echo wp_kses_post( wpautop( $group_text ) ); ?>
										</div>
									<?php endif; ?>

									<?php if ( have_rows( 'group_points' ) ) : ?>
										<ul class="workflow-comparison__points" role="list">
											<?php
											while ( have_rows( 'group_points' ) ) :
												the_row();
												$point_text = get_sub_field( 'point_text' );
												if ( ! $point_text ) {
													continue;
												}
												?>
												<li class="workflow-comparison__point">
													<span class="workflow-comparison__point-icon-wrap" aria-hidden="true">
														<img
															src="<?php echo esc_url( $workflow_comparison_check_url ); ?>"
															alt=""
															class="workflow-comparison__point-icon"
															width="10"
															height="10"
															loading="lazy"
															decoding="async"
														>
													</span>
													<span class="workflow-comparison__point-text"><?php echo esc_html( $point_text ); ?></span>
												</li>
											<?php endwhile; ?>
										</ul>
									<?php endif; ?>

									<a href="#" class="workflow-comparison__card-more"><?php esc_html_e( 'Learn more', 'cyberrete' ); ?></a>
								</article>
							<?php endwhile; ?>
						</div>
					</div>
				<?php endif; ?>

			<?php endwhile; ?>
		<?php endif; ?>

	</div>
</section>
