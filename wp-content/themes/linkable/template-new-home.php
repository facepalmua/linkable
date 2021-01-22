<?php
/**
 * Template Name: New Home Page
 */
get_header();
?>
    <div id="main-content">
		<?php
		while ( have_posts() ) : the_post();

			if ( have_rows( 'home_page_fields' ) ):
				while ( have_rows( 'home_page_fields' ) ) : the_row();
					?>

					<?php if ( get_row_layout() == 'home_banner_section' ) : ?>

                        <div class="home-page-banner la-section">
                            <div class="banner-green-shape">
                                <img src="<?php echo get_sub_field( 'banner_shape' )['url']; ?>"
                                     alt="<?php echo get_sub_field( 'banner_shape' )['title']; ?>">
                            </div>
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
                                    <div class="banner-author">
                                        <div class="author-img">
                                            <img src="<?php echo get_sub_field( 'author_image' )['url'] ?>"
                                                 alt="<?php echo get_sub_field( 'author_image' )['title'] ?>"/>
                                        </div>
                                        <div class="author-details">
                                            <h4><?php the_sub_field( 'author_name' ); ?></h4>
                                            <p><?php the_sub_field( 'author_info' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

          <?php elseif ( get_row_layout() == 'home_second_banner' ) : ?>

            <div class="home-second-banner la-section">
              <img class="home-scnd-banner-bg" src="<?php echo get_stylesheet_directory_uri(); ?>/images/claim.svg" alt="">
                <div class="la-container">
                    <div class="la-row">
                      <h1>
                        <?php echo get_sub_field('title'); ?>
                      </h1>
                      <div class="subtitle">
                        <?php echo get_sub_field('subtitle'); ?>
                      </div>
                      <div class="buttons">
                        <?php
                        $buttons = get_sub_field('buttons');
                        foreach ($buttons as $button): ?>
                          <a class="home-scnd-btn arrow_right" href="<?php echo $button['button_link']; ?>">
                            <?php echo $button['button_title']; ?><span class="fa"><?php echo $button['button_icon']; ?></span>
                          </a>
                        <?php
                        endforeach; ?>
                        <!-- chevron-circle-down -->
                      </div>
                    </div>
                </div>
            </div>

					<?php elseif ( get_row_layout() == 'elite_authors_section' ) : ?>

                        <div class="la-section elite-author-section">
                            <div class="la-container">
                                <div class="la-row">
                                    <div class="elite-author-logos">
                                        <div class="elite-author-text">
                                            <h4><?php the_sub_field( 'left_title' ); ?></h4>
                                            <p><?php the_sub_field( 'left_subtitle' ); ?></p>
                                        </div>
                                        <?php if(wp_is_mobile()) { ?>
                                          <div class="elite-authors-logos-wrap owl-carousel owl-theme">
                                            <?php while ( have_rows( 'elite_authors' ) ) : the_row(); ?>
                                                  <img src="<?php echo get_sub_field( 'author_logo' )['url'] ?>"
                                                      alt="<?php echo get_sub_field( 'author_logo' )['title'] ?>"/>
                                            <?php endwhile; ?>
                                          </div>
                                        <?php } else { ?>
                                            <?php while ( have_rows( 'elite_authors' ) ) : the_row(); ?>
                                              <div class="elite-logo">
                                                  <img src="<?php echo get_sub_field( 'author_logo' )['url'] ?>"
                                                      alt="<?php echo get_sub_field( 'author_logo' )['title'] ?>"/>
                                              </div>
                                            <?php endwhile; ?>
                                          </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

					<?php elseif ( get_row_layout() == 'how_it_works_section' ) : ?>

                        <div class="la-section how-it-works">
                            <div class="la-container">
                                <h2 class="section-title"><?php the_sub_field( 'section_title' ); ?></h2>
                            </div>
							<?php
							$row_count = 0;
							while ( have_rows( 'how_it_works_-_row' ) ) : the_row();
								?>
                                <div class="hiw-row <?php echo( $row_count % 2 == 0 ? 'even-row' : 'odd-row' ) ?>">
                                    <div class="la-container-ie">
                                        <div class="la-row">
                                            <div class="placeholder-img">
                                                <img src="<?php echo get_sub_field( 'placeholder_image' )['url'] ?>"
                                                     alt="<?php echo get_sub_field( 'placeholder_image' )['title'] ?>">
                                            </div>
                                            <div class="hiw-content">
                                                <h3><?php the_sub_field( 'title' ); ?></h3>
                                                <div class="details"><?php the_sub_field( 'details' ); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php
								$row_count ++;
							endwhile;
							?>
                        </div>

					<?php elseif ( get_row_layout() == 'section_with_icon_box' ) : ?>

                        <div class="la-section section-with-icon-box">
                            <div class="la-container">
                                <p class="section-title"><?php the_sub_field( 'section_title' ); ?></p>
                            </div>
                            <div class="la-container">
                                <div class="la-row owl-carousel" id="icon-boxes">
									<?php while ( have_rows( 'icon_boxes' ) ) : the_row(); ?>
                                        <div class="icon-box">
                                            <div class="ib-icon"><?php the_sub_field( 'icon' ); ?></div>
                                            <h4><?php the_sub_field( 'title' ); ?></h4>
                                            <div class="details"><?php the_sub_field( 'details' ); ?></div>
                                        </div>
									<?php endwhile; ?>
                                </div>
                            </div>
                        </div>

					<?php elseif ( get_row_layout() == 'what_our_users_are_saying' ) : ?>

                        <!--                        <div class="la-section our-users-saying">-->
                        <!--                            <div class="la-container">-->
                        <!--                                <h2 class="section-title">--><?php //the_sub_field( 'section_title' ); ?><!--</h2>-->
                        <!--                                <div id="testimonial-wrapper" class="owl-carousel">-->
                        <!--									--><?php //while ( have_rows( 'reviews' ) ) : the_row(); ?>
                        <!--                                        <div class="review-details">--><?php //the_sub_field( 'review' ); ?><!--</div>-->
                        <!--									--><?php //endwhile; ?>
                        <!--                                </div>-->
                        <!--                                <div class="review-star">-->
                        <!--                                    <div class="stars">-->
                        <!--                                        <i class="fa fa-star"></i>-->
                        <!--                                        <i class="fa fa-star"></i>-->
                        <!--                                        <i class="fa fa-star"></i>-->
                        <!--                                        <i class="fa fa-star"></i>-->
                        <!--                                        <i class="fa fa-star"></i>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <div class="landing-testimonials">
                            <div class="la-container">
                                <div class="stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <h2>What <strong>our users</strong> are saying...</h2>
                            </div>
							<?php echo do_shortcode( get_sub_field( 'testimonial_shortcode' ) ); ?>

                        </div>

          <?php elseif ( get_row_layout() == 'pick_a_plan' ) : ?>

            <div id="<?php echo get_sub_field('section_id'); ?>" class="pick_a_plan la-section">
              <div class="la-container">
                <div class="la-row">
                  <h2><?php echo get_sub_field('section_title'); ?></h2>
                  <div class="plans_grid">
                    <?php
                    $plans = get_sub_field('plans');
                    ?>
                    <?php foreach ($plans as $plan): ?>
                      <div class="plan_item">
                        <div style="background: <?php echo $plan['background_color']; ?>;" class="plan_item_header">
                          <div class="title">
                            <?php echo $plan['title']; ?>
                          </div>
                          <div class="subtitle">
                            <?php echo $plan['subtitle']; ?>
                          </div>
                        </div>
                        <div class="plan_item_inner">
                          <div class="price_wrapper">
                            <div class="price">
                              <?php echo $plan['price']; ?>
                            </div>
                            <div class="price_description">
                              <?php echo $plan['price_description']; ?>
                            </div>
                          </div>
                          <div class="includes_wrapper">
                            <?php
                            if($plan['includes']):
                              foreach ($plan['includes'] as $include): ?>
                                <div class="item">
                                  <div class="incl_icon">
                                    <?php echo $include['icon']; ?>
                                  </div>
                                  <?php echo $include['title']; ?>
                                </div>
                                <?php
                              endforeach;
                            endif; ?>
                          </div>
                          <a class="btn_started arrow_right" href="<?php echo $plan['button_url']; ?>">
                            Get started<span class="fa"><?php echo $plan['button_icon']; ?></span>
                          </a>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
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
                                <?php if (get_sub_field('sublink_title')): ?>
                                  <a class="sublink" href="<?php echo get_sub_field('sublink_url'); ?>">
                                    <?php echo get_sub_field('sublink_title'); ?>
                                  </a>
                                <?php endif; ?>
                            </div>
                        </div>

          <?php elseif ( get_row_layout() == 'head_with_video' ) : ?>
            <div class="entry-content home-entry-content home home-entry-content-new">
              <div class="linkable-home-header">
                <h2><?php echo get_sub_field('title'); ?></h2>
                <p><?php echo get_sub_field('subtitle'); ?></p>
              </div>
              <div class="linkable-home-video">
                <div class="home-arrow">
                  <div class="arrow-wrapper">
                    Watch our short intro video
                    <img class="watch-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/images/watch-video-arrow-green.png">
                  </div>
                  <div style="position: relative;" class="laptop-screen-wrapper">
                    <?php echo get_sub_field('video'); ?>
                    <img class="laptop_pen" src="<?php echo get_stylesheet_directory_uri(); ?>/images/pen.png" alt="">
                    <img class="laptop-screen" src="<?php echo get_stylesheet_directory_uri(); ?>/images/linkable-home-screen.png" alt="laptop screen">
                  </div>
                </div>
              </div>
              <style media="screen">
                html {
                  margin-top: 0px !important;
                }
              </style>
            </div>

          <?php elseif ( get_row_layout() == 'page_content' ) : ?>
            <div class="become_writer">
              <div class="container_second">
                <?php if (get_sub_field('title')): ?>
                  <h2><?php echo get_sub_field('title') ?></h2>
                <?php endif; ?>

                <div class="content">
                  <?php echo get_sub_field('content') ?>
                </div>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'review_box' ) : ?>
            <div style="background: <?php echo get_sub_field('background_color'); ?>;" class="single_testimonial">
              <div class="testimonial_inner">
                <div class="quote">
                  <?php echo get_sub_field('content'); ?>
                </div>
                <div class="author">
                  <img src="<?php echo get_sub_field('author_photo'); ?>" alt="">
                  <?php echo get_sub_field('author_name_and_position'); ?>
                </div>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'text_on_dark_bg' ) : ?>
            <div class="section_text">
              <div class="container">
                <?php echo get_sub_field('content'); ?>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'academy_product' ) : ?>
            <div class="academy">
              <div class="container">
                <h2><?php echo get_sub_field('title'); ?></h2>
                <div class="subtitle">
                  <?php echo get_sub_field('subtitle'); ?>
                </div>
                <div class="product_container">
                  <div class="product_image">
                    <img src="<?php echo get_sub_field('product_image'); ?>" alt="">
                  </div>
                  <div class="product_description">
                    <?php echo get_sub_field('product_description'); ?>
                  </div>
                </div>
                <a href="<?php echo get_sub_field('button_link'); ?>" class="btn">
                  <?php echo get_sub_field('button_title'); ?>
                </a>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'what_you_will_learn' ) : ?>
            <div class="what_youll_learn">
              <div class="container_small">
                <div class="description">
                  <?php echo get_sub_field('description'); ?>
                </div>
                <?php
                $courses = get_sub_field('courses');
                ?>
                <div class="courses_boxes">
                  <?php foreach ($courses as $course): ?>
                    <div class="course_box">
                      <div class="course_head">
                        <?php echo $course['course_name']; ?>
                      </div>
                      <div class="course_items">
                        <?php foreach ($course['course_items'] as $course_item): ?>
                          <div class="course_element">
                            <div class="icon">
                              <i class="fab fa <?php echo $course_item['icon']; ?>"></i>
                            </div>
                            <a href="<?php echo $course_item['link']; ?>" class="course_item_name">
                              <?php echo $course_item['course_item_name']; ?> (<?php echo $course_item['course_item_length']; ?>)
                            </a>
                            <a class="course_item_start_button" href="<?php echo $course_item['link']; ?>">
                              Start
                            </a>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'enroll_now' ) : ?>
            <div class="enroll_now">
              <div class="container">
                <h2><?php echo get_sub_field('title'); ?></h2>
                <div class="description">
                  <?php echo get_sub_field('subtitle'); ?>
                </div>
                <div class="enroll_box">
                  <div class="white_line_wrapper">
                  </div>
                  <div class="left_part">
                    <div class="limited">
                      <?php echo get_sub_field('text_over_price'); ?>
                    </div>
                    <div class="price">
                      <div class="current_price">
                        <?php echo get_sub_field('current_price'); ?>
                      </div>
                      <div class="previous_price">
                        <?php echo get_sub_field('old_price'); ?>
                        <div class="price_description">
                          <?php echo get_sub_field('price_description'); ?>
                        </div>
                      </div>
                    </div>
                    <a href="<?php echo get_sub_field('button_link'); ?>" class="btn">
                      <?php echo get_sub_field('button_title'); ?>
                    </a>
                    <img class="payment_methods" src="<?php echo get_sub_field('payment_methods'); ?>" alt="">
                  </div>
                  <div class="right_part">
                    <div class="product_description">
                      <?php echo get_sub_field('product_description'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php elseif ( get_row_layout() == 'faq' ) : ?>
            <div class="landing_faq">
              <div class="container">
                <h2><?php echo get_sub_field('title'); ?></h2>
                <?php
                $items = get_sub_field('items');
                $class = '';
                $maxheight = '';
                foreach ($items as $item) {
                  ?>
                  <div class="faq_item <?php echo $class ?>">
                    <div class="question">
                      <?php echo $item['question']; ?>
                      <i class="fa fa-plus-circle" aria-hidden="true"></i>
                      <i class="fa fa-minus-circle" aria-hidden="true"></i>
                    </div>
                    <div style="<?php echo $maxheight ?>;" class="answer">
                      <p>
                        <?php echo $item['answer']; ?>
                      </p>
                    </div>
                  </div>
                  <?php
                  $class = '';
                  $maxheight = '';
                }
                ?>
              </div>
            </div>
            <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function(){
              var coll = document.getElementsByClassName("question");
              var i;

              for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                  this.classList.toggle("active");
                  var content = this.nextElementSibling;
                  if (this.parentElement.classList.contains('open')){
                    content.style.maxHeight = null;
                    this.parentElement.classList.toggle("open");
                  } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                    this.parentElement.classList.toggle("open");

                  }
                });
              }
              coll[0].classList.toggle("active");
              var content = coll[0].nextElementSibling;
              if (content.style.maxHeight){
                content.style.maxHeight = null;
                coll[0].parentElement.classList.toggle("open");
              } else {
                content.style.maxHeight = content.scrollHeight + "px";
                coll[0].parentElement.classList.toggle("open");
              }
            });
            </script>

          <?php elseif ( get_row_layout() == 'enroll_button' ) : ?>
            <div class="enroll_cta">
              <div class="container">
                <a href="<?php echo get_sub_field('button_link'); ?>" class="btn"><?php echo get_sub_field('button_title'); ?></a>
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
