<?php
/**
 * Flexible block: blog (наприклад «Cyberette In The Press»).
 *
 * ACF: у flexible «blocks» layout з іменем `blog`.
 * Група `blog_section` → поле `blog_title` (решта — записи WP).
 *
 * @package cyberrete
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$blog_section = get_sub_field( 'blog_section' );
$blog_title   = '';

if ( is_array( $blog_section ) && isset( $blog_section['blog_title'] ) ) {
	$blog_title = $blog_section['blog_title'];
}

$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$blog_icon_url = get_template_directory_uri() . '/assets/images/blog-icon.svg';

if ( ! $blog_title && ! $blog_query->have_posts() ) {
	return;
}
?>

<section class="blog">
	<div class="blog__container js-animate">

		<?php if ( $blog_title || $blog_query->have_posts() ) : ?>

			<div class="blog__top">
				<?php if ( $blog_title ) : ?>
					<h2 class="blog__title"><?php echo esc_html( $blog_title ); ?></h2>
				<?php endif; ?>

				<?php if ( $blog_query->have_posts() ) : ?>
					<div class="blog__nav blog__nav--desktop" aria-hidden="false">
						<button
							type="button"
							class="blog__nav-btn blog__nav-btn--prev js-blog-prev"
							aria-label="<?php esc_attr_e( 'Previous posts', 'cyberrete' ); ?>"
						>
							<span class="blog__nav-visual" aria-hidden="true">
								<img
									src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
									alt=""
									class="blog__nav-svg blog__nav-svg--active"
									width="32"
									height="32"
									decoding="async"
								>
								<img
									src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
									alt=""
									class="blog__nav-svg blog__nav-svg--block"
									width="32"
									height="32"
									decoding="async"
								>
							</span>
						</button>
						<button
							type="button"
							class="blog__nav-btn blog__nav-btn--next js-blog-next"
							aria-label="<?php esc_attr_e( 'Next posts', 'cyberrete' ); ?>"
						>
							<span class="blog__nav-visual" aria-hidden="true">
								<img
									src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
									alt=""
									class="blog__nav-svg blog__nav-svg--active"
									width="32"
									height="32"
									decoding="async"
								>
								<img
									src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
									alt=""
									class="blog__nav-svg blog__nav-svg--block"
									width="32"
									height="32"
									decoding="async"
								>
							</span>
						</button>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $blog_query->have_posts() ) : ?>
				<div class="blog__slider swiper js-blog-slider">
					<div class="blog__track swiper-wrapper">

						<?php
						while ( $blog_query->have_posts() ) :
							$blog_query->the_post();

							$categories    = get_the_category();
							$category_name = ( ! empty( $categories ) && isset( $categories[0]->name ) ) ? $categories[0]->name : '';
							?>

							<div class="blog__slide swiper-slide">
								<article class="blog__card">
									<a href="<?php the_permalink(); ?>" class="blog__image-link">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="blog__image-wrap">
												<?php
												the_post_thumbnail(
													'large',
													array(
														'class'   => 'blog__image',
														'loading' => 'lazy',
														'alt'     => the_title_attribute( array( 'echo' => false ) ),
													)
												);
												?>
											</div>
										<?php endif; ?>
									</a>

									<div class="blog__body">
										<div class="blog__title-row">
											<h3 class="blog__post-title">
												<a href="<?php the_permalink(); ?>" class="blog__post-title-link"><?php the_title(); ?></a>
											</h3>
											<span class="blog__icon-wrap" aria-hidden="true">
												<img
													src="<?php echo esc_url( $blog_icon_url ); ?>"
													alt=""
													class="blog__icon"
													width="18"
													height="18"
													decoding="async"
												>
											</span>
										</div>

										<time class="blog__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
											<?php echo esc_html( get_the_date( 'd M. Y' ) ); ?>
										</time>

										<?php if ( $category_name ) : ?>
											<span class="blog__category"><?php echo esc_html( $category_name ); ?></span>
										<?php endif; ?>
									</div>
								</article>
							</div>

						<?php endwhile; ?>

					</div>

					<div class="blog__pagination swiper-pagination"></div>
				</div>

				<div class="blog__nav blog__nav--mobile" aria-hidden="false">
					<button
						type="button"
						class="blog__nav-btn blog__nav-btn--prev js-blog-prev"
						aria-label="<?php esc_attr_e( 'Previous posts', 'cyberrete' ); ?>"
					>
						<span class="blog__nav-visual" aria-hidden="true">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
								alt=""
								class="blog__nav-svg blog__nav-svg--active"
								width="32"
								height="32"
								decoding="async"
							>
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
								alt=""
								class="blog__nav-svg blog__nav-svg--block"
								width="32"
								height="32"
								decoding="async"
							>
						</span>
					</button>
					<button
						type="button"
						class="blog__nav-btn blog__nav-btn--next js-blog-next"
						aria-label="<?php esc_attr_e( 'Next posts', 'cyberrete' ); ?>"
					>
						<span class="blog__nav-visual" aria-hidden="true">
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
								alt=""
								class="blog__nav-svg blog__nav-svg--active"
								width="32"
								height="32"
								decoding="async"
							>
							<img
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
								alt=""
								class="blog__nav-svg blog__nav-svg--block"
								width="32"
								height="32"
								decoding="async"
							>
						</span>
					</button>
				</div>
			<?php endif; ?>

		<?php endif; ?>

	</div>
</section>

<?php
wp_reset_postdata();
