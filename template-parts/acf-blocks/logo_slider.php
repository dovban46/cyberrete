<section class="logo-slider">
    <div class="logo-slider__container js-animate">

        <?php if ( have_rows('logo_slider_section') ) : ?>
            <?php while ( have_rows('logo_slider_section') ) : the_row(); ?>

                <?php if ( have_rows('logo_slider_items') ) : ?>
                    <div class="logo-slider__wrapper swiper js-logo-slider">
                        <div class="logo-slider__track swiper-wrapper">

                            <?php while ( have_rows('logo_slider_items') ) : the_row();
                                $logo = get_sub_field('logo_image');
                            ?>
                                <?php if ( $logo ) : ?>
                                    <div class="logo-slider__slide swiper-slide">
                                        <div class="logo-slider__item">
                                            <img
                                                src="<?php echo esc_url( $logo['url'] ); ?>"
                                                alt="<?php echo esc_attr( $logo['alt'] ); ?>"
                                                class="logo-slider__image"
                                            >
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endwhile; ?>

                        </div>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
