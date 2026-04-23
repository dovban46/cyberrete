<?php
/**
 * Category archive template for press posts.
 *
 * @package Cyberrete
 */

get_header();

$category_id          = (int) get_queried_object_id();
$category_title       = single_cat_title( '', false );
$category_description = category_description( $category_id );
$paged                = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$category_posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'cat'                 => $category_id,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$press_icon_url = get_template_directory_uri() . '/assets/images/blog-icon.svg';
?>

<main id="primary" class="site-main">
	<section class="press-page press-page--category">
		<div class="press-page__container js-animate">
			<header class="press-page__header">
				<h1 class="press-page__title">
					<?php
					printf(
						/* translators: %s: category name */
						esc_html__( 'Category: %s', 'cyberrete' ),
						esc_html( $category_title )
					);
					?>
				</h1>
				<?php if ( ! empty( $category_description ) ) : ?>
					<div class="press-page__category-description">
						<?php echo wp_kses_post( wpautop( $category_description ) ); ?>
					</div>
				<?php endif; ?>
			</header>

			<?php if ( $category_posts_query->have_posts() ) : ?>
				<div class="press-page__content">
					<div class="press-page__grid">
						<?php
						while ( $category_posts_query->have_posts() ) :
							$category_posts_query->the_post();

							$categories    = get_the_category();
							$category_name = ( ! empty( $categories ) && isset( $categories[0]->name ) ) ? $categories[0]->name : '';
							?>
							<article class="press-page__card">
								<a href="<?php the_permalink(); ?>" class="press-page__image-link">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="press-page__image-wrap">
											<?php
											the_post_thumbnail(
												'large',
												array(
													'class'   => 'press-page__image',
													'loading' => 'lazy',
													'alt'     => the_title_attribute( array( 'echo' => false ) ),
												)
											);
											?>
										</div>
									<?php endif; ?>
								</a>

								<div class="press-page__body">
									<div class="press-page__title-row">
										<h3 class="press-page__post-title">
											<a href="<?php the_permalink(); ?>" class="press-page__post-title-link"><?php the_title(); ?></a>
										</h3>
										<span class="press-page__icon-wrap" aria-hidden="true">
											<img
												src="<?php echo esc_url( $press_icon_url ); ?>"
												alt=""
												class="press-page__icon"
												width="18"
												height="18"
												decoding="async"
											>
										</span>
									</div>

									<time class="press-page__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
										<?php echo esc_html( get_the_date( 'd M. Y' ) ); ?>
									</time>

									<?php if ( $category_name ) : ?>
										<span class="press-page__category"><?php echo esc_html( $category_name ); ?></span>
									<?php endif; ?>
								</div>
							</article>
						<?php endwhile; ?>
					</div>

					<?php
					$total_pages  = (int) $category_posts_query->max_num_pages;
					$number_links = paginate_links(
						array(
							'total'      => $total_pages,
							'current'    => $paged,
							'mid_size'   => 1,
							'prev_next'  => false,
							'type'       => 'array',
						)
					);
					?>

					<?php if ( $total_pages > 1 ) : ?>
						<nav class="press-page__pagination" aria-label="<?php esc_attr_e( 'Category posts pagination', 'cyberrete' ); ?>">
							<ul class="press-page__pagination-list">
								<li class="press-page__pagination-item">
									<?php if ( $paged > 1 ) : ?>
										<a class="press-page__pager-link press-page__pager-link--prev" href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>">
											<span class="press-page__pager-label press-page__pager-label--desktop"><?php esc_html_e( 'Previous', 'cyberrete' ); ?></span>
											<span class="press-page__pager-label press-page__pager-label--mobile"><?php esc_html_e( 'Prev', 'cyberrete' ); ?></span>
										</a>
									<?php else : ?>
										<span class="press-page__pager-link press-page__pager-link--prev press-page__pager-link--disabled" aria-disabled="true">
											<span class="press-page__pager-label press-page__pager-label--desktop"><?php esc_html_e( 'Previous', 'cyberrete' ); ?></span>
											<span class="press-page__pager-label press-page__pager-label--mobile"><?php esc_html_e( 'Prev', 'cyberrete' ); ?></span>
										</span>
									<?php endif; ?>
								</li>

								<?php foreach ( (array) $number_links as $link ) : ?>
									<li class="press-page__pagination-item">
										<?php echo wp_kses_post( $link ); ?>
									</li>
								<?php endforeach; ?>

								<li class="press-page__pagination-item">
									<?php if ( $paged < $total_pages ) : ?>
										<a class="press-page__pager-link press-page__pager-link--next" href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>">
											<?php esc_html_e( 'Next', 'cyberrete' ); ?>
										</a>
									<?php else : ?>
										<span class="press-page__pager-link press-page__pager-link--next press-page__pager-link--disabled" aria-disabled="true">
											<?php esc_html_e( 'Next', 'cyberrete' ); ?>
										</span>
									<?php endif; ?>
								</li>
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<p class="press-page__empty"><?php esc_html_e( 'No posts found in this category yet.', 'cyberrete' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
wp_reset_postdata();
get_footer();
