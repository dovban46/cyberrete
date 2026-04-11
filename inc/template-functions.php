<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Cyberrete
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cyberrete_body_classes( $classes ) {
	if ( ! is_front_page() ) {
		$classes[] = 'is-not-front-page';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'cyberrete_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cyberrete_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'cyberrete_pingback_header' );

/**
 * Title of the menu assigned to a theme location (for footer column headings).
 *
 * @param string $location Registered theme location key.
 * @return string Menu name or empty string.
 */
function cyberrete_nav_menu_title_for_location( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return '';
	}
	$menu = wp_get_nav_menu_object( $locations[ $location ] );
	return ( $menu instanceof WP_Term ) ? $menu->name : '';
}

/**
 * Normalize ACF URL or Link field value to a string (avoids passing arrays to esc_url() on PHP 8+).
 *
 * @param mixed $value Raw field value.
 * @return string
 */
function cyberrete_acf_resolved_url( $value ) {
	if ( is_string( $value ) ) {
		return $value;
	}
	if ( is_array( $value ) && isset( $value['url'] ) && is_string( $value['url'] ) ) {
		return $value['url'];
	}
	return '';
}

/**
 * Normalize ACF image field (array or attachment ID) for safe output.
 *
 * @param mixed $value Raw field value.
 * @return array{url: string, alt: string, width: int, height: int}|null
 */
function cyberrete_acf_resolved_image( $value ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) && is_string( $value['url'] ) ) {
		return array(
			'url'    => $value['url'],
			'alt'    => isset( $value['alt'] ) && is_string( $value['alt'] ) ? $value['alt'] : '',
			'width'  => isset( $value['width'] ) ? (int) $value['width'] : 0,
			'height' => isset( $value['height'] ) ? (int) $value['height'] : 0,
		);
	}

	if ( is_numeric( $value ) ) {
		$attachment_id = (int) $value;
		if ( $attachment_id <= 0 ) {
			return null;
		}
		$src = wp_get_attachment_image_src( $attachment_id, 'full' );
		if ( ! $src ) {
			return null;
		}
		return array(
			'url'    => $src[0],
			'width'  => isset( $src[1] ) ? (int) $src[1] : 0,
			'height' => isset( $src[2] ) ? (int) $src[2] : 0,
			'alt'    => (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
		);
	}

	return null;
}

/**
 * Whether footer contact_value has something to show (ACF Link or legacy string).
 *
 * @param mixed $value Field value.
 * @return bool
 */
function cyberrete_footer_contact_value_nonempty( $value ) {
	if ( is_array( $value ) ) {
		return ! empty( $value['url'] );
	}
	return is_string( $value ) && $value !== '';
}

/**
 * HTML for footer contact_value: ACF Link (title + url) or legacy HTML string.
 *
 * @param mixed $value Field value.
 * @return string Safe HTML.
 */
function cyberrete_footer_contact_value_html( $value ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		$url   = esc_url( $value['url'] );
		$title = isset( $value['title'] ) && $value['title'] !== '' ? $value['title'] : $value['url'];
		$title = wp_strip_all_tags( (string) $title );

		$target = isset( $value['target'] ) && $value['target'] !== '' ? $value['target'] : '_self';
		$target = in_array( $target, array( '_blank', '_self' ), true ) ? $target : '_self';

		$rel = ( '_blank' === $target ) ? ' rel="noopener noreferrer"' : '';

		return sprintf(
			'<a class="site-footer__contact-link" href="%1$s" target="%2$s"%3$s>%4$s</a>',
			$url,
			esc_attr( $target ),
			$rel,
			esc_html( $title )
		);
	}

	if ( is_string( $value ) && $value !== '' ) {
		return wp_kses_post( $value );
	}

	return '';
}
