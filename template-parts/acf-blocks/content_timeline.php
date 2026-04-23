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

if ( ! function_exists( 'cyberrete_content_timeline_title_html' ) ) {
	/**
	 * Highlight 4th and 5th words in title.
	 *
	 * @param string $title Raw title.
	 * @return string Safe HTML.
	 */
	function cyberrete_content_timeline_title_html( $title ) {
		$title = wp_strip_all_tags( (string) $title );
		$words = preg_split( '/\s+/u', trim( $title ), -1, PREG_SPLIT_NO_EMPTY );

		if ( empty( $words ) ) {
			return '';
		}

		$html_words = array();
		foreach ( $words as $index => $word ) {
			$word_number = $index + 1;
			if ( 4 === $word_number || 5 === $word_number ) {
				$html_words[] = '<span class="content-timeline__title-gradient">' . esc_html( $word ) . '</span>';
			} else {
				$html_words[] = esc_html( $word );
			}
		}

		return implode( ' ', $html_words );
	}
}

$queried_id             = (int) get_queried_object_id();
$queried_slug           = $queried_id ? (string) get_post_field( 'post_name', $queried_id ) : '';
$is_technology_context  = is_page( 'technology' ) || is_page_template( 'page-technology.php') || ( '' !== $queried_slug && false !== strpos( $queried_slug, 'technology' ) );
$section_modifier_class = $is_technology_context ? ' content-timeline--technology' : '';
?>
<section class="content-timeline<?php echo esc_attr( $section_modifier_class ); ?>">
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
                            <h2 class="content-timeline__title js-stagger-item">
                                <?php
                                echo wp_kses(
                                    cyberrete_content_timeline_title_html( $title ),
                                    array(
                                        'span' => array(
                                            'class' => true,
                                        ),
                                    )
                                );
                                ?>
                            </h2>
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
