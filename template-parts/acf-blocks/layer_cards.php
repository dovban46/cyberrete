<?php
/**
 * Flexible layout: layer_cards
 *
 * ACF: layer_cards_section
 *   - layer_cards_title (text)
 *   - layer_cards_items (repeater)
 *       - card_image (image)
 *       - card_title (text)
 *       - card_text (textarea / WYSIWYG)
 *
 * BEM-блок: layer-cards
 * Сітка layer-cards__grid: будь-яка кількість карток — у стилях вирівнювання по центру (flex/grid + wrap).
 * Контейнер: js-animate (IntersectionObserver у main.js → is-visible).
 * Стилі — _layer-cards.scss.
 *
 * @package Cyberrete
 */
?>
<section class="layer-cards">
    <div class="layer-cards__container js-animate">

        <?php if ( have_rows( 'layer_cards_section' ) ) : ?>
            <?php
            while ( have_rows( 'layer_cards_section' ) ) :
                the_row();

                $section_title = get_sub_field( 'layer_cards_title' );
                ?>

                <?php if ( $section_title ) : ?>
                    <header class="layer-cards__header">
                        <h2 class="layer-cards__title"><?php echo esc_html( $section_title ); ?></h2>
                    </header>
                <?php endif; ?>

                <?php if ( have_rows( 'layer_cards_items' ) ) : ?>
                    <div class="layer-cards__grid" role="list">
                        <?php
                        while ( have_rows( 'layer_cards_items' ) ) :
                            the_row();

                            $card_image = get_sub_field( 'card_image' );
                            $card_title = get_sub_field( 'card_title' );
                            $card_text  = get_sub_field( 'card_text' );

                            if ( ! $card_image && ! $card_title && ! $card_text ) {
                                continue;
                            }
                            ?>
                            <article class="layer-cards__card" role="listitem">
                                <?php if ( $card_image && ! empty( $card_image['url'] ) ) : ?>
                                    <div class="layer-cards__media">
                                        <img
                                            src="<?php echo esc_url( $card_image['url'] ); ?>"
                                            alt="<?php echo esc_attr( $card_image['alt'] ); ?>"
                                            class="layer-cards__image"
                                            loading="lazy"
                                            decoding="async"
                                            <?php if ( ! empty( $card_image['width'] ) && ! empty( $card_image['height'] ) ) : ?>
                                                width="<?php echo (int) $card_image['width']; ?>"
                                                height="<?php echo (int) $card_image['height']; ?>"
                                            <?php endif; ?>
                                        >
                                        <div class="layer-cards__overlay" aria-hidden="true"></div>
                                    </div>
                                <?php endif; ?>

                                <div class="layer-cards__body">
                                    <?php if ( $card_title ) : ?>
                                        <h3 class="layer-cards__card-title"><?php echo esc_html( $card_title ); ?></h3>
                                    <?php endif; ?>

                                    <?php if ( $card_text ) : ?>
                                        <div class="layer-cards__card-text">
                                            <?php echo wp_kses_post( wpautop( $card_text ) ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
