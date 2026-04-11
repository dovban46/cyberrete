<?php
/**
 * Flexible layout: page_hero_metrics
 *
 * ACF: група `page_hero_metrics_section`
 *   - hero_image_bg (image) — фон секції, шар `page-hero-metrics__bg`
 *   - hero_title (text / WYSIWYG — HTML через wp_kses_post)
 *   - hero_text (textarea / WYSIWYG — HTML, без wpautop)
 *   - hero_stats (repeater)
 *       - stat_prefix (text)
 *       - stat_number (text)
 *       - stat_suffix (text)
 *       - stat_text (textarea / WYSIWYG — HTML, без wpautop)
 *
 * Число в репітері: клас `js-counter` + `data-target` / `data-format="comma"` (лічильник у main.js).
 * BEM-блок: page-hero-metrics — стилі `_page-hero-metrics.scss`.
 *
 * @package Cyberrete
 */
?>
<section class="page-hero-metrics">
	<?php if ( have_rows( 'page_hero_metrics_section' ) ) : ?>
		<?php
		$row_num = 0;
		while ( have_rows( 'page_hero_metrics_section' ) ) :
			the_row();
			$row_num++;

			if ( 1 === $row_num ) {
				$hero_bg_img = function_exists( 'cyberrete_acf_resolved_image' )
					? cyberrete_acf_resolved_image( get_sub_field( 'hero_image_bg' ) )
					: null;
				$hero_bg_url = ( $hero_bg_img && ! empty( $hero_bg_img['url'] ) ) ? $hero_bg_img['url'] : '';

				if ( $hero_bg_url ) {
					?>
					<div class="page-hero-metrics__bg" style="background-image: url('<?php echo esc_url( $hero_bg_url ); ?>');" aria-hidden="true"></div>
					<?php
				}

				?>
				<div class="page-hero-metrics__container js-animate">
				<?php
			}

			$title     = get_sub_field( 'hero_title' );
			$text      = get_sub_field( 'hero_text' );
			$has_intro = (bool) ( $title || $text );
			?>

			<div class="page-hero-metrics__inner">
				<?php if ( $has_intro ) : ?>
					<div class="page-hero-metrics__intro">
						<?php if ( $title ) : ?>
							<h1 class="page-hero-metrics__title"><?php echo wp_kses_post( $title ); ?></h1>
						<?php endif; ?>

						<?php if ( $text ) : ?>
							<div class="page-hero-metrics__text">
								<?php echo wp_kses_post( $text ); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( have_rows( 'hero_stats' ) ) : ?>
					<?php if ( $has_intro ) : ?>
						<div class="page-hero-metrics__divider" aria-hidden="true"></div>
					<?php endif; ?>

					<div class="page-hero-metrics__stats" role="list">
						<?php
						while ( have_rows( 'hero_stats' ) ) :
							the_row();

							$stat_prefix = get_sub_field( 'stat_prefix' );
							$stat_number = get_sub_field( 'stat_number' );
							$stat_suffix = get_sub_field( 'stat_suffix' );
							$stat_text   = get_sub_field( 'stat_text' );

							if ( ! $stat_prefix && ! $stat_number && ! $stat_suffix && ! $stat_text ) {
								continue;
							}
							?>
							<div class="page-hero-metrics__stat" role="listitem">
								<?php if ( $stat_prefix || $stat_number || $stat_suffix ) : ?>
									<p class="page-hero-metrics__stat-value">
										<?php if ( $stat_prefix ) : ?>
											<span class="page-hero-metrics__stat-prefix"><?php echo esc_html( $stat_prefix ); ?></span>
										<?php endif; ?>
										<?php if ( $stat_number ) : ?>
											<?php
											$stat_number_str = (string) $stat_number;
											// Лише цифри → ціле для лічильника (2,137 / 2.137 → 2137, без десяткового округлення в JS).
											$normalized_num = preg_replace( '/[^\d]/', '', $stat_number_str );
											$can_animate    = strlen( $normalized_num ) > 0;
											$number_classes  = 'page-hero-metrics__stat-number' . ( $can_animate ? ' js-counter' : '' );
											?>
											<span
												class="<?php echo esc_attr( $number_classes ); ?>"
												<?php if ( $can_animate ) : ?>
													data-target="<?php echo esc_attr( $normalized_num ); ?>"
													data-format="comma"
												<?php endif; ?>
											><?php echo $can_animate ? '0' : esc_html( $stat_number_str ); ?></span>
										<?php endif; ?>
										<?php if ( $stat_suffix ) : ?>
											<span class="page-hero-metrics__stat-suffix"><?php echo esc_html( $stat_suffix ); ?></span>
										<?php endif; ?>
									</p>
								<?php endif; ?>

								<?php if ( $stat_text ) : ?>
									<div class="page-hero-metrics__stat-text">
										<?php echo wp_kses_post( $stat_text ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php
		endwhile;

		if ( $row_num > 0 ) {
			?>
			</div>
			<?php
		}
		?>
	<?php endif; ?>

</section>
