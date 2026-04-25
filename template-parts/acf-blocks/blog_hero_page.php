<?php
/**
 * Flexible layout: blog_hero_page
 *
 * ACF group: blog_hero_page_section
 *  - blog_hero_page_title
 *  - blog_hero_page_text
 *  - blog_hero_page_image
 *
 * @package Cyberrete
 */

if ( ! function_exists( 'cyberrete_blog_hero_page_title_html' ) ) {
	/**
	 * Apply gradient to second word in title.
	 *
	 * @param string $title Raw title.
	 * @return string
	 */
	function cyberrete_blog_hero_page_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$html_words = array();
		foreach ( $words as $index => $word ) {
			if ( 1 === $index ) {
				$html_words[] = '<span class="blog-hero-page__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html_words[] = esc_html( $word );
			}
		}

		return implode( ' ', $html_words );
	}
}

$section = get_sub_field( 'blog_hero_page_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title = isset( $section['blog_hero_page_title'] ) ? $section['blog_hero_page_title'] : '';
$text  = isset( $section['blog_hero_page_text'] ) ? $section['blog_hero_page_text'] : '';
$image = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $section['blog_hero_page_image'] ) ? $section['blog_hero_page_image'] : null ) : null;

if ( ! $title && ! $text && ! $image ) {
	return;
}
?>

<section class="blog-hero-page">
	<div class="blog-hero-page__container">
		<?php if ( $title ) : ?>
			<h1 class="blog-hero-page__title">
				<?php
				echo wp_kses(
					cyberrete_blog_hero_page_title_html( $title ),
					array(
						'span' => array( 'class' => true ),
					)
				);
				?>
			</h1>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<div class="blog-hero-page__text">
				<?php echo wp_kses_post( wpautop( $text ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $image && ! empty( $image['url'] ) ) : ?>
		<div class="blog-hero-page__media">
			<div class="blog-hero-page__media-overlay" aria-hidden="true"></div>
			<img
				src="<?php echo esc_url( $image['url'] ); ?>"
				alt="<?php echo esc_attr( isset( $image['alt'] ) ? $image['alt'] : '' ); ?>"
				class="blog-hero-page__image"
				loading="lazy"
				decoding="async"
			>
		</div>
	<?php endif; ?>
</section>
