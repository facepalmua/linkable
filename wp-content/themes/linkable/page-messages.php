<?php
/**
 * Template Name: Private Messages
 */

add_filter( 'body_class', 'la_body_class_for_pm_page', 10, 2 );
 function la_body_class_for_pm_page( $classes, $class ) {
    $classes[] = 'dashboard';
    $classes[] = 'private-messages';
    return $classes;
}

global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role = ae_user_role($current_user->ID);
$a_id = isset( $_GET['a_id'] ) ? sanitize_text_field( $_GET['a_id'] ) : '';
$p_id = isset( $_GET['p_id'] ) ? sanitize_text_field( $_GET['p_id'] ) : '';

if( FREELANCER == ae_user_role() && ! empty( $a_id ) ) {
    if( $user_ID != $a_id ) {
	    wp_redirect( get_site_url() .  '/dashboard' );
    }
}

if( EMPLOYER == ae_user_role() && ! empty( $p_id ) ) {
    $p_author = get_post_field('post_author', $p_id );
	if( $user_ID != $p_author ) {
		wp_redirect( get_site_url() .  '/dashboard' );
	}
}

if(!is_user_logged_in()){
    $current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
}

if ($user_role=='freelancer'){
    add_filter( 'wp_title', 'my_tpl_wp_title', 100 );
}

function my_tpl_wp_title($title) {
	$title = 'Messages';
    return $title;
}
$message_titles = get_user_messages();

get_header();
?>
<style>
	.dashboard-sidebar > ul > li.la_nav_messages a {
		color: white;
		font-weight: bold;
	}
	.dashboard-sidebar > ul > li.la_nav_messages a i {
		color: #1aad4b;
	}
  .la_modal_container_project_container .time-posted.col-section {
    display: none;
  }
  .la_modal_container_project_container .project-category.col-section {
          text-align: right;
          color: #858585;
          font-size: 16px;
          font-family: 'Roboto', sans-serif;
  }

  .la_modal_container_project_container span.project-header {
      color: #858585;
      text-transform: uppercase;
      font-weight: bold;
      font-size: 40px;
      margin-bottom: 0;
      font-family: 'Roboto', sans-serif;
  }
  .ie_project_workroom .project-details-head span.project-header {
    font-size: 16px !important;
    display: block;
  }
</style>

