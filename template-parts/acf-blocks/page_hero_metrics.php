<?php
/**
 * Flexible layout: page_hero_metrics
 *
 * ACF: група `page_hero_metrics_section`
 *   - hero_image_bg (image) — фон секції; також poster/fallback поки завантажується `hero_video_bg`
 *   - hero_video_bg (file / URL) — відеофон у шарі `page-hero-metrics__bg`
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

$queried_id            = (int) get_queried_object_id();
$queried_slug          = $queried_id ? (string) get_post_field( 'post_name', $queried_id ) : '';
$is_technology_context = is_page( 'technology' ) || is_page_template( 'page-technology.php' ) || ( '' !== $queried_slug && false !== strpos( $queried_slug, 'technology' ) );
$hero_modifier_class   = $is_technology_context ? ' page-hero-metrics--technology' : '';
?>
<section class="page-hero-metrics<?php echo esc_attr( $hero_modifier_class ); ?>">
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
				$hero_bg_video = get_sub_field( 'hero_video_bg' );
				$hero_video_url = '';
				$hero_video_type = '';

				if ( is_array( $hero_bg_video ) ) {
					if ( ! empty( $hero_bg_video['url'] ) ) {
						$hero_video_url = (string) $hero_bg_video['url'];
					}
					if ( ! empty( $hero_bg_video['mime_type'] ) ) {
						$hero_video_type = (string) $hero_bg_video['mime_type'];
					}
				} elseif ( is_numeric( $hero_bg_video ) ) {
					$hero_video_url  = (string) wp_get_attachment_url( (int) $hero_bg_video );
					$hero_video_type = (string) get_post_mime_type( (int) $hero_bg_video );
				} elseif ( is_string( $hero_bg_video ) && '' !== trim( $hero_bg_video ) ) {
					$hero_video_url = trim( $hero_bg_video );
				}

				if ( $hero_video_url || $hero_bg_url ) {
					?>
					<div
						class="page-hero-metrics__bg"
						<?php if ( $hero_bg_url ) : ?>
							style="background-image: url('<?php echo esc_url( $hero_bg_url ); ?>');"
						<?php endif; ?>
						aria-hidden="true"
					>
						<?php if ( $hero_video_url ) : ?>
							<video
								class="page-hero-metrics__bg-video"
								autoplay
								muted
								loop
								playsinline
								preload="metadata"
								<?php if ( $hero_bg_url ) : ?>
									poster="<?php echo esc_url( $hero_bg_url ); ?>"
								<?php endif; ?>
							>
								<source
									src="<?php echo esc_url( $hero_video_url ); ?>"
									<?php if ( $hero_video_type ) : ?>
										type="<?php echo esc_attr( $hero_video_type ); ?>"
									<?php endif; ?>
								>
							</video>
						<?php endif; ?>
					</div>
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
