<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cyberrete
 */

$footer_logo                 = null;
$footer_newsletter_text      = '';
$footer_newsletter_shortcode = '';
$footer_contacts             = array();
$footer_copyright_text       = '';
$footer_address              = '';
$footer_social_links         = array();

if ( function_exists( 'get_field' ) ) {
	// Група ACF `footer_top`: logo, текст розсилки, шорткод.
	$footer_top = get_field( 'footer_top', 'option' );
	if ( is_array( $footer_top ) ) {
		if ( ! empty( $footer_top['footer_logo'] ) ) {
			$footer_logo = $footer_top['footer_logo'];
		}
		if ( isset( $footer_top['footer_newsletter_text'] ) ) {
			$footer_newsletter_text = $footer_top['footer_newsletter_text'];
		}
		if ( isset( $footer_top['footer_newsletter_shortcode'] ) ) {
			$footer_newsletter_shortcode = $footer_top['footer_newsletter_shortcode'];
		}
	}

	// Репітер на рівні групи полів «Footer».
	$footer_contacts = get_field( 'footer_contacts', 'option' );
	$footer_contacts = is_array( $footer_contacts ) ? $footer_contacts : array();

	// Група ACF `footer_bottom`: копірайт, адреса, репітер соцмереж.
	$footer_bottom = get_field( 'footer_bottom', 'option' );
	if ( is_array( $footer_bottom ) ) {
		if ( isset( $footer_bottom['footer_copyright_text'] ) ) {
			$footer_copyright_text = $footer_bottom['footer_copyright_text'];
		}
		if ( isset( $footer_bottom['footer_address'] ) ) {
			$footer_address = $footer_bottom['footer_address'];
		}
		if ( isset( $footer_bottom['footer_social_links'] ) && is_array( $footer_bottom['footer_social_links'] ) ) {
			$footer_social_links = $footer_bottom['footer_social_links'];
		}
	}
}

$footer_has_contacts = false;
foreach ( $footer_contacts as $row ) {
	$dept  = isset( $row['contact_department'] ) ? $row['contact_department'] : '';
	$value = isset( $row['contact_value'] ) ? $row['contact_value'] : '';
	$has_v = function_exists( 'cyberrete_footer_contact_value_nonempty' )
		? cyberrete_footer_contact_value_nonempty( $value )
		: (bool) $value;
	if ( $dept || $has_v ) {
		$footer_has_contacts = true;
		break;
	}
}

$footer_social_items = array();
foreach ( $footer_social_links as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$resolved_link = function_exists( 'cyberrete_acf_resolved_url' )
		? cyberrete_acf_resolved_url( isset( $row['social_link'] ) ? $row['social_link'] : '' )
		: '';
	if ( $resolved_link !== '' ) {
		$footer_social_items[] = $row;
	}
}
$footer_has_social = ! empty( $footer_social_items );

$footer_year = ( function_exists( 'wp_date' ) )
	? wp_date( 'Y' )
	: gmdate( 'Y' );

$footer_menu_locations = array(
	'footer_menu_1',
	'footer_menu_2',
	'footer_menu_3',
);

$footer_has_menus = false;
foreach ( $footer_menu_locations as $footer_menu_loc ) {
	if ( has_nav_menu( $footer_menu_loc ) ) {
		$footer_has_menus = true;
		break;
	}
}

