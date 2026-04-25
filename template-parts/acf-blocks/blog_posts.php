<?php
/**
 * Flexible layout: blog_posts
 *
 * ACF group: blog_posts_section
 *  - blog_posts_title
 *
 * Content source: post type `blogs`.
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$section = get_sub_field( 'blog_posts_section' );
$title   = is_array( $section ) && ! empty( $section['blog_posts_title'] ) ? $section['blog_posts_title'] : '';

$sort_by = isset( $_GET['sort_by'] ) ? sanitize_key( wp_unslash( $_GET['sort_by'] ) ) : 'newest';
$use_case = isset( $_GET['use_case'] ) ? sanitize_text_field( wp_unslash( $_GET['use_case'] ) ) : '';

if ( ! in_array( $sort_by, array( 'newest', 'oldest' ), true ) ) {
	$sort_by = 'newest';
}

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$query_args = array(
	'post_type'      => 'blogs',
	'post_status'    => 'publish',
	'posts_per_page' => 8,
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => ( 'oldest' === $sort_by ) ? 'ASC' : 'DESC',
);

if ( '' !== $use_case ) {
	// "Search by name": uses WP search against title/content.
	$query_args['s'] = $use_case;
}

$blog_posts_query = new WP_Query( $query_args );

if ( ! $title && ! $blog_posts_query->have_posts() ) {
	wp_reset_postdata();
	return;
}

$current_url = get_permalink( get_queried_object_id() );
?>

<section class="blog-posts">
	<div class="blog-posts__container js-animate">
		<div class="blog-posts__top">
			<?php if ( $title ) : ?>
				<h2 class="blog-posts__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<form class="blog-posts__filters" method="get" action="<?php echo esc_url( $current_url ); ?>">
				<div class="blog-posts__field blog-posts__field--sort">
					<label class="screen-reader-text" for="blog-posts-sort"><?php esc_html_e( 'Sort by', 'cyberrete' ); ?></label>
					<select id="blog-posts-sort" name="sort_by" class="blog-posts__select" onchange="this.form.submit()">
						<option value="newest" <?php selected( 'newest', $sort_by ); ?>><?php esc_html_e( 'Sort by: Newest', 'cyberrete' ); ?></option>
						<option value="oldest" <?php selected( 'oldest', $sort_by ); ?>><?php esc_html_e( 'Sort by: Oldest', 'cyberrete' ); ?></option>
					</select>
					<span class="blog-posts__field-icon blog-posts__field-icon--chevron" aria-hidden="true">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/chevron-down.svg' ); ?>" alt="" width="16" height="16">
					</span>
				</div>

				<div class="blog-posts__field blog-posts__field--search">
					<label class="screen-reader-text" for="blog-posts-use-case"><?php esc_html_e( 'Use Case', 'cyberrete' ); ?></label>
					<input
						id="blog-posts-use-case"
						type="search"
						name="use_case"
						class="blog-posts__search"
						placeholder="<?php esc_attr_e( 'Use Case', 'cyberrete' ); ?>"
						value="<?php echo esc_attr( $use_case ); ?>"
					>
					<span class="blog-posts__field-icon blog-posts__field-icon--search" aria-hidden="true">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search.svg' ); ?>" alt="" width="16" height="16">
					</span>
					<button type="submit" class="blog-posts__submit"><?php esc_html_e( 'Search', 'cyberrete' ); ?></button>
				</div>
			</form>
		</div>

		<?php if ( $blog_posts_query->have_posts() ) : ?>
			<div class="blog-posts__grid">
				<?php
				while ( $blog_posts_query->have_posts() ) :
					$blog_posts_query->the_post();
					$description = get_field( 'description', get_the_ID() );
					?>
					<article class="blog-posts__card js-blog-posts-card">
						<a href="<?php the_permalink(); ?>" class="blog-posts__image-link">
							<div class="blog-posts__image-wrap">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'large',
										array(
											'class'   => 'blog-posts__image',
											'loading' => 'lazy',
											'alt'     => the_title_attribute( array( 'echo' => false ) ),
										)
									);
									?>
								<?php endif; ?>
							</div>
						</a>

						<div class="blog-posts__body">
							<time class="blog-posts__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
							</time>

							<h3 class="blog-posts__category"><?php echo esc_html( get_the_title() ); ?></h3>

							<?php if ( $description ) : ?>
								<div class="blog-posts__description"><?php echo esc_html( $description ); ?></div>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="blog-posts__more"><?php esc_html_e( 'Read more', 'cyberrete' ); ?></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			$total_pages  = (int) $blog_posts_query->max_num_pages;
			$number_links = paginate_links(
				array(
					'total'      => $total_pages,
					'current'    => $paged,
					'mid_size'   => 1,
					'prev_next'  => false,
					'type'       => 'array',
					'add_args'   => array_filter(
						array(
							'sort_by'  => $sort_by,
							'use_case' => $use_case,
						),
						static function( $value ) {
							return '' !== (string) $value;
						}
					),
				)
			);
			?>

			<?php if ( $total_pages > 1 ) : ?>
				<?php
				$pagination_args = array_filter(
					array(
						'sort_by'  => $sort_by,
						'use_case' => $use_case,
					),
					static function( $value ) {
						return '' !== (string) $value;
					}
				);
				?>
				<nav class="blog-posts__pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'cyberrete' ); ?>">
					<ul class="blog-posts__pagination-list">
						<li class="blog-posts__pagination-item">
							<?php if ( $paged > 1 ) : ?>
								<a class="blog-posts__pager-link blog-posts__pager-link--prev" href="<?php echo esc_url( add_query_arg( $pagination_args, get_pagenum_link( $paged - 1 ) ) ); ?>">
									<span class="blog-posts__pager-label blog-posts__pager-label--desktop"><?php esc_html_e( 'Previous', 'cyberrete' ); ?></span>
									<span class="blog-posts__pager-label blog-posts__pager-label--mobile"><?php esc_html_e( 'Prev', 'cyberrete' ); ?></span>
								</a>
							<?php else : ?>
								<span class="blog-posts__pager-link blog-posts__pager-link--prev blog-posts__pager-link--disabled" aria-disabled="true">
									<span class="blog-posts__pager-label blog-posts__pager-label--desktop"><?php esc_html_e( 'Previous', 'cyberrete' ); ?></span>
									<span class="blog-posts__pager-label blog-posts__pager-label--mobile"><?php esc_html_e( 'Prev', 'cyberrete' ); ?></span>
								</span>
							<?php endif; ?>
						</li>

						<?php foreach ( (array) $number_links as $link ) : ?>
							<li class="blog-posts__pagination-item">
								<?php echo wp_kses_post( $link ); ?>
							</li>
						<?php endforeach; ?>

						<li class="blog-posts__pagination-item">
							<?php if ( $paged < $total_pages ) : ?>
									<a class="blog-posts__pager-link blog-posts__pager-link--next" href="<?php echo esc_url( add_query_arg( $pagination_args, get_pagenum_link( $paged + 1 ) ) ); ?>">
									<?php esc_html_e( 'Next', 'cyberrete' ); ?>
								</a>
							<?php else : ?>
								<span class="blog-posts__pager-link blog-posts__pager-link--next blog-posts__pager-link--disabled" aria-disabled="true">
									<?php esc_html_e( 'Next', 'cyberrete' ); ?>
								</span>
							<?php endif; ?>
						</li>
					</ul>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<p class="blog-posts__empty"><?php esc_html_e( 'No posts found.', 'cyberrete' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
wp_reset_postdata();