<div class="entry-content landing-entry-content">
    <?php get_template_part( 'dashboard-side-nav'); ?>
     <div class="main-dashboard-content dashboard-landing inner-dashboard nopadding messages_page">
         <!-- <h1 class="entry-title"><?php esc_html_e('Messages', 'link-able' ); ?></h1>
              <p class="optional-text"> <?php
                 if ($user_role=='freelancer'){
                     echo get_field('messages_intro_text_author');
                 } else {
                     echo get_field('messages_intro_text_cm') ;
                 } ?>
             </p> -->
         <div class="messages-table">
         <?php if( count( $message_titles ) > 0 ) :
             $check_url = array_filter($message_titles, function ($mt) use ($a_id, $p_id){
                 return ( $mt->ID == $p_id ) && ( $mt->author_id == $a_id );
             });
             $has_active = count( $check_url ) > 0;
             $is_new_message = ! empty( $a_id ) && ! empty( $p_id );
             ?>

            <div class="payment-row">
                <div class="la_message_sidebar">
                    <div class="la_msg_list_holder">
                        <ul class="la_message_list">
                          <div class="search_bar">
                            <input type="text" name="search" value="" placeholder="Search...">
                            <div class="button_submit">
                              <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                          </div>
                        <?php
                        if( ! $has_active && $is_new_message ) {
                          $proj = get_post( $p_id );
	                        $userdata = EMPLOYER == ae_user_role() ? get_userdata( $a_id ) : '';
	                        if( EMPLOYER == ae_user_role()) {
		                        $avater_user = $proj->post_author;
	                        } else {
		                        $avater_user = $a_id;
	                        }
	                        ?>
                            <?= do_shortcode( '[la_sidebar_message active="true" project_id="' . $proj->ID . '" author="' . $a_id . '" avatar_user="' . $avater_user . '" short_username="' . get_short_username( $userdata ) . '"]' ) ?>
                            <!-- <li>
                                <a href="javascript:void(0)" class="laSidebarMessage active" data-project="<?= $proj->ID; ?>" data-author="<?= $a_id; ?>">
                                  <?php
                            			if (strpos(get_avatar( $avater_user ), 'replace_this_avatar.svg') !== false) {
                            				$user_firstname = get_user_meta( $avater_user, 'first_name', true );
                            				$user_lastname = get_user_meta( $avater_user, 'last_name', true );
                            				$colorHash = new Shahonseven\ColorHash();
                            				$color = $colorHash->hex($user_firstname . ' ' . $user_lastname);

                            				$user_firstname = substr($user_firstname, 0, 1);
                            				$user_lastname = substr($user_lastname, 0, 1);

                            			    ?>
                            					<div id="profile_img" style="min-width: 35px;    margin-right: 10px;">
                            						<div id="profile_img_wrapper">
                            							<div id="profile_img_circle" style="background: <?= $color ?>;">
                            									<?= $user_firstname ?><?= $user_lastname ?>
                            							</div>
                            						</div>
                            					</div>
                            					<?php
                            			} else {
                            					echo get_avatar( $avater_user, 35 );
                            			}
                            			?>
                                  <?php if (ae_user_role() != 'employer'): ?>
                                    <?= wp_strip_all_tags( $proj->post_title ); ?>  - (<?= get_short_username( $userdata ); ?>)
                                  <?php else: ?>
                                    <div class="la_msg_usertitle">
                                      <?= get_short_username( $userdata ); ?>
                                      <div class="la_msg_user_last_msg">
                                        <?= employer_get_latest_message( $proj->ID, $avater_user); ?>
                                      </div>
                                    </div>
                                  <?php endif; ?>
                                </a>
                            </li> -->
	                        <?php
                        }
                        $inc = 1;
                        foreach ( $message_titles as $mt ) {
                            $isRead = true; $isActive = false;
                            $current_user_id = $current_user->ID;
                            $userdata = EMPLOYER == ae_user_role() ? get_userdata( $mt->author_id ) : '';
                            if( 'unread' == $mt->status ) {
                                if ( $current_user_id == $mt->sender ) {
                                    $isRead = false;
                                } else {
	                                $isRead = true;
                                }
                            }
                            if( $has_active ) {
	                            $isActive = false;
	                            if( $mt->ID == $p_id && $mt->author_id == $a_id ) {
		                            $isActive = true;
                                }
                            }
                            else {
                                if( $inc === 1 && ! $is_new_message ) {
                                    $isActive = true;
                                }
                            }
                            if( FREELANCER == ae_user_role()) {
	                            $proj = get_post( $mt->ID );
                                $avater_user = $proj->post_author;
                            } else {
	                            $avater_user = $mt->author_id;
                            }
                            $add_attr = '';
                            if ('unread' == $mt->status):
                              $add_attr = ' unread="true" ';
                            endif;
                            if ($isActive):
                              $add_attr .= ' active="true" ';
                            endif; ?>
                            <?= do_shortcode( '[la_sidebar_message ' . $add_attr . ' project_id="' . $mt->ID . '" author="' . $mt->author_id . '" avatar_user="' . $avater_user . '" short_username="' . get_short_username( $userdata ) . '"]' ) ?>
                            <li>
                                <a href="javascript:void(0)" class="laSidebarMessage <?= 'unread' == $mt->status ? 'strong' : ''; ?> <?= $isActive ? 'active' : ''; ?>" data-project="<?= $mt->ID; ?>" data-author="<?= $mt->author_id; ?>">
                                  <?php
                            			if (strpos(get_avatar( $avater_user ), 'replace_this_avatar.svg') !== false) {
                            				$user_firstname = get_user_meta( $avater_user, 'first_name', true );
                            				$user_lastname = get_user_meta( $avater_user, 'last_name', true );
                            				$colorHash = new Shahonseven\ColorHash();
                            				$color = $colorHash->hex($user_firstname . ' ' . $user_lastname);

                            				$user_firstname = substr($user_firstname, 0, 1);
                            				$user_lastname = substr($user_lastname, 0, 1);

                            			    ?>
                            					<div id="profile_img" style="min-width: 35px;    margin-right: 10px;">
                            						<div id="profile_img_wrapper">
                            							<div id="profile_img_circle" style="background: <?= $color ?>;">
                            									<?= $user_firstname ?><?= $user_lastname ?>
                            							</div>
                            						</div>
                            					</div>
                            					<?php
                            			} else {
                            					echo get_avatar( $avater_user, 35 );
                            			}
                            			?>
                                  <?php if (ae_user_role() != 'employer'): ?>
                                    <?= wp_strip_all_tags( $mt->post_title ); ?> <?php if( EMPLOYER == ae_user_role() ) { ?> - <?= get_short_username( $userdata ); } ?>
                                  <?php else: ?>
                                    <div class="la_msg_usertitle">
                                      <?= get_short_username( $userdata ); ?>
                                      <div class="la_msg_user_last_msg">
                                        <?= employer_get_latest_message( $mt->ID, $avater_user); ?>
                                      </div>
                                    </div>
                                  <?php endif; ?>
								              </a>
                            </li>
                            <?php
	                        $isActive = false;
	                        $inc++;
                        }
                        ?>
                    </ul>
                    </div>
                </div>
                <div class="la_author_messages">
                    <div id="la_message_ajax_container" class="la_is_loading"></div>
                    <div class="la_message_reply_container">
                        <form id="la_message_reply_form">
                            <?php wp_nonce_field('_la_message_reply', 'reply_nonce' ); ?>
                            <input type="hidden" name="project_id" value="1">
                            <input type="hidden" name="author_id" value="1">
                            <div class="la_message_writer">
                                <textarea name="reply_message" id="la_reply_msg" class="form-control" rows="3" placeholder="<?php esc_html_e( 'Write a reply...', 'link-able' ); ?>"></textarea>
                            </div>
                            <div class="la_message_reply_button workspace-button">
                                <button class="btn reply_button" disabled>Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
             <?php else : ?>
             <div class="well">
                 <p class="alert alert-info text-center"><?php esc_html_e( 'No messages found!', 'link-able' ); ?></p>
             </div>
             <?php endif; // if has message_titles ?>
         </div>
         <!-- <?php if( FREELANCER == ae_user_role() ) { ?>
         <p style="margin-top: 15px; margin-bottom: 0;"><?php echo get_field( 'message_author_bottom_note' ); ?></p>
         <?php } else { ?>
         <p style="margin-top: 15px; margin-bottom: 0;"><?php echo get_field( 'message_cm_bottom_note' ); ?></p>
         <?php } ?> -->
     </div>
</div>
<?php get_footer() ?>
