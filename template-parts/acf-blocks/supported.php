<section class="supported-by">
    <div class="supported-by__container">

        <?php if ( have_rows('supported_by') ) : ?>
            <?php while ( have_rows('supported_by') ) : the_row(); 
                
                $title = get_sub_field('supported_title');
                $title_mobile = get_sub_field('supported_title_mobile');
            ?>

                <?php if ( $title ) : ?>
                    <h2 class="supported-by__title js-animate"><?php echo esc_html( $title ); ?>:</h2>
                <?php endif; ?>
                
                <?php if ( $title_mobile ) : ?>
                    <p class="supported-by__title-mobile js-animate"><?php echo esc_html( $title_mobile ); ?>:</p>
                <?php endif; ?>

                <?php if ( have_rows('supporters') ) : ?>
                    <div class="supported-by__list">
                        
                        <?php while ( have_rows('supporters') ) : the_row(); 
                            $image = get_sub_field('image');
                            $link  = get_sub_field('link');
                        ?>
                            
                            <div class="supported-by__item js-animate">
                                <?php if ( $link ) : 
                                    $link_url    = is_array($link) ? $link['url'] : $link;
                                    $link_target = is_array($link) && $link['target'] ? $link['target'] : '_self';
                                ?>
                                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="supported-by__link">
                                        <div class="supported-by__logo-box">
                                            <?php if ( $image ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="supported-by__image">
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <div class="supported-by__logo-box">
                                        <?php if ( $image ) : ?>
                                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="supported-by__image">
                                        <?php endif; ?>
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