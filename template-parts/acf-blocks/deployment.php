<?php
/**
 * Flexible layout: deployment
 *
 * ACF: deployment_section
 *   - deployment_title (text)
 *   - deployment_lead (textarea / WYSIWYG)
 *   - deployment_items (repeater)
 *       - text (text) — підпис на плашці
 *   - deployment_footer (text) — нижній ряд (наприклад з символом ·)
 *
 * BEM-блок: deployment
 * Стилі — окремо (_deployment.scss).
 *
 * @package Cyberrete
 */
?>
<section class="deployment">
    <div class="deployment__container js-deployment-section">

        <?php if ( have_rows( 'deployment_section' ) ) : ?>
            <?php
            while ( have_rows( 'deployment_section' ) ) :
                the_row();

                $title  = get_sub_field( 'deployment_title' );
                $lead   = get_sub_field( 'deployment_lead' );
                $footer = get_sub_field( 'deployment_footer' );
                ?>

                <header class="deployment__header">
                    <?php if ( $title ) : ?>
                        <h2 class="deployment__title js-stagger-item"><?php echo esc_html( $title ); ?></h2>
                    <?php endif; ?>

                    <?php if ( $lead ) : ?>
                        <div class="deployment__lead js-stagger-item">
                            <?php echo wp_kses_post( wpautop( $lead ) ); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if ( have_rows( 'deployment_items' ) ) : ?>
                    <ul class="deployment__list" role="list">
                        <?php
                        while ( have_rows( 'deployment_items' ) ) :
                            the_row();
                            $item_text = get_sub_field( 'text' );
                            if ( ! $item_text ) {
                                continue;
                            }
                            ?>
                            <li class="deployment__item js-stagger-item">
                                <span class="deployment__item-text"><?php echo esc_html( $item_text ); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $footer ) : ?>
                    <p class="deployment__footer js-stagger-item"><?php echo esc_html( $footer ); ?></p>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
