<section class="use-cases">
    <div class="use-cases__container js-animate">

        <?php if ( have_rows('use_cases_section') ) : ?>
            <?php while ( have_rows('use_cases_section') ) : the_row();

                $background = get_sub_field('use_cases_background');
                $title      = get_sub_field('use_cases_title');
            ?>

                <?php if ( $background ) : ?>
                    <div class="use-cases__bg">
                        <img
                            src="<?php echo esc_url( $background['url'] ); ?>"
                            alt="<?php echo esc_attr( $background['alt'] ); ?>"
                            class="use-cases__bg-image"
                        >
                    </div>
                <?php endif; ?>

                <div class="use-cases__content">
                    <?php if ( $title ) : ?>
                        <h2 class="use-cases__title"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( have_rows('use_cases_items') ) : ?>
                        <div class="use-cases__list">
                            <?php while ( have_rows('use_cases_items') ) : the_row();
                                $text = get_sub_field('text');
                            ?>
                                <?php if ( $text ) : ?>
                                    <div class="use-cases__item js-use-cases-item">
                                        <h3 class="use-cases__item-text"><?php echo wp_kses_post( $text ); ?></h3>
                                    </div>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
