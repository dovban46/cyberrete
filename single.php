<?php
/**
 * Template for single post (Press article).
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

			$post_id    = get_the_ID();
			$categories = get_the_category( $post_id );

			$related_args = array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => 3,
				'post__not_in'        => array( $post_id ),
				'ignore_sticky_posts' => true,
				'orderby'             => 'date',
				'order'               => 'DESC',
			);

			if ( ! empty( $categories ) ) {
				$related_args['category__in'] = wp_list_pluck( $categories, 'term_id' );
			}

			$related_query = new WP_Query( $related_args );
			?>

			<article class="press-single">
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
							<div class="press-single__meta-card">
								<time class="press-single__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
									<?php echo esc_html( get_the_date( 'd M. Y' ) ); ?>
								</time>

								<?php if ( ! empty( $categories ) ) : ?>
									<div class="press-single__categories">
										<?php foreach ( $categories as $cat ) : ?>
											<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="press-single__category">
												<?php echo esc_html( $cat->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( $related_query->have_posts() ) : ?>
								<section class="press-single__related" aria-label="<?php esc_attr_e( 'Related posts', 'cyberrete' ); ?>">
									<h2 class="press-single__related-title"><?php esc_html_e( 'Related Posts', 'cyberrete' ); ?></h2>
									<ul class="press-single__related-list">
										<?php
										while ( $related_query->have_posts() ) :
											$related_query->the_post();
											?>
											<li class="press-single__related-item">
												<a href="<?php the_permalink(); ?>" class="press-single__related-link">
													<span class="press-single__related-link-title"><?php the_title(); ?></span>
													<span class="press-single__related-link-date"><?php echo esc_html( get_the_date( 'd M. Y' ) ); ?></span>
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