$footer_middle_classes = array( 'site-footer__middle' );
if ( $footer_has_contacts && $footer_has_menus ) {
	$footer_middle_classes[] = 'site-footer__middle--split';
} elseif ( $footer_has_contacts ) {
	$footer_middle_classes[] = 'site-footer__middle--contacts-only';
} elseif ( $footer_has_menus ) {
	$footer_middle_classes[] = 'site-footer__middle--menus-only';
}
?>

	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">

			<div class="site-footer__top">
				<div class="site-footer__brand">
					<?php if ( is_array( $footer_logo ) && ! empty( $footer_logo['url'] ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo-link" rel="home">
							<img
								src="<?php echo esc_url( $footer_logo['url'] ); ?>"
								alt="<?php echo esc_attr( ! empty( $footer_logo['alt'] ) ? $footer_logo['alt'] : get_bloginfo( 'name' ) ); ?>"
								class="site-footer__logo-img"
								loading="lazy"
								decoding="async"
								<?php
								if ( ! empty( $footer_logo['width'] ) ) {
									echo ' width="' . (int) $footer_logo['width'] . '"';
								}
								if ( ! empty( $footer_logo['height'] ) ) {
									echo ' height="' . (int) $footer_logo['height'] . '"';
								}
								?>
							>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo-link site-footer__logo-link--text" rel="home">
							<span class="site-footer__logo-text"><?php bloginfo( 'name' ); ?></span>
						</a>
					<?php endif; ?>
				</div>

				<div class="site-footer__newsletter">
					<?php if ( $footer_newsletter_text ) : ?>
						<p class="site-footer__newsletter-text"><?php echo esc_html( $footer_newsletter_text ); ?></p>
					<?php endif; ?>

					<?php if ( $footer_newsletter_shortcode ) : ?>
						<div class="site-footer__newsletter-form">
							<?php echo do_shortcode( $footer_newsletter_shortcode ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $footer_has_contacts || $footer_has_menus ) : ?>
				<div class="<?php echo esc_attr( implode( ' ', $footer_middle_classes ) ); ?>">
					<?php if ( $footer_has_contacts ) : ?>
						<div class="site-footer__middle-contacts">
							<div class="site-footer__col site-footer__col--contacts">
								<h3 class="site-footer__col-title"><?php esc_html_e( 'Contact', 'cyberrete' ); ?></h3>

								<ul class="site-footer__contacts-list">
									<?php foreach ( $footer_contacts as $row ) : ?>
										<?php
										$dept  = isset( $row['contact_department'] ) ? $row['contact_department'] : '';
										$value = isset( $row['contact_value'] ) ? $row['contact_value'] : '';
										$has_v = function_exists( 'cyberrete_footer_contact_value_nonempty' )
											? cyberrete_footer_contact_value_nonempty( $value )
											: (bool) $value;
										if ( ! $dept && ! $has_v ) {
											continue;
										}
										$value_html = function_exists( 'cyberrete_footer_contact_value_html' )
											? cyberrete_footer_contact_value_html( $value )
											: '';
										?>
										<li class="site-footer__contact">
											<?php if ( $dept ) : ?>
												<span class="site-footer__contact-dept"><?php echo esc_html( $dept ); ?></span>
											<?php endif; ?>
											<?php if ( $has_v && $value_html !== '' ) : ?>
												<span class="site-footer__contact-value"><?php echo wp_kses_post( $value_html ); ?></span>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $footer_has_menus ) : ?>
						<div class="site-footer__middle-menus">
							<?php
							foreach ( $footer_menu_locations as $location ) :
								$menu_title = function_exists( 'cyberrete_nav_menu_title_for_location' )
									? cyberrete_nav_menu_title_for_location( $location )
									: '';
								$has_menu   = has_nav_menu( $location );
								if ( ! $has_menu ) {
									continue;
								}
								$aria = $menu_title ? $menu_title : __( 'Footer menu', 'cyberrete' );
								?>
								<div class="site-footer__col site-footer__col--nav">
									<?php if ( $menu_title ) : ?>
										<h3 class="site-footer__col-title"><?php echo esc_html( $menu_title ); ?></h3>
									<?php endif; ?>

									<nav class="site-footer__nav" aria-label="<?php echo esc_attr( $aria ); ?>">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => $location,
												'menu_class'     => 'site-footer__menu',
												'container'      => false,
												'depth'          => 2,
												'fallback_cb'    => false,
											)
										);
										?>
									</nav>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="site-footer__bottom">
				<div class="site-footer__bottom-info">
					<?php if ( $footer_copyright_text ) : ?>
						<p class="site-footer__copyright">
							<?php
							echo esc_html( '© ' . $footer_year . ' ' . $footer_copyright_text );
							?>
						</p>
					<?php endif; ?>

					<?php if ( $footer_address ) : ?>
						<p class="site-footer__address"><?php echo nl2br( esc_html( $footer_address ) ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $footer_has_social ) : ?>
					<div class="site-footer__bottom-social">
						<p class="site-footer__social-heading"><?php esc_html_e( 'Follow us:', 'cyberrete' ); ?></p>

						<ul class="site-footer__social-list">
							<?php foreach ( $footer_social_items as $row ) : ?>
								<?php
								if ( ! is_array( $row ) ) {
									continue;
								}
								$link = function_exists( 'cyberrete_acf_resolved_url' )
									? cyberrete_acf_resolved_url( isset( $row['social_link'] ) ? $row['social_link'] : '' )
									: '';
								if ( $link === '' ) {
									continue;
								}

								$icon      = isset( $row['social_icon'] ) ? $row['social_icon'] : null;
								$icon_data = function_exists( 'cyberrete_acf_resolved_image' )
									? cyberrete_acf_resolved_image( $icon )
									: null;
								$icon_url  = $icon_data ? $icon_data['url'] : '';
								$icon_alt  = $icon_data ? $icon_data['alt'] : '';
								?>
								<li class="site-footer__social-item">
									<a
										href="<?php echo esc_url( $link ); ?>"
										class="site-footer__social-link"
										target="_blank"
										rel="noopener noreferrer"
										aria-label="<?php echo esc_attr( $icon_alt !== '' ? $icon_alt : __( 'Social link', 'cyberrete' ) ); ?>"
									>
										<?php if ( $icon_url !== '' ) : ?>
											<span class="site-footer__social-icon" aria-hidden="true">
												<img
													src="<?php echo esc_url( $icon_url ); ?>"
													alt=""
													class="site-footer__social-icon-img"
													loading="lazy"
													decoding="async"
													<?php
													if ( $icon_data && $icon_data['width'] > 0 ) {
														echo ' width="' . (int) $icon_data['width'] . '"';
													}
													if ( $icon_data && $icon_data['height'] > 0 ) {
														echo ' height="' . (int) $icon_data['height'] . '"';
													}
													?>
												>
											</span>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
