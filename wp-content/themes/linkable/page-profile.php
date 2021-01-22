<?php
/**
 * Template Name: Member Profile Page
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';

	return $classes;
}


global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
//convert current user
$ae_users  = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
//convert current profile
$post_object = $ae_post_factory->get( PROFILE );

$profile_id = get_user_meta( $user_ID, 'user_profile_id', true );

$profile = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}

//get profile skills
$current_skills = get_the_terms( $profile, 'skill' );
//define variables:
$skills         = isset( $profile->tax_input['skill'] ) ? $profile->tax_input['skill'] : array();
$job_title      = isset( $profile->et_professional_title ) ? $profile->et_professional_title : '';
$hour_rate      = isset( $profile->hour_rate ) ? $profile->hour_rate : '';
$currency       = isset( $profile->currency ) ? $profile->currency : '';
$experience     = isset( $profile->et_experience ) ? $profile->et_experience : '';
$hour_rate      = isset( $profile->hour_rate ) ? $profile->hour_rate : '';
$about          = isset( $profile->post_content ) ? $profile->post_content : '';
$display_name   = $user_data->display_name;
$user_available = isset( $user_data->user_available ) && $user_data->user_available == "on" ? 'checked' : '';
$country        = isset( $profile->tax_input['country'][0] ) ? $profile->tax_input['country'][0]->name : '';
$category       = isset( $profile->tax_input['project_category'][0] ) ? $profile->tax_input['project_category'][0]->slug : '';

get_header();
// Handle email change requests
$user_meta = get_user_meta( $user_ID, 'adminhash', true );

if ( ! empty( $_GET['adminhash'] ) ) {
	if ( is_array( $user_meta ) && $user_meta['hash'] == $_GET['adminhash'] && ! empty( $user_meta['newemail'] ) ) {
		wp_update_user( array(
			'ID'         => $user_ID,
			'user_email' => $user_meta['newemail']
		) );
		delete_user_meta( $user_ID, 'adminhash' );
	}
	echo "<script> window.location.href = '" . et_get_page_link( "profile" ) . "'</script>";
} elseif ( ! empty( $_GET['dismiss'] ) && 'new_email' == $_GET['dismiss'] ) {
	delete_user_meta( $user_ID, 'adminhash' );
	echo "<script> window.location.href = '" . et_get_page_link( "profile" ) . "'</script>";
}

$rating        = Fre_Review::employer_rating_score( $user_ID );
$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$rating        = Fre_Review::freelancer_rating_score( $user_ID );
	$role_template = 'freelance';
}

$projects_worked = get_post_meta( $profile_id, 'total_projects_worked', true );
$project_posted  = fre_count_user_posts_by_type( $user_ID, 'project', '"publish","complete","close","disputing","disputed", "archive" ', true );
$hire_freelancer = fre_count_hire_freelancer( $user_ID );

$currency           = ae_get_option( 'currency', array(
	'align' => 'left',
	'code'  => 'USD',
	'icon'  => '$'
) );
$profile_title      = get_author_tag_name( $user_data );
$headshot_note      = get_field( 'my_author_headshot_info_text' );
$profile_title_note = get_field( 'my_profile_title_info_text' );
$author_bio_note    = get_field( 'my_author_bio_info_text' );
$rating_note        = get_field( 'my_author_rating_info_text' );
$feedback_cm_note   = get_field( 'feedback_ratings_from_cm_info_text' );
?>
<style>
    .dashboard-sidebar > ul > li.la_nav_profiles a {
        color: white;
        font-weight: bold;
    }
    .dashboard-sidebar > ul > li.la_nav_profiles a i {
        color: #1aad4b;
    }
</style>
<div class="entry-content landing-entry-content">
	<?php get_template_part( 'dashboard-side-nav' ); ?>

    <div class="main-dashboard-content dashboard-landing inner-dashboard">
        <div class="fre-page-wrapper list-profile-wrapper">
            <div class="fre-page-title">

                <h2><?php _e( 'Settings', ET_DOMAIN ) ?></h2>
                <h3>My Account Info</h3>
                <p class="optional-text">

					<?php if ( $user_role == 'employer' ) {
						echo get_field( 'my_account_info_text' );
					} else if ( $user_role == 'freelancer' ) {
						echo get_field( 'my_account_info_text_copy' );
					}
					?>
                </p>

            </div>

			<?php //print_r($_POST); ?>

            <div class="fre-page-section">

                <div class="profile-<?php echo $role_template; ?>-wrap">
					<?php if ( empty( $profile_id ) && ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) ) { ?>
                        <div class="notice-first-login">
                            <p>
                                <i class="fa fa-warning"></i><?php _e( 'You must complete your profile to do any activities on site', ET_DOMAIN ) ?>
                            </p>
                        </div>
					<?php } ?>
                    <div class="fre-profile-box">

                        <div class="profile-<?php echo $role_template; ?>-info-wrap active">
							<?php echo do_shortcode( '[gravityform id=8 title=false description=false tabindex=49]' ); ?>
                            <div class="profile-freelance-info cnt-profile-hide" id="cnt-profile-default"
                                 style="display: block">
                                <div class="freelance-info-avatar">
                                    <div class="photo-info">
										<?php
										if ( EMPLOYER == ae_user_role() ) { ?>
                                            <span class="freelance-avatar">
                                            <a href="#" id="user_avatar_browse_button" title="Click to change!">
                                            <?php echo get_avatar( $user_data->ID, 100 ); ?>
                                            </a>
                                        </span>
										<?php } ?>
                                        <div>
                                            <span class="freelance-name">Name:</span>
                                            <span><?php echo $user_data->first_name . ' ' . $user_data->last_name; ?></span>

											<?php
//                                            if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
//												echo '<span>Content Author Account</span>';
//											} else {
//												echo '<span>Content Marketer Account</span>';
//											}
											?>

                                            <span class="freelance-email">Email:</span>
                                            <span class="email-address">
                                                <?php
                                                if ( isset( $_POST['input_1'] ) ) {
	                                                if ( ( $_POST['input_1'] ) && ( $_POST['gform_submit'] == 8 ) ) {
		                                                echo $_POST['input_1'];
	                                                }
                                                } else {
	                                                echo $user_data->user_email;
                                                } ?>
                                            </span>
                                            <!--                                            <a href="#"-->
                                            <!--                                               class="change-password">-->
											<?php //_e("Change Password", ET_DOMAIN) ?><!--</a>-->
                                        </div>
                                    </div>

                                    <div class="employer-info-edit account-info"><span class="green bold">edit <i
                                                    class='fa fa-ellipsis-v'></i></span>
                                        <div class="edit-ellipses-popup">
                                            <a href="#" id="edit-account-info" class="profile-show-edit-tab-btn"
                                            >Edit account info</a>
                                            <a href="#"
                                               class="change-password"><?php _e( "Change password", ET_DOMAIN ) ?></a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="profile-employer-info-edit cnt-profile-hide" id="ctn-edit-profile"
                             style="display: none">
                            <div class="fre-employer-info-form" id="accordion" role="tablist"
                                 aria-multiselectable="true">
                                <form id="profile_form" class="form-detail-profile-page" action="" method="post"
                                      novalidate>
                                    <div class="fre-input-field">
                                        <input type="text" value="<?php echo $display_name ?>"
                                               name="display_name" id="display_name"
                                               placeholder="<?php _e( 'Your name', ET_DOMAIN ) ?>">
                                    </div>

                                    <div class="fre-input-field">
                                        <label><?php _e( 'Email address', ET_DOMAIN ) ?></label>
                                        <input type="email" class="" id="user_email" name="user_email"
                                               value="<?php echo $user_data->user_email ?>"
                                               placeholder="<?php _e( 'Enter email', ET_DOMAIN ) ?>">
                                    </div>

									<?php if ( fre_share_role() || $user_role == FREELANCER ) { ?>
                                        <!--
                                        <div class="fre-input-field">
											<?php
										$c_skills = array();
										if ( ! empty( $current_skills ) ) {
											foreach ( $current_skills as $key => $value ) {
												$c_skills[] = $value->term_id;
											};
										}
										ae_tax_dropdown( 'skill',
											array(
												'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" multiple data-placeholder="' . sprintf( __( " Skills (max is %s)", ET_DOMAIN ), ae_get_option( 'fre_max_skill', 5 ) ) . '"',
												'class'           => ' edit-profile-skills',
												'hide_empty'      => false,
												'hierarchical'    => false,
												'id'              => 'skill',
												'show_option_all' => false,
												'selected'        => $c_skills
											)
										);

										?>
                                        </div>-->


									<?php } ?>


                                    <div class="employer-info-save btn-update-profile btn-update-profile-top">
                                        <span class="employer-info-cancel-btn profile-show-edit-tab-btn"
                                              data-ctn_edit="cnt-profile-default"><?php _e( 'Cancel', ET_DOMAIN ) ?> &nbsp; </span>
                                        <input type="submit" class="fre-normal-btn btn-submit"
                                               value="<?php _e( 'Save', ET_DOMAIN ) ?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

				<?php if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) { ?>
                    <div class="fre-input-field email-notify-old">
						<?php
						$email_skill = isset( $profile->email_skill ) ? (int) $profile->email_skill : 0;
						?>
                        <label class="fre-checkbox no-margin-bottom" for="email-skill">
                            <input id="email-skill" type="checkbox" name="email_skill"
                                   value="1" <?php checked( $email_skill, 1 ); ?> >
                            <span></span>

							<?php _e( 'Email me jobs that are relevant to my skills', ET_DOMAIN ) ?>

                        </label>
                    </div>
				<?php } ?>
				<?php /*
                <!--                --><?php //if (ae_user_role($user_ID) == EMPLOYER) { ?>
                <!--                <div class="website-verification">-->
                <!---->
                <!--                    <div class="fre-page-title">-->
                <!--                        <h3>My Websites</h3>-->
                <!--                        <p class="optional-text">-->
                <!--                            --><?php //if ($user_role == 'employer') {
                //                                echo get_field('my_websites_text');
                //                            } else if ($user_role == 'freelancer') {
                //
                //                            }
                //                            ?>
                <!--                        </p>-->
                <!--                    </div>-->
                <!--                    <div class="fre-page-section">-->
                <!--                        <div class="fre-profile-box">-->
                <!--                            <div class="website-list">-->
                <!---->
                <!--                                --><?php
                //                                $acf_id = 'user_' . $current_user->ID;
                //
                //                                // check if the repeater field has rows of data
                //                                if (have_rows('urls', $acf_id)):
                //
                //                                    // loop through the rows of data
                //                                    while (have_rows('urls', $acf_id)) : the_row();
                //
                //                                        // display a sub field value
                //
                ////         https://whiteleydesigns.com/simple-support-tickets-acf-gravity-forms/
                //                                        echo '<div>';
                //                                        the_sub_field('url');
                //                                        echo '<span>Verified</span> <i class="fa fa-check-circle"></i>';
                //                                        echo '</div>';
                //
                //                                    endwhile;
                //
                //                                else :
                //
                //                                    // no rows found
                //
                //                                endif;
                //
                //                                echo '</div>';
                //
                //                                echo '<div class="add-new-website"><a><i class="fa fa-plus"></i> Add new website</a></div>';
                //
                //                                get_template_part('website-verification');
                //
                //                                }

                */
				?>

				<?php if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) { ?>
                <div class="freelancer-info">
                    <!-- MY AUTHOR PROFILE SECTION -->
                    <div class="fre-page-title">
                        <h3><?php esc_html_e( 'My Author Profile:', 'link-able' ); ?></h3>
                        <p class="optional-text">
							<?php echo get_field( 'my_author_profile_info_text' ); ?> <a href="javascript:void(0)"
                                                                                         data-toggle="modal"
                                                                                         data-target="#la_modal_container">View
                                my profile as the client sees it</a>
                        </p>
                    </div>
                    <div class="fre-page-section my-author-info">
                        <div class="fre-profile-box" id="my_author_profile_view">
                            <div class="employer-info-edit my-author-info-edit">
                                <span class="green bold">edit <i class="fa fa-ellipsis-v"></i></span>

                                <div class="edit-ellipses-popup">
                                    <a href="javascript:void();" id="edit-author-info"
                                       class="profile-show-edit-tab-btn"
                                       onclick="jQuery('#my_author_profile_view').slideUp(); jQuery('#my_author_profile_edit').slideDown();"
                                       style="margin-bottom: 0;">Edit Author information</a>
                                </div>
                            </div>
                            <span class="bold btn-block"><?php esc_html_e( 'My author headshot:', 'link-able' ); ?> <i
                                        class="fa fa-question-circle toggleNotes"
                                        data-target="#author-headshot-note"></i></span>
							<?php if ( ! empty( $headshot_note ) ) { ?>
                                <div id="author-headshot-note"
                                     class="la_notes_container"><?php echo $headshot_note; ?></div>
							<?php } ?>
                            <div class="la_profile_img" style="margin-bottom: 30px;">
								<?php echo get_avatar( $user_data->ID, 100 ); ?>
                            </div>
                            <span class="bold btn-block"><?php esc_html_e( 'My profile title:', 'link-able' ); ?> <i
                                        class="fa fa-question-circle toggleNotes"
                                        data-target="#my-profile-note"></i></span>
							<?php if ( ! empty( $profile_title_note ) ) { ?>
                                <div id="my-profile-note"
                                     class="la_notes_container"><?php echo $profile_title_note; ?></div>
							<?php } ?>
                            <p><?php if ( $profile_title ) {
									if ( 'Freelancer' == $profile_title ) {
										$profile_title = 'Author';
									} ?>
                                    <span><?php echo $profile_title ?></span>
								<?php } else { ?>
                                    <span><?php _e( 'Author', ET_DOMAIN ) ?></span>
								<?php } ?>
                            </p>
                            <span class="bold btn-block"><?php esc_html_e( 'My author bio:', 'link-able' ); ?> <i
                                        class="fa fa-question-circle toggleNotes"
                                        data-target="#author-bio-note"></i></span>
							<?php if ( ! empty( $author_bio_note ) ) { ?>
                                <div id="author-bio-note"
                                     class="la_notes_container"><?php echo $author_bio_note; ?></div>
							<?php } ?>
							<?php
							if ( ! empty( $profile ) ) { ?>
                                <div class="freelance-about">
									<?php echo $about; ?>
                                </div>
								<?php if ( function_exists( 'et_the_field' ) && ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) ) {
									et_render_custom_field( $profile );
								}
							} else {
								echo '<p>' . $user_data->description . '</p>';
							} ?>
                            <span class="bold btn-block"><?php esc_html_e( 'My author rating:', 'link-able' ); ?> <i
                                        class="fa fa-question-circle toggleNotes" data-target="#author-rating-note"></i></span>
							<?php if ( ! empty( $rating_note ) ) { ?>
                                <div id="author-rating-note"
                                     class="la_notes_container"><?php echo $rating_note; ?></div>
							<?php } ?>
							<?php
							$average_from = 'Avg. from ' . $rating['review_count'] . ' ratings';
							// $average_from .= $rating['review_count'] <= 1 ? ' rating' : ' ratings';
							?>
                            <p class="green"><span class="rate-it rate-it-empty-spacing"
                                                   data-score="<?php echo $rating['rating_score']; ?>"></span>&nbsp; -
                                &nbsp;<?= get_rating_title( $rating['rating_score'] ); ?> (<?= $average_from; ?>)</p>
							<?php $feedback = get_latest_feedback( $user_ID );
							if ( count( $feedback ) > 0 ) { ?>
                                <span class="bold btn-block"><?php esc_html_e( 'My feedback & ratings from previous jobs:', 'link-able' ); ?> <i
                                            class="fa fa-question-circle toggleNotes"
                                            data-target="#feedback-rating-note"></i></span>
								<?php if ( ! empty( $feedback_cm_note ) ) { ?>
                                    <div id="feedback-rating-note"
                                         class="la_notes_container"><?php echo $feedback_cm_note; ?></div>
								<?php } ?>
								<?php foreach ( $feedback as $k => $fb ) {
									$r_score   = isset( $fb['rating_score'] ) ? $fb['rating_score'] : 0;
									$r_feed    = isset( $fb['rating_feedback'] ) ? $fb['rating_feedback'] : 'No feedback given!';
									$r_project = isset( $fb['rating_project_id'] ) ? $fb['rating_project_id'] : '';
									?>
                                    <div class="la_latest_review la_feedback_<?= $k; ?>">
                                        <span class="black-rating"><?php echo generate_ratings( $r_score ); ?></span>
                                        <i class="btn-block"><?= empty( $r_feed ) ? 'No feedback given!' : $r_feed; ?>
											<?php if ( ! empty( $r_project ) ) { ?>
                                                <a href="<?php echo get_permalink( $r_project ); ?>"
                                                   style="font-style: normal;"><?php esc_html_e( 'View Contract' ); ?></a><?php
											} ?></i>
                                    </div>
								<?php }
							} ?>
                        </div>
                        <div class="fre-profile-box" id="my_author_profile_edit" style="display: none;">
                            <form id="my_author_info_save">
								<?php wp_nonce_field( '_my_author_info', '_csrf_token' ); ?>
                                <input type="hidden" name="author_id" value="<?= $user_ID; ?>">
                                <input type="hidden" name="profile_id" value="<?= $profile_id; ?>">
                                <div class="form-group">
                                    <span class="bold btn-block"><?= get_field('author_headshot_label'); ?>: <i
                                                class="fa fa-question-circle toggleNotes"
                                                data-target="#author-headshot-note_edit"></i></span>
									<?php if ( ! empty( $headshot_note ) ) { ?>
                                        <div id="author-headshot-note_edit"
                                             class="la_notes_container"><?php echo $headshot_note; ?></div>
									<?php } ?>
                                    <div class="employer-info-avatar avatar-profile-page text-center"
                                         style="width: 100px;">
                                        <span class="employer-avatar img-avatar image">
                                            <?php echo get_avatar( $user_data->ID, 100 ); ?>
                                        </span><br>
                                        <a href="#" id="user_avatar_browse_button">
											<?php _e( 'Change', ET_DOMAIN ) ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="bold btn-block"><?= get_field('profile_title_label'); ?>: <i
                                                class="fa fa-question-circle toggleNotes"
                                                data-target="#my-profile-note_edit"></i></span>
									<?php if ( ! empty( $profile_title_note ) ) { ?>
                                        <div id="my-profile-note_edit"
                                             class="la_notes_container"><?= $profile_title_note; ?></div>
									<?php } ?>
                                    <input type="text" class="form-control laHasCounter" id="my_author_title" name="my_author_title" value="<?php echo $profile_title ?>" placeholder="<?= get_field('profile_title_placeholder'); ?>" data-maxlength="80">
                                    <div class="charleft la_ginput_counter"></div>
                                </div>
                                <div class="form-group">
                                    <span class="bold btn-block"><?= get_field('author_bio_label'); ?>: <i
                                                class="fa fa-question-circle toggleNotes"
                                                data-target="#author-bio-note_edit"></i></span>
									<?php if ( ! empty( $author_bio_note ) ) { ?>
                                        <div id="author-bio-note_edit"
                                             class="la_notes_container"><?php echo $author_bio_note; ?></div>
									<?php } ?>
                                    <textarea class="form-control laHasCounter" id="my_author_bio" name="my_author_bio"
                                              placeholder="<?= get_field('author_bio_placeholder'); ?>" data-maxlength="300"><?php echo $user_data->description; ?></textarea>
                                    <div class="charleft la_ginput_counter"></div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Submit" class="btn la_btn_default">
                                </div>
                            </form>
                            <a href="javascript:void()" onclick="window.location.reload()">Cancel</a>
                        </div>
                    </div>
                    <!-- / END OF MY AUTHOR PROFILE SECTION -->
                    <div class="fre-page-title">
                        <h3>Payment Info</h3>
                        <p class="optional-text">
							<?php if ( $user_role == 'employer' ) {

							} else if ( $user_role == 'freelancer' ) {
								echo get_field( 'payment_info_content_author' );
							}
							?>
                        </p>
                    </div>
                    <div class="fre-page-section">
                        <div class="fre-profile-box">
							<?php
							$paypal_info = get_field( 'paypal_email', 'user_' . $user_ID );
							//echo $paypal_info;
							if ( $paypal_info == '' ) {

								?>
                                <p>You'll need to add your PayPal email address here so that we can send
                                    you your payments.</p>
                                <div class="set-up-paypal"><i
                                            class="fa fa-plus-circle green"></i> <?php esc_html_e( 'Add your PayPal email address', ET_DOMAIN ); ?>
                                </div>


							<?php } ?>
                            <div class="paypal-form"><?php echo do_shortcode( '[gravityform id=9 title=false description=false]' ); ?></div>
							<?php //print_r($_POST);?>
							<?php //echo '<span class="current-info-validation">' . get_field('paypal_email','user_' . $user_ID) . '</span>'; ?>
                            <div class="current-paypal-info"><?php

								//print_r($_POST);

								echo get_field( 'paypal_email', 'user_' . $user_ID );

								/*if(isset($_POST['input_1'])) {
														   if(($_POST['input_1'] != "") && ($_POST['gform_submit'] == 9) ) {
															   echo $_POST['input_1'];

														   } }else {
															   echo get_field('paypal_email','user_' . $user_ID); }*/ ?>
                                <div class="employer-info-edit paypal-info">
                                    <span class="green bold">edit <i class="fa fa-ellipsis-v"></i></span>

                                    <div class="edit-ellipses-popup">
                                        <a href="#" id="edit-paypal-info"
                                           class="profile-show-edit-tab-btn"
                                        >Edit PayPal information</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					<?php } ?>




					<?php if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) { ?>
                        <div class="fre-page-title">
                            <h3>Alert notifications</h3>
                            <p class="optional-text">
								<?php if ( $user_role == 'employer' ) {

								} else if ( $user_role == 'freelancer' ) {
									echo get_field( 'alert_notifications_content_author' );
								}
								?>
                            </p>
                        </div>

                        <div class="fre-page-section">
                            <div class="fre-profile-box notification-box">
                                <p>Please select ONLY the categories you commonly write about and
                                    specialize in:</p>
                                <div class="notification-checkboxes">
                                    <div class="notification-form"><?php echo do_shortcode( '[gravityform id=10 title=false description=false tabindex=49]' ); ?></div>
									<?php /*
				 	$choices = get_field('notification_categories','user_' . $user_ID);
				 	
				 	foreach($choices as $choice) {
					 	echo $choice->name;
				 	}*/

									?>
                                </div>
                            </div>
                        </div>

					<?php } ?>
                </div>
            </div>

        </div>


    </div>
	<?php ?>
