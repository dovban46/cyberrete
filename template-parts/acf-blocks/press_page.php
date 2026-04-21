<?php
/**
 * Flexible layout: press_page
 *
 * ACF: група `press_page_section`
 *   - press_page_title (text)
 *
 * Контент: публічні записи WP (`post`) з пагінацією.
 *
 * @package cyberrete
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$press_page_section = get_sub_field( 'press_page_section' );
$press_page_title   = '';

if ( is_array( $press_page_section ) && ! empty( $press_page_section['press_page_title'] ) ) {
	$press_page_title = $press_page_section['press_page_title'];
}

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$press_posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$press_icon_url = get_template_directory_uri() . '/assets/images/blog-icon.svg';

if ( ! $press_page_title && ! $press_posts_query->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>

<section class="press-page">
	<div class="press-page__container js-animate">
		<?php if ( $press_page_title ) : ?>
			<header class="press-page__header">
				<h2 class="press-page__title"><?php echo esc_html( $press_page_title ); ?></h2>
			</header>
		<?php endif; ?>

		<?php if ( $press_posts_query->have_posts() ) : ?>
			<div class="press-page__content">
				<div class="press-page__grid">
					<?php
					while ( $press_posts_query->have_posts() ) :
						$press_posts_query->the_post();

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
				$total_pages = (int) $press_posts_query->max_num_pages;
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
					<nav class="press-page__pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'cyberrete' ); ?>">
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
		<?php endif; ?>
	</div>
</section>

<?php
wp_reset_postdata();
