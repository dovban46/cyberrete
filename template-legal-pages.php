<?php
/**
 * Template Name: Legal Pages
 * Template Post Type: page
 *
 * @package Cyberrete
 */

get_header();
?>

<main id="primary" class="site-main legal-page">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'legal-page__article' ); ?>>
				<div class="legal-page__container">
					<div class="legal-page__content">
						<?php the_content(); ?>
					</div>
				</div>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>

<?php
get_footer();
