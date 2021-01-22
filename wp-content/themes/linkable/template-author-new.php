<?php
/**
 * Template Name: New Author Page
 */
get_header();
?>
    <div id="main-content">
		<?php
		while ( have_posts() ) : the_post();

			if ( have_rows( 'author_page_fields' ) ):
				while ( have_rows( 'author_page_fields' ) ) : the_row();
					?>

					<?php if ( get_row_layout() == 'author_banner_section' ) : ?>

                        <div class="author-page-banner la-section"
                             style="background-image: url(<?php echo get_sub_field( 'banner_image' )['url']; ?>), linear-gradient(230deg, rgba(234, 234, 234, 0) 30%, rgba(117, 117, 117, .5) 130%);">
                            <div class="la-container">
                                <div class="la-row">
                                    <div class="banner-content">
                                        <h1 class="section-title"><?php the_sub_field( 'title' ); ?></h1>
                                        <div class="subtitle"><?php the_sub_field( 'subtitle' ); ?></div>
                                        <div class="btn-wrap">
                                            <a class="banner-btn"
                                               href="<?php echo get_sub_field( 'button' )['url'] ?>">
												<?php echo get_sub_field( 'button' )['title'] ?>
                                                <span class="fa"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

					<?php elseif ( get_row_layout() == 'how_it_works' ) : ?>

                        <div class="la-section how-it-works-steps">
                            <div class="la-container">
                                <h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
                            </div>
                            <div class="la-container">
                                <div class="la-row steps-with-count">
									<?php while ( have_rows( 'steps_with_count' ) ) : the_row(); ?>
                                        <div class="step-with-count">
                                            <span class="top-count"><?php the_sub_field( 'count' ); ?></span>
                                            <h4><?php the_sub_field( 'title' ); ?></h4>
                                            <div class="details"><?php the_sub_field( 'details' ); ?></div>
                                        </div>
									<?php endwhile; ?>
                                </div>
                            </div>
                        </div>

					<?php elseif ( get_row_layout() == 'how_much_can_you_earn' ) : ?>

                        <div class="la-section how-much-earn">
                            <div class="la-container">
                                <h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
                                <p class="subtitle"><?php the_sub_field( 'subtitle' ); ?></p>
                            </div>
                            <div class="la-container">
                                <div class="la-row earn-prices">
									<?php while ( have_rows( 'prices' ) ) : the_row(); ?>
                                        <div class="earn-price earn-price-1">
                                            <h4><?php the_sub_field( 'price_1' ); ?></h4>
                                            <p><?php the_sub_field( 'details_1' ); ?></p>
                                        </div>
                                        <div class="earn-price earn-price-2">
                                            <h4><?php the_sub_field( 'price_2' ); ?></h4>
                                            <p><?php the_sub_field( 'details_2' ); ?></p>
                                        </div>
                                        <div class="earn-price earn-price-3">
                                            <h4><?php the_sub_field( 'price_3' ); ?></h4>
                                            <p><?php the_sub_field( 'details_3' ); ?></p>
                                        </div>
									<?php endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <?php elseif ( get_row_layout() == 'how_it_works_author' ) : ?>

                            <div class="la-section how-it-works-steps author-hiws">
                                <div class="la-container">
                                    <h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
                                </div>
                                <div class="la-container">
                                    <div class="la-row steps-with-count owl-carousel" id="author-steps-with-count">
                                        <?php while ( have_rows( 'steps_with_count' ) ) : the_row(); ?>
                                            <div class="step-with-count">
                                                <span class="top-count"><?php the_sub_field( 'count' ); ?></span>
                                                <h4><?php the_sub_field( 'title' ); ?></h4>
                                                <div class="details"><?php the_sub_field( 'details' ); ?></div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>

					<?php elseif ( get_row_layout() == 'sign_up_section' ) : ?>

                        <div class="la-section sign-up-section"
                             style="background-image: url(<?php the_sub_field( 'background' ); ?>)">
                            <div class="la-container">
                                <p class="section-title"><?php the_sub_field( 'section_title' ); ?></p>
                                <div class="subtitle"><?php the_sub_field( 'subtitle' ); ?></div>
                                <div class="btn-wrap">
                                    <a class="btn-light la-btn" href="<?php echo get_sub_field( 'button' )['url'] ?>">
										<?php echo get_sub_field( 'button' )['title'] ?> <span class="fa"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

					<?php
					endif;

				endwhile;
			endif;

		endwhile;
		?>
    </div>
<?php

get_footer();