<?php
/**
 * Flexible layout: roles
 *
 * ACF group: roles_section
 *  - roles_title
 *  - roles_top_text
 *  - roles_bottom_text
 *
 * Also outputs posts from post type `roles`:
 *  - title
 *  - employment_type (ACF)
 *  - location (ACF)
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'roles_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title       = isset( $section['roles_title'] ) ? trim( (string) $section['roles_title'] ) : '';
$top_text    = isset( $section['roles_top_text'] ) ? $section['roles_top_text'] : '';
$bottom_text = isset( $section['roles_bottom_text'] ) ? $section['roles_bottom_text'] : '';

$top_text_plain    = trim( wp_strip_all_tags( (string) $top_text ) );
$bottom_text_plain = trim( wp_strip_all_tags( (string) $bottom_text ) );

$roles_query = new WP_Query(
	array(
		'post_type'           => 'role',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

if ( '' === $title && '' === $top_text_plain && '' === $bottom_text_plain && ! $roles_query->have_posts() ) {
	return;
}
?>

<section class="roles">
	<div class="roles__container js-animate">
		<div class="roles__top">
			<?php if ( '' !== $title ) : ?>
				<h2 class="roles__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( '' !== $top_text_plain ) : ?>
				<div class="roles__top-text"><?php echo wp_kses_post( wpautop( $top_text ) ); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( $roles_query->have_posts() ) : ?>
			<div class="roles__list">
				<?php
				while ( $roles_query->have_posts() ) :
					$roles_query->the_post();
					$employment_type = trim( (string) get_field( 'employment_type' ) );
					$location        = trim( (string) get_field( 'location' ) );
					$details_parts    = array_filter(
						array( $employment_type, $location ),
						static function( $value ) {
							return '' !== $value;
						}
					);
					?>
					<article class="roles__item js-roles-item">
						<div class="roles__item-content">
							<h3 class="roles__item-title"><?php the_title(); ?></h3>
							<?php if ( ! empty( $details_parts ) ) : ?>
								<p class="roles__item-meta"><?php echo esc_html( implode( ' - ', $details_parts ) ); ?></p>
							<?php endif; ?>
						</div>

						<a class="roles__item-btn" href="<?php the_permalink(); ?>">
							<?php esc_html_e( 'View Job', 'cyberrete' ); ?>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $bottom_text_plain ) : ?>
			<div class="roles__bottom-text"><?php echo wp_kses_post( wpautop( $bottom_text ) ); ?></div>
		<?php endif; ?>
	</div>
</section>

<?php wp_reset_postdata(); ?>
