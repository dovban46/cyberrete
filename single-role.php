<?php
/**
 * Template for single role post type.
 *
 * @package Cyberrete
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();

			$post_id         = get_the_ID();
			$location        = trim( (string) get_field( 'location', $post_id ) );
			$employment_type = trim( (string) get_field( 'employment_type', $post_id ) );
			$department      = trim( (string) get_field( 'department', $post_id ) );

			$related_query = new WP_Query(
				array(
					'post_type'      => 'role',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'post__not_in'   => array( $post_id ),
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
			?>

			<article class="press-single press-single--role">
				<div class="press-single__container">
					<header class="press-single__header">
						<h1 class="press-single__title"><?php the_title(); ?></h1>
					</header>

					<div class="press-single__layout">
						<div class="press-single__main">
							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="press-single__figure">
									<?php
									the_post_thumbnail(
										'large',
										array(
											'class'   => 'press-single__image',
											'loading' => 'eager',
											'alt'     => the_title_attribute( array( 'echo' => false ) ),
										)
									);
									?>
								</figure>
							<?php endif; ?>

							<div class="press-single__content">
								<?php the_content(); ?>
							</div>
						</div>

						<aside class="press-single__sidebar">
							<div class="press-single__meta-card press-single__meta-card--role">
								<?php if ( '' !== $location ) : ?>
									<div class="press-single__meta-row">
										<span class="press-single__meta-label"><?php esc_html_e( 'Location', 'cyberrete' ); ?></span>
										<span class="press-single__meta-value"><?php echo esc_html( $location ); ?></span>
									</div>
								<?php endif; ?>

								<?php if ( '' !== $employment_type ) : ?>
									<div class="press-single__meta-row">
										<span class="press-single__meta-label"><?php esc_html_e( 'Employment Type', 'cyberrete' ); ?></span>
										<span class="press-single__meta-value"><?php echo esc_html( $employment_type ); ?></span>
									</div>
								<?php endif; ?>

								<?php if ( '' !== $department ) : ?>
									<div class="press-single__meta-row">
										<span class="press-single__meta-label"><?php esc_html_e( 'Department', 'cyberrete' ); ?></span>
										<span class="press-single__meta-value"><?php echo esc_html( $department ); ?></span>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( $related_query->have_posts() ) : ?>
								<section class="press-single__related" aria-label="<?php esc_attr_e( 'Other vacancies', 'cyberrete' ); ?>">
									<h2 class="press-single__related-title"><?php esc_html_e( 'Other Vacancies', 'cyberrete' ); ?></h2>
									<ul class="press-single__related-list">
										<?php
										while ( $related_query->have_posts() ) :
											$related_query->the_post();
											$related_location = trim( (string) get_field( 'location', get_the_ID() ) );
											$related_type     = trim( (string) get_field( 'employment_type', get_the_ID() ) );
											$parts            = array_filter( array( $related_type, $related_location ) );
											?>
											<li class="press-single__related-item">
												<a href="<?php the_permalink(); ?>" class="press-single__related-link">
													<span class="press-single__related-link-title"><?php the_title(); ?></span>
													<?php if ( ! empty( $parts ) ) : ?>
														<span class="press-single__related-link-date"><?php echo esc_html( implode( ' - ', $parts ) ); ?></span>
													<?php endif; ?>
												</a>
											</li>
										<?php endwhile; ?>
									</ul>
								</section>
							<?php endif; ?>
						</aside>
					</div>
				</div>
			</article>

			<?php
			wp_reset_postdata();
		endwhile;
		?>
	<?php endif; ?>
</main>

<?php
get_footer();
