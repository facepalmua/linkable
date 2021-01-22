<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

//if not logged in, redirect

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';
    $classes[] = get_post_status();

    return $classes;
}


if ( ! is_user_logged_in() ) {
    $current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
    die();
}

get_header();
$current_page  = $post->ID;
$shown_project = 'Project <span class="form-bid-id">' . $current_page . '</span>';
$user_role     = ae_user_role( $user_ID );

//echo $user_role;

if ( ae_user_role() == EMPLOYER ) {
    wp_redirect( get_home_url() . '/my-projects/' );
}

$employer_current_project_query = new WP_Query(
    array(
        'post_status'      => array(
            'close',
            'disputing',
            'publish',
            'pending',
            'draft',
            'reject',
            'archive',
            'pending-completion'
        ),
        'is_author'        => true,
        'post_type'        => PROJECT,
        'author'           => $user_ID,
        'suppress_filters' => true,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'posts_per_page'   => - 1
    )
);

$post_object       = $ae_post_factory->get( PROJECT );
$no_result_current = '';


?>


<?php


global $wp_query, $ae_post_factory, $post, $user_ID;
$post_object = $ae_post_factory->get( PROJECT );
$convert     = $post_object->convert( $post );
if ( have_posts() ) {
    the_post();
    $google_docs_url = get_field( 'google_doc_link', $viewing_bid );
    ?>


    <style>
        .dashboard-sidebar > ul > li:nth-child(3) a {
            color: white;
            font-weight: bold;
        }

        .dashboard-sidebar > ul > li:nth-child(3) a i {
            color: #1aad4b;
        }
        .single-bid div.status {
          width: auto;
        }
        .single-bid.accept div.status {
          width: 100%;
        }
    </style>


    <div class="entry-content landing-entry-content">
        <div class="inquire_overlay" ></div>
        <?php


        if ( $user_role == 'administrator' ) {

        } else if ( get_the_author_id() !== $user_ID ) {

            wp_redirect( get_home_url() . '/dashboard/' );
        }


        get_template_part( 'dashboard-side-nav' );


        ?>
        <div class="main-dashboard-content dashboard-landing inner-dashboard">


            <div class="fre-page-wrapper">
                <div class="container">
                    <h1>Contract Workroom</h1>

                    <div class="fre-project-detail-wrap">
                        <?php

                        global $wp_query, $wpdb, $ae_post_factory, $post, $user_ID;
                        $post_object         = $ae_post_factory->get( PROJECT );
                        $convert             = $project = $post_object->convert( $post );
                        $et_expired_date     = $convert->et_expired_date;
                        $bid_accepted        = $convert->accepted;
                        $project_status      = $convert->post_status;
                        $project_link        = get_permalink( $post->ID );
                        $role                = ae_user_role();
                        $bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
                        $bid_accepted_author = get_post_field( 'post_author', $bid_accepted );
                        $profile_id          = $post->post_author;
                        if ( ( fre_share_role() || $role != FREELANCER ) ) {
                            $profile_id = $bid_accepted_author;
                        }
                        $currency               = ae_get_option( 'currency', array(
                            'align' => 'left',
                            'code'  => 'USD',
                            'icon'  => '$'
                        ) );
                        $comment_for_freelancer = get_comments( array(
                            'type'    => 'em_review',
                            'status'  => 'approve',
                            'post_id' => $bid_accepted
                        ) );

                        $comment_for_employer = get_comments( array(
                            'type'    => 'fre_review',
                            'status'  => 'approve',
                            'post_id' => get_the_ID()
                        ) );

                        $freelancer_info = get_userdata( $bid_accepted_author );
                        $ae_users        = AE_Users::get_instance();
                        $freelancer_data = $ae_users->convert( $freelancer_info->data );
                        ?>

                        <div class="project-intro-wrap">

                            <!--<a class="button shortcode-button back-my-projects" href="<?php echo get_home_url(); ?>/my-applications/"><i class="fa fa-arrow-left"></i>Go back to My Applications</a>-->
                            <p class="project-summary"><?php _e( 'Contract Overview:', 'linkable' ); ?></p>
                        </div>

                        <?php //print_r($project); ?>

                        <?php //echo $project->post_parent;
                        $parent_project = $project->post_parent;
                        ?>

                        <div class="project-detail-box">
                            <div class="project-detail-info">
                                <div class="row">
                                    <div class="project-details-head">
                                        <h2 class="project-expand-collapse-btn"><?php the_title(); ?>
                                            <span><?php _e( 'Expand project summary', 'linkable' ); ?></span></h2>
                                        <div>
                                            <?php
                                            //date posted
                                            //add time from how long to get due date
                                            $time_left = 0;
                                            //$date_posted = get_the_date();
                                            $date_posted = get_field( 'date_accepted' );
                                            $how_long    = get_field( 'how_long' );

                                            if ( $how_long == 'Less than 2 weeks' || $how_long == '1 to 2 weeks' ) {
                                                $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 14 days' ) );
                                            } else if ( $how_long == '2 to 3 weeks' ) {
                                                $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 21 days' ) );
                                            } else if ( $how_long == '4 to 6 weeks' ) {
                                                $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 42 days' ) );
                                            } else if ( $how_long == '7 to 8 weeks' ) {
                                                $due_date = date( 'Y-m-d', strtotime( $date_posted . ' + 56 days' ) );
                                            }

                                            $today = time();

                                            $due_date = strtotime( $due_date );
                                            $bid_status = get_post_status();
                                            $comp_timestamp      = get_field( 'completed_date' );
                                            $comp_date = date( 'M j, Y', strtotime( $comp_timestamp ) );

                                            $submitted_text = ( $bid_status == 'completed' || $bid_status == 'pending-completion' ) ? 'Completed' : 'Submitted';
                                            $submitted_text .= ' on ' . $comp_date;
                                            $datediff = $due_date - $today;

                                            if ('cancelled' == $bid_status ) {
                                                $cancel_date = get_post_meta( get_the_ID(), 'bid_cancel_date', true);
                                                $c_date = $date_posted;
                                                $cancel_text = 'Submitted';
                                                if( ! empty( $cancel_date ) ) {
                                                    $cancel_text = 'Cancelled';
                                                    $c_date = date( 'M j, Y', strtotime( $cancel_date ) );
                                                }
                                                echo "<div class='days-left'><i class='fa fa-calendar-alt'></i> ".$cancel_text." on ".$c_date." </div>";
                                            }
                                            else if ( 'deleted' == $bid_status ) {
                                                if( $due_date < $today ){
                                                    echo "<div class='days-left'><i class='fa fa-calendar-alt'></i> Submitted on ".date( 'M j, Y', strtotime( $date_posted ) )." </div>";
                                                } else {
                                                    echo "<span class='days-left'><i class='fa fa-calendar-alt'></i> Submitted " . floor( $datediff / ( 60 * 60 * 24 ) ) . " days ago</span>";
                                                }
                                            }
                                            else if ( $bid_status == 'active' || $bid_status == 'accept' || $bid_status == 'admin-review') {
                                                echo "<div class='days-left'><i class='fa fa-calendar-alt'></i>" . floor( $datediff / ( 60 * 60 * 24 ) ) . " days left to complete</div>";
                                            }
                                            else {
                                                echo "<div class='days-left'><i class='fa fa-calendar-alt 1'></i> ". $submitted_text ." </div>"; // for completed on #mycomment
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="single-project-description-section <?= $bid_status; ?>">
                                        <div class="single-project-des-collapse">
                                            <div class="your-app-proposal">
                                                <div class="project-header">PROJECT DESCRIPTION:</div>
                                                <div><?php echo get_post_field( 'post_content', $parent_project ); ?></div>
                                            </div>
                                            <div class="your-app-additional-info">
                                                <div class="project-header">DETAILS & REQUIREMENTS:</div>
                                                <?php
                                                if ( get_field( 'linkable_ideas', $parent_project ) ) {
                                                    echo '<span>' . get_field( 'linkable_ideas', $parent_project ) . '</span>';
                                                } else {
                                                    echo 'The Content Marketer has no additional info about their page.';
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <div class="single-project-bottom-bar">
                                            <div>
                                                <div class="project-header">Your Contract Proposal</div>
                                                <?php echo get_field( 'proposal' ); ?>
                                            </div>
                                        </div>
                                        <div>
                                            <?php
                                            //if( $bid_status != 'declined' & $bid_status != 'deleted' && $bid_status == 'cancelled') { ?>
                                            <?php if ( $bid_status == 'accept' || $bid_status == 'pending-completion' || $bid_status == 'complete' || $bid_status == 'completed' || $bid_status == 'admin-review' ) { ?>
                                            <div class="project-header">CLIENT’S PAGE YOU OFFERED TO LINK TO:</div>
                                            <span class="bold green click-to-copy-wrapper">
                                                <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $parent_project );
                                                    } ?></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="project-top-bar">
                                        <div class="left-bar">
                                            <div class="col-section">
                                                <div class="project-header text-uppercase">Your Proposed Link On:</div>
                                                <strong class="proposed-url"><span class="green"><?php echo get_field( 'url_domain' ); ?></span></strong>
                                            </div>

                                            <div class="col-section">
                                                <div class="project-header text-uppercase">Your Promised Timeframe:
                                                </div>
                                                <span><?php echo get_field( 'how_long' ); ?></span>
                                            </div>
                                            <?php if ( $bid_status == 'active' ) { ?>
                                                <div class="col-section">
                                                    <div class="project-header text-uppercase">Contract Accepted
                                                    </div>
                                                    <span><?php echo date( "m/d/Y", strtotime( get_field( 'date_accepted' ) ) ); ?></span>
                                                </div> <?php }
                                            if ( get_post_status() == 'accept' || get_post_status() == 'complete' || get_post_status() == 'pending-completion' || get_post_status() == 'completed' || $bid_status == 'admin-review' ) { ?>
                                                <div class="col-section">
                                                    <div class="project-header text-uppercase">Contract Accepted
                                                    </div>
                                                    <?php
                                                    $timestamp      = get_field( 'date_accepted' );
                                                    $completed_date = date( "m/d/Y", strtotime( $timestamp ) );
                                                    echo '<span>' . $completed_date . '</span>';
                                                    ?>

                                                </div>
                                            <?php } ?>
                                            <div class="col-section follow-price">
                                                <div class="project-header text-uppercase">YOUR PAY (IF DOFOLLOW):</div>
                                                <span>$<?php
                                                    $cm_do_price = get_field( 'dofollow_price' );
                                                    $comm_rate = get_field('commission_rate_%','option');
                                                    $author_do_price = $cm_do_price * (1-($comm_rate/100));
                                                    if( $author_do_price > 0) {
                                                        echo $author_do_price;
                                                    } else {
                                                        echo get_post_field( 'owner_price' );
                                                    }
                                                    ?></span>
                                            </div>
                                            <div class="col-section follow-price">
                                                <div class="project-header text-uppercase">YOUR PAY (IF NOFOLLOW):</div>
                                                <span>$<?php
                                                    $cm_no_price = get_field( 'nofollow_price' );
                                                    $comm_rate = get_field('commission_rate_%','option');
                                                    $author_no_price = $cm_no_price * (1-($comm_rate/100));

                                                    echo $author_no_price; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-bid status-bar project-status-bar <?php echo get_post_status(); ?>">
                                <?php
                                //project status:
                                //pending-acceptance (submitted but nothing done with it yet - same as publish
                                //active (paid for, waiting for author to complete) - same as accept
                                //declined
                                //cancelled (author cancels)
                                //pending-completion (completed but still in 30 day period)
                                //completed (after 30 day period, paid and completely done)
                                date_default_timezone_set( 'America/Chicago' );
                                $bid_status      = get_post_status();
                                $bid_status_text = '';


                                if ( $bid_status == 'publish' || $bid_status == 'pending-acceptance' ) {
                                    $bid_status_text = 'Pending Acceptance';
                                } else if ( $bid_status == 'accept' || $bid_status == 'active' ) {
                                    $bid_status_text = 'Active';
                                } else if ( $bid_status == 'declined' ) {
                                    $bid_status_text = 'Declined';
                                } else if ( $bid_status == 'cancelled' ) {
                                    $bid_status_text = 'Cancelled';
                                } else if ( $bid_status == 'deleted' ) {
                                  $bid_status_text = 'Declined';
                                } else if ( $bid_status == 'pending-completion' ) {
                                    $bid_status_text = 'Completed';
                                } else if ( $bid_status == 'completed' ) {
                                    $bid_status_text = 'Completed';
                                } else if ( $bid_status == 'admin-review' ) {
                                    $bid_status_text = 'Active';
                                }

                                ?>

                                <div class="status">
                                    <strong>Contract Status:</strong> <span
                                            class="italic"><?php echo $bid_status_text; ?></span>
                                    <?php if ( $bid_status == 'accept' || $bid_status == 'active' ){ ?>
                                        <a class="cancel-refund inquire-button click-to-modal"><span><i class="fas fa-ban"></i> Cancel this job</span></a>
                                    <?php } ?>
                                </div>
                                <?php if ($bid_status == 'pending-acceptance' || $bid_status == 'publish'): ?>
                                  <a class="withdrawn_btn" href="<?= get_home_url() ?>/my-contracts/?withdrawn=<?= get_the_ID() ?>"><i class="fas fa-question"></i><strong>Withdraw contract</strong></a>
                                <?php endif; ?>

                            </div>
                            <?php
                                    if ( $bid_status == 'accept' || $bid_status == 'active' ){
                                        echo do_shortcode( '[gravityform id=11 title=false description=false ajax=true]' );
                                        //bid id
                            ?>
                                <script>
                                    jQuery("#input_11_2").val("<?php echo $bid_accepted; ?>");
                                    // jQuery(".cancel-refund").click(function () {
                                    //     if(jQuery('#gform_wrapper_11').hasClass('specials-padding')){
                                    //          jQuery("#gform_11").slideToggle();

                                    //          setTimeout(function(){ jQuery('#gform_wrapper_11').removeClass('specials-padding'); }, 300);

                                    //     } else {
                                    //          jQuery('#gform_wrapper_11').addClass('specials-padding');
                                    //          jQuery("#gform_11").slideToggle();
                                    //     }


                                    // })
                                </script>
                            <?php } ?>
                        </div>

                        <?php if ( get_post_status() != 'complete' && get_post_status() != 'publish' && get_post_status() != 'pending-completion' && get_post_status() != 'cancelled' ) { ?>
                        <div class="instructions-and-submit">

                            <p style="margin: 15px 20px 15px 0px"><strong>Your contract was accepted by the client
                                    and you can now start your
                                    work! Here’s what you need to do:</strong></p>
                            <div class="white-bg">
                                <div class="list-item"><span>1</span>Work on writing your article that will be published on
                                    <a><?php echo get_field( 'url_domain', $project->accepted ); ?> </a> <i
                                            class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">Begin (or continue) writing your article. Remember
                                        to make sure your article follows the basic quality checks found in our <a
                                                target="_blank" href="<?= get_site_url(); ?>/link-building-rules">link
                                            building rules</a> and follows the details outlined within your contract
                                        to the client. It’s essential that you write a well-written article
                                        that is not only free of grammatical errors and uses proper English, but also
                                        well-researched, informative, and beneficial to the reader. We want you to write
                                        a masterpiece!
                                    </div>
                                </div>
                                <div class="list-item"><span>2</span>Add the link to the client’s page within
                                    your article <i class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">
                                        <div>Determine how you can best reference the client’s page within
                                            your article and add the link. Make sure the link is relevant and that
                                            you've linked to the client's correct URL. Remember to follow our <a
                                                    target="_blank" href="<?= get_site_url(); ?>/link-building-rules">link
                                                building rules</a> and <a target="_blank"
                                                                          href="<?= get_site_url(); ?>/terms-of-service">terms
                                                of service</a>. If your work does not, this could be grounds for
                                            dismissal from Link-able without payment. We take quality work seriously!
                                        </div>
                                    </div>
                                </div>
                                <div class="list-item"><span>3</span>Submit your work to us for approval <i
                                            class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">Once you’ve finished writing your article and have
                                        added the client’s link within your article, you’ll need to send it to
                                        us for approval. Since quality is imperative, we’ll review your work to ensure
                                        it follows our link building rules and all quality checks. Once approved, you
                                        can then move on to the next step. Please allow us 1 to 2 business days to
                                        review.
                                    </div>
                                </div>
                                <div class="list-item"><span>4</span>Publish your article with the link <i
                                            class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">After your work has been approved, you can now
                                        publish the article! It should contain everything you promised within your
                                        contract, including the correct link attribute and be published within your
                                        promised time frame!
                                    </div>
                                </div>
                                <div class="list-item"><span>5</span>Mark this contract as complete and share the URL of your published article <i
                                            class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">Once your article is finally published and live on
                                        the website, it’s time to mark this contract as complete! Doing so will send
                                        a notification to the client that their link is built and they'll be
                                        able to view it.
                                    </div>
                                </div>
                                <div class="list-item"><span>6</span>Sit back and relax (or work on other contract)
                                    as we verify your work and prepare your payment! <i
                                            class='fa fa-question-circle'></i>
                                    <div class="list-item-expanded">At this point, the hard part is over and the job
                                        should be done! We'll verify your published work to ensure everything is good
                                        and then prepare your payment. Note that you must wait 30 days to ensure the
                                        link remains live and unaltered before your payment is sent.
                                    </div>
                                </div>
                            </div>

                            <?php
                            }
                            $viewing_bid = $project->accepted;
                            //echo $viewing_bid;

                            $current_status = get_post_status( $viewing_bid );

                            $final_link = get_field( 'final_link', $viewing_bid );

                            $timestamp      = get_field( 'completed_date', $viewing_bid );
                            $completed_date = date( "m/d/Y", strtotime( $timestamp ) ); //September 30th, 2013

                            $guar_date = date( 'm/d/Y', strtotime( $timestamp . ' + 30 days' ) );

                            $need_revisions = get_field( 'revisions_needed' );
                            //echo $need_revisions[0];
                            //echo $current_status;

                            ?>
                            <?php if ( ( $current_status == 'pending-completion' ) || ( $current_status == 'complete' ) && ( $current_status !== 'cancelled' ) && ( $current_status !== 'publish' ) ) { ?>

                                <p class="mark-complete completed iem_mark-complete" style="margin-bottom: 20px"><strong>You've marked this contract as complete.
                                        Awesome!</strong></p>
                            <? } else if ( ( $google_docs_url && $current_status == 'accept' && $need_revisions[0] !== "s" ) && ( $current_status != 'cancelled' ) ) { ?>
                                <?php if ( $current_status != 'cancelled' ) { ?>
                                    <p class="mark-complete" style="margin-left: 0px;"><strong>You've submitted your
                                            work to us. Awesome!</strong></p> <?php } ?>
                            <?php } else if ( ( ! ( $google_docs_url ) && $current_status == 'accept' ) || ( $google_docs_url && $current_status == 'accept' && $need_revisions[0] == "yes" ) ) { ?>
                                <p class="mark-complete" style="margin-left: 0px; margin-bottom: 15px;"><strong>Submit your work to us for
                                        approval:</strong></p>

                            <?php } else { ?>
                              <?php if ($current_status != 'publish' && $current_status != 'cancelled'): ?>
                                <p class="mark-complete" style="margin: 15px 20px 15px 0px"><strong>Mark this contract as complete!</strong></p>
                              <?php elseif ($current_status != 'cancelled'): ?>
                                <p class="mark-complete" style="margin: 15px 20px 15px 0px"><strong>Note: If you need to revise the details of this contract, please withdraw it and send the client a new one</strong></p>
                              <?php endif; ?>
                            <?php } ?>

                            <?php if ( ( ( $current_status == 'pending-completion' ) || ( $current_status == 'complete' ) ) && ( $current_status != 'cancelled' )) { ?>
                                <div class="white-bg footer">
                                    <!--<p class="finished-link" style="margin-bottom: 0;"><a class="bold" target="_blank" href="http://<?php echo get_field( 'final_link' ); ?>"><?php echo get_field( 'final_link' ); ?></a></p>-->
                                    <?php if ( ( $current_status == 'pending-completion' ) || ( $current_status == 'complete' ) ) { ?>
                                        <p class="mark-complete completed text-capitalize"><i class="fa fa-check-square"></i>Marked as Completed</p>
                                        <p class="website-link margin-bottom-15 click-to-copy-wrapper" style="font-size: 20px;max-width: 380px;margin-left: 0;">
                                            <span class="click-to-copy bold green"><?php echo $final_link; ?></span>
                                        </p>
                                        <p>We will verify the work and send a notification to the client that
                                            their link is now live. As <a target="_blank"
                                                                          href="<?php echo get_home_url(); ?>/terms-of-service/">per
                                                our terms</a>, we require a 30-day wait period to ensure the link
                                            remains active before releasing your payment.</p>
                                        <div class="completed-project-summary">
                                            <div class="col">
                                                <span class="project-header">COMPLETED DATE:</span>
                                                <span><?php echo $completed_date; ?></span>
                                            </div>
                                            <div class="col">
                                                <span class="project-header">GUARANTEE DATE:</span>
                                                <span><?php echo $guar_date; ?></span>
                                            </div>
                                            <div class="col">
                                                <span class="project-header">ESTIMATED PAYMENT DATE:</span>
                                                <span>1-7 days after Guarantee Date</span>
                                            </div>
                                        </div>


                                    <?php } ?>
                                </div>

                            <?php } else if ( ($current_status != 'cancelled') && ($current_status != 'publish') ){ ?>

                                <div class="white-bg footer" style="margin-left: -20px;margin-right:-20px;">
                                    <?php

                                    $google_docs_url = get_field( 'google_doc_link' );

                                    if ( $google_docs_url && get_post_status() == 'admin-review' ) {
                                        echo do_shortcode( '[gravityform id=6 title=false description=false]' );
                                    } else if ( $google_docs_url && get_post_status() == 'accept' && $need_revisions[0] !== 'yes' ) {
                                        echo '<p class="mark-complete completed" style="text-transform: none;"><i class="fa fa-hourglass-half"></i>Your work has been submitted and is pending approval</p>
                <p class="website-link" style="margin-bottom: 5px;"><a>' . $google_docs_url . '</a></p>
            <p>We will review your work and add comments to address any needed edits or issues. This typically takes 1 business day. You will recieve an automatic email notifcation once we’re finished reviewing. Please contact support immediately if your work has been pending approval for longer than 2 business days.</p>';

                                    } else {

                                        echo do_shortcode( '[gravityform id=16 title=false description=false]' );
                                    } ?>
                                </div>
                                <!-- <p class="have-a-problem 1" style="margin-left: -20px;">Have a problem with this
                                    contract? <a href="<?php echo get_home_url(); ?>/help-and-support/">Contact
                                        us</a> or <a class="cancel-refund">cancel & refund</a> this contract for the
                                    client.</p> -->


                            <?php } ?>
                        </div>
                        <?php if ( get_post_status() == 'deleted' ) { ?>
                          <p class="cancelled-message" style="margin-left: 0px; margin-bottom: 15px;">This contract was declined by client and is no longer active. Here is the provided reason:</p>
                          <?php if (get_field( 'declination_reason' )): ?>
                            <div class="white-bg footer">
                                <?php echo get_field( 'declination_reason' ); ?>
                            </div>
                          <?php endif; ?>
                        <?php } ?>
                        <script>

                            jQuery("#input_6_3").val(<?php echo $project->accepted; ?>);

                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        if (jQuery("#gform_confirmation_message_11").length) {
            jQuery(".project-intro-wrap").hide();
            jQuery(".project-detail-box").hide();
            jQuery(".instructions-and-submit .white-bg").hide();
            jQuery(".instructions-and-submit p:first-child").hide();
            jQuery(".mark-complete").hide();
            jQuery(".have-a-problem").hide();

            jQuery(".freelancer.single-project h1").css("margin-left", "0px");
            jQuery(".instructions-and-submit").css("padding-left", "0px");

        }

        jQuery(document).on('gform_post_render', function () {
            jQuery("#field_16_1 .gfield_description").insertAfter("#gform_wrapper_16 .gform_footer");
        });


    </script>
<?php }


get_footer();