<?php
/**
 * Flexible layout: about_page_team
 *
 * ACF group: about_page_team_section
 *  - about_page_team_title
 *  - about_page_team_text
 *  - about_page_team_members (repeater)
 *      - member_image
 *      - member_name
 *      - member_position
 *      - member_link
 *      - member_text
 *
 * @package Cyberrete
 */

$section = get_sub_field( 'about_page_team_section' );
if ( ! is_array( $section ) ) {
	return;
}

$title   = isset( $section['about_page_team_title'] ) ? trim( (string) $section['about_page_team_title'] ) : '';
$text    = isset( $section['about_page_team_text'] ) ? $section['about_page_team_text'] : '';
$members = isset( $section['about_page_team_members'] ) && is_array( $section['about_page_team_members'] ) ? $section['about_page_team_members'] : array();
$has_text = '' !== trim( wp_strip_all_tags( (string) $text ) );

if ( '' === $title && ! $has_text && empty( $members ) ) {
	return;
}
?>

<section class="about-page-team">
	<div class="about-page-team__container js-animate">
		<div class="about-page-team__top">
			<div class="about-page-team__intro<?php echo $has_text ? ' about-page-team__intro--has-text' : ''; ?>">
				<?php if ( '' !== $title ) : ?>
					<h2 class="about-page-team__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $has_text ) : ?>
					<div class="about-page-team__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $members ) ) : ?>
				<div class="about-page-team__nav about-page-team__nav--desktop" aria-hidden="false">
					<button type="button" class="about-page-team__nav-btn about-page-team__nav-btn--prev js-about-team-prev" aria-label="<?php esc_attr_e( 'Previous team members', 'cyberrete' ); ?>">
						<span class="about-page-team__nav-visual" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--active" width="32" height="32" decoding="async">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--block" width="32" height="32" decoding="async">
						</span>
					</button>
					<button type="button" class="about-page-team__nav-btn about-page-team__nav-btn--next js-about-team-next" aria-label="<?php esc_attr_e( 'Next team members', 'cyberrete' ); ?>">
						<span class="about-page-team__nav-visual" aria-hidden="true">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--active" width="32" height="32" decoding="async">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--block" width="32" height="32" decoding="async">
						</span>
					</button>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $members ) ) : ?>
			<div class="about-page-team__slider swiper js-about-team-slider">
				<div class="about-page-team__track swiper-wrapper">
					<?php foreach ( $members as $index => $member ) : ?>
						<?php
						$image        = function_exists( 'cyberrete_acf_resolved_image' ) ? cyberrete_acf_resolved_image( isset( $member['member_image'] ) ? $member['member_image'] : null ) : null;
						$image_url    = ( $image && ! empty( $image['url'] ) ) ? $image['url'] : '';
						$image_alt    = ( $image && isset( $image['alt'] ) ) ? $image['alt'] : '';
						$name         = isset( $member['member_name'] ) ? trim( (string) $member['member_name'] ) : '';
						$position     = isset( $member['member_position'] ) ? trim( (string) $member['member_position'] ) : '';
						$member_text  = isset( $member['member_text'] ) ? $member['member_text'] : '';
						$hover_text   = trim( wp_strip_all_tags( (string) $member_text ) );
						$member_link  = isset( $member['member_link'] ) ? $member['member_link'] : null;
						$link_url     = '';
						$link_title   = '';
						$link_target  = '_self';
						$card_classes = 'about-page-team__card';

						if ( 1 === ( ( $index + 1 ) % 2 ) ) {
							$card_classes .= ' about-page-team__card--odd';
						} else {
							$card_classes .= ' about-page-team__card--even';
						}

						if ( is_array( $member_link ) ) {
							$link_url    = isset( $member_link['url'] ) ? (string) $member_link['url'] : '';
							$link_title  = isset( $member_link['title'] ) ? trim( (string) $member_link['title'] ) : '';
							$link_target = ! empty( $member_link['target'] ) ? (string) $member_link['target'] : '_self';
						} elseif ( is_string( $member_link ) ) {
							$link_url = trim( $member_link );
						}

						if ( '' === $link_title ) {
							$link_title = $link_url ? $link_url : __( 'Profile link', 'cyberrete' );
						}

						if ( '' === $image_url && '' === $name && '' === $position && '' === $hover_text && '' === $link_url ) {
							continue;
						}
						?>
						<div class="about-page-team__slide swiper-slide">
							<article class="<?php echo esc_attr( $card_classes ); ?>">
								<div class="about-page-team__media">
									<div class="about-page-team__media-flip">
										<div class="about-page-team__media-face about-page-team__media-face--front">
											<?php if ( '' !== $image_url ) : ?>
												<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="about-page-team__image" loading="lazy" decoding="async">
											<?php endif; ?>
										</div>
										<div class="about-page-team__media-face about-page-team__media-face--back">
											<?php if ( '' !== $link_url ) : ?>
												<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="about-page-team__hover-link"><?php echo esc_html( $link_title ); ?></a>
											<?php endif; ?>
											<?php if ( '' !== $hover_text ) : ?>
												<div class="about-page-team__hover-text"><?php echo wp_kses_post( wpautop( $member_text ) ); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<div class="about-page-team__meta">
									<?php if ( 1 === ( ( $index + 1 ) % 2 ) ) : ?>
										<?php if ( '' !== $name ) : ?>
											<h3 class="about-page-team__name"><?php echo esc_html( $name ); ?></h3>
										<?php endif; ?>
										<?php if ( '' !== $position ) : ?>
											<p class="about-page-team__position"><?php echo esc_html( $position ); ?></p>
										<?php endif; ?>
									<?php else : ?>
										<?php if ( '' !== $position ) : ?>
											<p class="about-page-team__position"><?php echo esc_html( $position ); ?></p>
										<?php endif; ?>
										<?php if ( '' !== $name ) : ?>
											<h3 class="about-page-team__name"><?php echo esc_html( $name ); ?></h3>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="about-page-team__pagination swiper-pagination"></div>
			</div>

			<div class="about-page-team__nav about-page-team__nav--mobile" aria-hidden="false">
				<button type="button" class="about-page-team__nav-btn about-page-team__nav-btn--prev js-about-team-prev" aria-label="<?php esc_attr_e( 'Previous team members', 'cyberrete' ); ?>">
					<span class="about-page-team__nav-visual" aria-hidden="true">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--active" width="32" height="32" decoding="async">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--block" width="32" height="32" decoding="async">
					</span>
				</button>
				<button type="button" class="about-page-team__nav-btn about-page-team__nav-btn--next js-about-team-next" aria-label="<?php esc_attr_e( 'Next team members', 'cyberrete' ); ?>">
					<span class="about-page-team__nav-visual" aria-hidden="true">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-active.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--active" width="32" height="32" decoding="async">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-block.svg' ); ?>" alt="" class="about-page-team__nav-svg about-page-team__nav-svg--block" width="32" height="32" decoding="async">
					</span>
				</button>
			</div>
		<?php endif; ?>
	</div>
</section>
