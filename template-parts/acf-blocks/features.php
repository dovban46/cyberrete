<?php
/**
 * Flexible layout: features
 *
 * ACF: feature_section
 *   - feature_title (text)
 *   - feature_description (text / textarea)
 *   - feature_button (link)
 *   - feature_items (repeater)
 *       - icon (image)
 *       - title (text)
 *       - link (link)
 *
 * Сітка на десктопі: до 4 карток у ряд; на мобілці (≤768px) — Swiper (див. main.js).
 *
 * @package Cyberrete
 */

$arrow_features_url = get_template_directory_uri() . '/assets/images/Arrow-features.svg';
?>
<section class="features">
    <div class="features__container js-features-section">

        <?php if ( have_rows( 'feature_section' ) ) : ?>
            <?php
            while ( have_rows( 'feature_section' ) ) :
                the_row();

                $section_title       = get_sub_field( 'feature_title' );
                $section_description = get_sub_field( 'feature_description' );
                $section_button      = get_sub_field( 'feature_button' );
                ?>

                <header class="features__header">
                    <?php if ( $section_title ) : ?>
                        <h2 class="features__title js-stagger-item"><?php echo esc_html( $section_title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $section_description ) : ?>
                        <div class="features__description js-stagger-item">
                            <p><?php echo esc_html( $section_description ); ?></p>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if ( have_rows( 'feature_items' ) ) : ?>
                    <div class="features__grid-wrap">
                        <div class="features__slider swiper js-features-slider">
                            <div class="features__track swiper-wrapper">
                                <?php
                                while ( have_rows( 'feature_items' ) ) :
                                    the_row();

                                    $item_icon = get_sub_field( 'icon' );
                                    $item_title = get_sub_field( 'title' );
                                    $item_link  = get_sub_field( 'link' );
                                    ?>
                                    <div class="features__slide swiper-slide">
                                        <article class="features__card js-stagger-item">
                                            <?php if ( $item_icon ) : ?>
                                                <div class="features__card-icon-wrap">
                                                    <img
                                                        src="<?php echo esc_url( $item_icon['url'] ); ?>"
                                                        alt="<?php echo esc_attr( $item_icon['alt'] ); ?>"
                                                        class="features__card-icon"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( $item_title ) : ?>
                                                <h3 class="features__card-title"><?php echo esc_html( $item_title ); ?></h3>
                                            <?php endif; ?>

                                            <?php if ( $item_link && ! empty( $item_link['url'] ) ) : ?>
                                                <?php
                                                $link_url    = $item_link['url'];
                                                $link_title  = ! empty( $item_link['title'] ) ? $item_link['title'] : __( 'Learn more', 'cyberrete' );
                                                $link_target = ! empty( $item_link['target'] ) ? $item_link['target'] : '_self';
                                                ?>
                                                <div class="features__card-action">
                                                    <a
                                                        href="<?php echo esc_url( $link_url ); ?>"
                                                        class="features__card-link"
                                                        target="<?php echo esc_attr( $link_target ); ?>"
                                                        <?php echo '_blank' === $link_target ? ' rel="noopener noreferrer"' : ''; ?>
                                                    >
                                                        <span class="features__card-link-text"><?php echo esc_html( $link_title ); ?></span>
                                                        <img
                                                            src="<?php echo esc_url( $arrow_features_url ); ?>"
                                                            alt=""
                                                            class="features__card-link-arrow"
                                                            width="19"
                                                            height="12"
                                                            decoding="async"
                                                            aria-hidden="true"
                                                        >
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </article>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $section_button && ! empty( $section_button['url'] ) ) : ?>
                    <?php
                    $btn_url    = $section_button['url'];
                    $btn_title  = ! empty( $section_button['title'] ) ? $section_button['title'] : '';
                    $btn_target = ! empty( $section_button['target'] ) ? $section_button['target'] : '_self';
                    ?>
                    <footer class="features__footer js-stagger-item">
                        <a
                            href="<?php echo esc_url( $btn_url ); ?>"
                            class="features__button btn"
                            target="<?php echo esc_attr( $btn_target ); ?>"
                            <?php echo '_blank' === $btn_target ? ' rel="noopener noreferrer"' : ''; ?>
                        >
                            <?php echo esc_html( $btn_title ); ?>
                        </a>
                    </footer>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>

