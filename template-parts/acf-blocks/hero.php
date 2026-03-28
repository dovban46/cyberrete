<section class="hero">
    <div class="hero__container">

        <?php if ( have_rows('hero_banner') ) : ?>
            <?php while ( have_rows('hero_banner') ) : the_row(); 
                $title       = get_sub_field('hero_title');
                $description = get_sub_field('hero_description');
                $button      = get_sub_field('hero_button');
                $poster      = get_sub_field('hero_video_poster');
                $video_url   = get_sub_field('hero_video'); 
            ?>

                <div class="hero__content">
                    <?php if ( $title ) : ?>
                        <h1 class="hero__title js-animate"><?php echo esc_html( $title ); ?></h1>
                    <?php endif; ?>

                    <?php if ( $description ) : ?>
                        <div class="hero__description js-animate">
                            <p><?php echo esc_html( $description ); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ( $button ) : 
                        $btn_url    = $button['url'];
                        $btn_title  = $button['title'];
                        $btn_target = $button['target'] ? $button['target'] : '_self';
                    ?>
                        <div class="hero__action">
                            <a href="<?php echo esc_url( $btn_url ); ?>" target="<?php echo esc_attr( $btn_target ); ?>" class="hero__btn btn js-animate">
                                <?php echo esc_html( $btn_title ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="hero__media">
                    <div class="hero__video-wrapper">
                        <?php if ( $video_url ) : ?>
                            <video 
                                class="hero__video" 
                                src="<?php echo esc_url( $video_url ); ?>" 
                                <?php if ( $poster ) : ?>poster="<?php echo esc_url( $poster['url'] ); ?>"<?php endif; ?>
                                autoplay muted loop playsinline>
                            </video>
                            <button class="hero__play-btn" aria-label="Play video">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/video-play.svg' ); ?>" alt="Play" class="hero__play-icon">
                            </button>
                        <?php elseif ( $poster ) : ?>
                            <img src="<?php echo esc_url( $poster['url'] ); ?>" alt="<?php echo esc_attr( $poster['alt'] ); ?>" class="hero__image">
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>