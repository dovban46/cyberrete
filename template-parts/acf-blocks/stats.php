<section class="stats">
    <div class="stats__container js-animate">
        
        <?php if ( have_rows('stats_section') ) : ?>
            <?php while ( have_rows('stats_section') ) : the_row(); 
                
                $title = get_sub_field('stats_title');
                $desc  = get_sub_field('stats_description');
            ?>

                <div class="stats__header">
                    <?php if ( $title ) : ?>
                        <h2 class="stats__title"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $desc ) : ?>
                        <div class="stats__description">
                            <p><?php echo esc_html( $desc ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( have_rows('stats_cards') ) : ?>
                    <div class="stats__grid">
                        
                        <?php while ( have_rows('stats_cards') ) : the_row(); 
                            $card_text = get_sub_field('card_text');
                            $prefix    = get_sub_field('stat_prefix');
                            $number    = get_sub_field('stat_number');
                            $suffix    = get_sub_field('stat_suffix');
                        ?>
                            
                            <div class="stats__card">
                                <?php if ( $card_text ) : ?>
                                    <p class="stats__card-text"><?php echo esc_html( $card_text ); ?></p>
                                <?php endif; ?>

                                <div class="stats__value">
                                    <?php if ( $prefix ) : ?>
                                        <span class="stats__prefix"><?php echo esc_html( $prefix ); ?>&nbsp;</span>
                                    <?php endif; ?>

                                    <?php if ( $number ) : ?>
                                        <span class="stats__number js-counter" data-target="<?php echo esc_attr( $number ); ?>">0</span>
                                    <?php endif; ?>

                                    <?php if ( $suffix ) : ?>
                                        <span class="stats__suffix"><?php echo esc_html( $suffix ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endwhile; ?>

                    </div>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>