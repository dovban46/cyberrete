<?php
/**
 * Flexible layout: workflow_comparison
 *
 * ACF: workflow_comparison_section
 *   - workflow_comparison_title (text)
 *   - workflow_comparison_groups (repeater)
 *       - group_heading (text)
 *       - group_points (repeater)
 *           - point_text (text)
 *   - workflow_comparison_footer (text / textarea)
 *   - workflow_comparison_button (link)
 *   - workflow_comparison_image (image)
 *
 * BEM-блок: workflow-comparison
 * Стилі — окремо (_workflow-comparison.scss).
 * Іконка: Check.svg у workflow-comparison__point-icon-wrap (20×20), img.workflow-comparison__point-icon (10×10).
 *
 * @package Cyberrete
 */

$workflow_comparison_check_url = get_template_directory_uri() . '/assets/images/Check.svg';
?>
<section class="workflow-comparison">
    <div class="workflow-comparison__container js-workflow-comparison-section">

        <?php if ( have_rows( 'workflow_comparison_section' ) ) : ?>
            <?php
            while ( have_rows( 'workflow_comparison_section' ) ) :
                the_row();

                $title  = get_sub_field( 'workflow_comparison_title' );
                $footer = get_sub_field( 'workflow_comparison_footer' );
                $button = get_sub_field( 'workflow_comparison_button' );
                $image  = get_sub_field( 'workflow_comparison_image' );
                ?>

                <?php if ( $title ) : ?>
                    <header class="workflow-comparison__header">
                        <h2 class="workflow-comparison__title js-stagger-item"><?php echo esc_html( $title ); ?></h2>
                    </header>
                <?php endif; ?>

                <div class="workflow-comparison__layout">
                    <div class="workflow-comparison__content">

                        <?php if ( have_rows( 'workflow_comparison_groups' ) ) : ?>
                            <div class="workflow-comparison__groups">
                                <?php
                                while ( have_rows( 'workflow_comparison_groups' ) ) :
                                    the_row();

                                    $group_heading = get_sub_field( 'group_heading' );
                                    ?>
                                    <div class="workflow-comparison__group js-stagger-item">
                                        <?php if ( $group_heading ) : ?>
                                            <h3 class="workflow-comparison__group-heading"><?php echo esc_html( $group_heading ); ?></h3>
                                        <?php endif; ?>

                                        <?php if ( have_rows( 'group_points' ) ) : ?>
                                            <ul class="workflow-comparison__points" role="list">
                                                <?php
                                                while ( have_rows( 'group_points' ) ) :
                                                    the_row();
                                                    $point_text = get_sub_field( 'point_text' );
                                                    if ( ! $point_text ) {
                                                        continue;
                                                    }
                                                    ?>
                                                    <li class="workflow-comparison__point">
                                                        <span class="workflow-comparison__point-icon-wrap" aria-hidden="true">
                                                            <img
                                                                src="<?php echo esc_url( $workflow_comparison_check_url ); ?>"
                                                                alt=""
                                                                class="workflow-comparison__point-icon"
                                                                width="10"
                                                                height="10"
                                                                loading="lazy"
                                                                decoding="async"
                                                            >
                                                        </span>
                                                        <span class="workflow-comparison__point-text"><?php echo esc_html( $point_text ); ?></span>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $footer || ( $button && ! empty( $button['url'] ) ) ) : ?>
                            <div class="workflow-comparison__footer js-stagger-item">
                                <?php if ( $footer ) : ?>
                                    <p class="workflow-comparison__footer-text"><?php echo esc_html( $footer ); ?></p>
                                <?php endif; ?>

                                <?php if ( $button && ! empty( $button['url'] ) ) : ?>
                                    <?php
                                    $btn_url    = $button['url'];
                                    $btn_title  = ! empty( $button['title'] ) ? $button['title'] : __( 'Learn more', 'cyberrete' );
                                    $btn_target = ! empty( $button['target'] ) ? $button['target'] : '_self';
                                    ?>
                                    <a
                                        href="<?php echo esc_url( $btn_url ); ?>"
                                        class="workflow-comparison__button"
                                        target="<?php echo esc_attr( $btn_target ); ?>"
                                        <?php echo '_blank' === $btn_target ? ' rel="noopener noreferrer"' : ''; ?>
                                    >
                                        <?php echo esc_html( $btn_title ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php if ( $image && ! empty( $image['url'] ) ) : ?>
                        <div class="workflow-comparison__media js-stagger-item">
                            <figure class="workflow-comparison__figure">
                                <img
                                    src="<?php echo esc_url( $image['url'] ); ?>"
                                    alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                    class="workflow-comparison__image"
                                    loading="lazy"
                                    decoding="async"
                                    <?php if ( ! empty( $image['width'] ) && ! empty( $image['height'] ) ) : ?>
                                        width="<?php echo (int) $image['width']; ?>"
                                        height="<?php echo (int) $image['height']; ?>"
                                    <?php endif; ?>
                                >
                            </figure>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
