<section class="experts">
    <div class="experts__container js-animate">

        <?php if ( have_rows( 'experts_section' ) ) : ?>
            <?php while ( have_rows( 'experts_section' ) ) : the_row();

                $title = get_sub_field( 'experts_title' );
            ?>

                <div class="experts__top">
                    <?php if ( $title ) : ?>
                        <h2 class="experts__title"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <div class="experts__nav experts__nav--desktop" aria-hidden="false">
                        <button
                            type="button"
                            class="experts__nav-btn experts__nav-btn--prev js-experts-prev"
                            aria-label="<?php esc_attr_e( 'Previous testimonial', 'cyberrete' ); ?>"
                        >
                            <span class="experts__nav-visual" aria-hidden="true">
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--active"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--block"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                            </span>
                        </button>
                        <button
                            type="button"
                            class="experts__nav-btn experts__nav-btn--next js-experts-next"
                            aria-label="<?php esc_attr_e( 'Next testimonial', 'cyberrete' ); ?>"
                        >
                            <span class="experts__nav-visual" aria-hidden="true">
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--active"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--block"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                            </span>
                        </button>
                    </div>
                </div>

                <?php if ( have_rows( 'experts_cards' ) ) : ?>
                    <div class="experts__slider swiper js-experts-slider">
                        <div class="experts__track swiper-wrapper">

                            <?php while ( have_rows( 'experts_cards' ) ) : the_row();
                                $quote = get_sub_field( 'card_quote' );
                                $name  = get_sub_field( 'card_name' );
                                $role  = get_sub_field( 'card_role' );
                            ?>
                                <div class="experts__slide swiper-slide">
                                    <article class="experts__card">
                                        <?php if ( $quote ) : ?>
                                            <blockquote class="experts__quote">
                                                <p class="experts__quote-text"><?php echo wp_kses_post( $quote ); ?></p>
                                            </blockquote>
                                        <?php endif; ?>

                                        <?php if ( $name ) : ?>
                                            <p class="experts__name"><?php echo esc_html( $name ); ?></p>
                                        <?php endif; ?>

                                        <?php if ( $role ) : ?>
                                            <p class="experts__role"><?php echo esc_html( $role ); ?></p>
                                        <?php endif; ?>
                                    </article>
                                </div>
                            <?php endwhile; ?>

                        </div>

                        <div class="experts__pagination swiper-pagination"></div>
                    </div>

                    <div class="experts__nav experts__nav--mobile" aria-hidden="false">
                        <button
                            type="button"
                            class="experts__nav-btn experts__nav-btn--prev js-experts-prev"
                            aria-label="<?php esc_attr_e( 'Previous testimonial', 'cyberrete' ); ?>"
                        >
                            <span class="experts__nav-visual" aria-hidden="true">
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--active"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--block"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                            </span>
                        </button>
                        <button
                            type="button"
                            class="experts__nav-btn experts__nav-btn--next js-experts-next"
                            aria-label="<?php esc_attr_e( 'Next testimonial', 'cyberrete' ); ?>"
                        >
                            <span class="experts__nav-visual" aria-hidden="true">
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--active"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>"
                                    alt=""
                                    class="experts__nav-svg experts__nav-svg--block"
                                    width="32"
                                    height="32"
                                    decoding="async"
                                >
                            </span>
                        </button>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
