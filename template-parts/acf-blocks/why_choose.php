<?php
$why_bg_url   = get_template_directory_uri() . '/assets/images/Lines2.webp';
$why_hover_url = get_template_directory_uri() . '/assets/images/hover-img.webp';
?>

<section class="why-choose">
    <div
        class="why-choose__bg"
        style="background-image: url('<?php echo esc_url( $why_bg_url ); ?>');"
        aria-hidden="true"
    ></div>

    <div class="why-choose__container js-animate">

        <?php if ( have_rows( 'why_choose_section' ) ) : ?>
            <?php while ( have_rows( 'why_choose_section' ) ) : the_row();

                $title = get_sub_field( 'why_choose_title' );
            ?>

                <?php if ( $title ) : ?>
                    <h2 class="why-choose__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( have_rows( 'why_choose_items' ) ) : ?>
                    <div class="why-choose__list">

                        <?php
                        $item_index = 0;
                        while ( have_rows( 'why_choose_items' ) ) :
                            the_row();
                            $item_index++;

                            $item_title = get_sub_field( 'item_title' );
                            $item_text  = get_sub_field( 'item_text' );
                            $number     = str_pad( (string) $item_index, 2, '0', STR_PAD_LEFT );
                        ?>
                            <article class="why-choose__card js-why-choose-card">
                                <div
                                    class="why-choose__card-hover"
                                    style="background-image: url('<?php echo esc_url( $why_hover_url ); ?>');"
                                    aria-hidden="true"
                                ></div>

                                <div class="why-choose__card-inner">
                                    <span class="why-choose__number"><?php echo esc_html( $number ); ?>.</span>

                                    <?php if ( $item_title ) : ?>
                                        <h3 class="why-choose__card-title"><?php echo esc_html( $item_title ); ?></h3>
                                    <?php endif; ?>

                                    <?php if ( $item_text ) : ?>
                                        <div class="why-choose__card-text">
                                            <?php echo wp_kses_post( $item_text ); ?>
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
