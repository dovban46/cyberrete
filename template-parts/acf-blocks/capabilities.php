<section class="capabilities">
    <div class="capabilities__container js-animate">

        <?php if ( have_rows('capabilities_section') ) : ?>
            <?php while ( have_rows('capabilities_section') ) : the_row();

                $title = get_sub_field('capabilities_title');
                $desc  = get_sub_field('capabilities_description');
            ?>

                <div class="capabilities__header">
                    <?php if ( $title ) : ?>
                        <h2 class="capabilities__title js-stagger-item"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $desc ) : ?>
                        <div class="capabilities__description js-stagger-item">
                            <p><?php echo esc_html( $desc ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( have_rows('capabilities_items') ) : ?>
                    <div class="capabilities__list">

                        <?php while ( have_rows('capabilities_items') ) : the_row();
                            $icon = get_sub_field('icon');
                            $text = get_sub_field('text');
                        ?>
                            <div class="capabilities__item js-stagger-item">
                                <?php if ( $icon ) : ?>
                                    <div class="capabilities__icon-wrap">
                                        <img
                                            src="<?php echo esc_url( $icon['url'] ); ?>"
                                            alt="<?php echo esc_attr( $icon['alt'] ); ?>"
                                            class="capabilities__icon"
                                        >
                                    </div>
                                <?php endif; ?>

                                <?php if ( $text ) : ?>
                                    <div class="capabilities__text">
                                        <p><?php echo esc_html( $text ); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>

                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
