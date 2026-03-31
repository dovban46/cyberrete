<section class="solutions">
    <div class="solutions__container js-animate">

        <?php if ( have_rows('solutions_section') ) : ?>
            <?php while ( have_rows('solutions_section') ) : the_row(); 
                
                $title = get_sub_field('solutions_title');
                $desc  = get_sub_field('solutions_description');
            ?>

                <div class="solutions__header">
                    <?php if ( $title ) : ?>
                        <h2 class="solutions__title"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <div class="solutions__container-description">
                        <?php if ( $desc ) : ?>
                            <div class="solutions__description">
                                <p><?php echo esc_html( $desc ); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( have_rows('solutions_cards') ) : ?>
                    <div class="solutions__grid">
                        
                        <?php while ( have_rows('solutions_cards') ) : the_row(); 
                            $image = get_sub_field('card_image');
                            $title = get_sub_field('card_title');
                            $link  = get_sub_field('card_link');
                        ?>
                            
                            <div class="solutions__card js-animate">
                                <?php if ( $image ) : ?>
                                    <div class="solutions__card-bg">
                                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="solutions__card-img">
                                        <div class="solutions__card-overlay"></div>
                                    </div>
                                <?php endif; ?>

                                <div class="solutions__card-content">
                                    <?php if ( $title ) : ?>
                                        <h3 class="solutions__card-title"><?php echo esc_html( $title ); ?></h3>
                                    <?php endif; ?>

                                    <?php if ( $link ) : 
                                        $link_url    = $link['url'];
                                        $link_title  = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="solutions__btn">
                                            <?php echo esc_html( $link_title ); ?>
                                        </a>
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