</div>


</div>
</div>
</div>
</div>
<?php
get_template_part( 'template-js/modal-upload', 'avatar' );
if ( FREELANCER == ae_user_role() ) {
	$author = $user_data;
	include_once get_stylesheet_directory() . '/messaging/parts/modals/author-profile.php';
}
?>
<!-- CURRENT PROFILE -->
<?php if ( $profile_id && $profile_post && ! is_wp_error( $profile_post ) ) { ?>
    <script type="data/json" id="current_profile">
    <?php echo json_encode( $profile ) ?>




    </script>
<?php } ?>
<!-- END / CURRENT PROFILE -->

<!-- CURRENT SKILLS -->
<?php if ( ! empty( $current_skills ) ) { ?>
    <script type="data/json" id="current_skills">
    <?php echo json_encode( $current_skills ) ?>




    </script>
<?php } ?>
<!-- END / CURRENT SKILLS -->

<script>
    jQuery(document).ready(function () {

        if (jQuery(".paypal-form div.validation_error").length != 0) {

            // code that should be run if the validation error exists goes here
            jQuery(".current-paypal-info").hide();
        }

        if (jQuery(".profile-freelance-info-wrap div.validation_error").length != 0) {
            jQuery("#cnt-profile-default").hide();
            jQuery("#gform_wrapper_8").show();
        }

    });
</script>

<?php
get_footer();
?>

