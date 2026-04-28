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
                                $text_link  = get_sub_field('text');
                                $item_url   = '';
                                $item_title = '';
                                $item_target = '_self';

                                if ( is_array( $text_link ) ) {
                                    $item_url    = isset( $text_link['url'] ) ? trim( (string) $text_link['url'] ) : '';
                                    $item_title  = isset( $text_link['title'] ) ? trim( (string) $text_link['title'] ) : '';
                                    $item_target = ! empty( $text_link['target'] ) ? (string) $text_link['target'] : '_self';
                                } elseif ( is_string( $text_link ) ) {
                                    $item_title = trim( $text_link );
                                }

                                $item_title_html = wp_kses_post(
                                    html_entity_decode( (string) $item_title, ENT_QUOTES | ENT_HTML5, 'UTF-8' )
                                );
                            ?>
                                <?php if ( $item_title ) : ?>
                                    <?php if ( $item_url ) : ?>
                                        <a
                                            href="<?php echo esc_url( $item_url ); ?>"
                                            target="<?php echo esc_attr( $item_target ); ?>"
                                            class="use-cases__item js-use-cases-item"
                                        >
                                            <h3 class="use-cases__item-text"><?php echo $item_title_html; ?></h3>
                                        </a>
                                    <?php else : ?>
                                        <div class="use-cases__item js-use-cases-item">
                                            <h3 class="use-cases__item-text"><?php echo $item_title_html; ?></h3>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
