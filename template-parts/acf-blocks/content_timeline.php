<?php
/**
 * Flexible layout: content_timeline
 *
 * ACF: content_timeline_section
 *   - content_timeline_title (text)
 *   - content_timeline_intro (textarea / WYSIWYG)
 *   - content_timeline_items (repeater)
 *       - item_title (text)
 *       - item_text (textarea / WYSIWYG)
 *
 * BEM-блок: content-timeline
 * Трек: content-timeline__track + content-timeline__rail (вертикальна лінія).
 * Стилі — _content-timeline.scss; лінія: js-content-timeline-rail + геометрія в main.js; кроки — js-content-timeline-step.
 *
 * @package Cyberrete
 */
?>
<section class="content-timeline">
    <div class="content-timeline__container js-content-timeline-section">

        <?php if ( have_rows( 'content_timeline_section' ) ) : ?>
            <?php
            while ( have_rows( 'content_timeline_section' ) ) :
                the_row();

                $title = get_sub_field( 'content_timeline_title' );
                $intro = get_sub_field( 'content_timeline_intro' );
                ?>

                <div class="content-timeline__layout">
                    <div class="content-timeline__intro">
                        <?php if ( $title ) : ?>
                            <h2 class="content-timeline__title js-stagger-item"><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>

                        <?php if ( $intro ) : ?>
                            <div class="content-timeline__lead js-stagger-item">
                                <?php echo wp_kses_post( wpautop( $intro ) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( have_rows( 'content_timeline_items' ) ) : ?>
                        <div class="content-timeline__main">
                            <div class="content-timeline__track js-content-timeline-track">
                                <span class="content-timeline__rail js-content-timeline-rail" aria-hidden="true"></span>
                                <ol class="content-timeline__list" role="list">
                                <?php
                                $step_index = 0;
                                while ( have_rows( 'content_timeline_items' ) ) :
                                    the_row();
                                    $step_index++;

                                    $item_title = get_sub_field( 'item_title' );
                                    $item_text  = get_sub_field( 'item_text' );

                                    if ( ! $item_title && ! $item_text ) {
                                        continue;
                                    }

                                    $align_mod = ( 0 === $step_index % 2 )
                                        ? 'content-timeline__item--right'
                                        : 'content-timeline__item--left';
                                    ?>
                                    <li class="content-timeline__item <?php echo esc_attr( $align_mod ); ?> js-content-timeline-step">
                                        <span class="content-timeline__node" aria-hidden="true"></span>
                                        <div class="content-timeline__item-inner">
                                            <?php if ( $item_title ) : ?>
                                                <h3 class="content-timeline__item-title"><?php echo esc_html( $item_title ); ?></h3>
                                            <?php endif; ?>

                                            <?php if ( $item_text ) : ?>
                                                <div class="content-timeline__item-text">
                                                    <?php echo wp_kses_post( wpautop( $item_text ) ); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                                </ol>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
