<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cyberrete
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

    <?php 
    $header_logo   = get_field( 'header_logo', 'option' );
    $header_button = get_field( 'header_button', 'option' );
    ?>

    <header id="masthead" class="site-header header">
        <div class="header__container">
            
            <div class="header__logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="header__logo-link">
                    <?php if ( ! empty( $header_logo ) ) : ?>
                        <img src="<?php echo esc_url( $header_logo['url'] ); ?>" alt="<?php echo esc_attr( $header_logo['alt'] ); ?>" class="header__logo-img">
                    <?php else : ?>
                        <span class="header__logo-text"><?php bloginfo( 'name' ); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <nav id="site-navigation" class="header__nav main-navigation">
                <button class="header__menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'cyberrete' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/header-mobile.svg' ); ?>" alt="Menu" class="header__menu-icon">
				</button>
                <?php
                wp_nav_menu(
                    array(
                        'menu'       => 'Main menu', 
                        'menu_id'    => 'primary-menu',
                        'menu_class' => 'header__menu-list',
                        'container'  => false, 
                    )
                );
                ?>
            </nav><div class="header__action">
                <?php if ( $header_button ) : 
                    $button_url    = $header_button['url'];
                    $button_title  = $header_button['title'];
                    $button_target = $header_button['target'] ? $header_button['target'] : '_self';
                    ?>
                    <a href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>" class="header__btn btn">
                        <?php echo esc_html( $button_title ); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div></header>
