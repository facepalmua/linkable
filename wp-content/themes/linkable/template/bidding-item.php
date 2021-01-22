<?php
/**
 * The template for displaying a bid info item,
 * this template is used to display bid info in a project details,
 * and called at template/list-bids.php
 * @since 1.0
 * @author Dakachi
 */
global $wp_query, $ae_post_factory, $post, $user_ID, $show_bid_info;
$project_object = $ae_post_factory->get( PROJECT );
$project        = $project_object->current_post;
$post_object    = $ae_post_factory->get( BID );
$convert        = $post_object->convert( $post );
$project_status = $project->post_status;
$user_role      = ae_user_role( $user_ID );
$author_data      = get_userdata($convert->post_author);
$price_in_num = $convert->bid_budget;
$price_in_num = ltrim( $price_in_num, '$' );

//$convert->post_status;
//echo $GLOBALS['wp_query']->request;
$rated_class = '';
if ( get_field( 'rated_by_website_owner' ) == 1 ) {
    $rated_class = "author-rated";
}

if ( $convert->post_status != 'deleted' ) {

    if ( $convert->post_status == 'admin-review' ) {
        $post_class = 'accept';
    } else {
        $post_class = $convert->post_status;
    }

    ?>

    <?php //print_r($project); ?>
    <div data-id="<?= $project->ID ?>" class="project-detail-box bid-box ie-bid-box <?php echo $post_class;
    echo ' ';
    echo $rated_class; ?>">
        <div class="project-description url-for-author">
            <?php $url_domain = get_field( 'url_domain', $convert->ID );
            $url_domain       = str_replace( parse_url( $url_domain, PHP_URL_SCHEME ) . '://', '', $url_domain );
            $url_domain       = preg_replace( "(/)", "", $url_domain );
            $url_domain       = preg_replace( "(www.)", "", $url_domain );

            echo '<div class="url-expires-wrapper">';
            echo '<div class="app-url"><!--<span class="new">NEW!</span>-->' . $url_domain;

            ?>
            <span>(DA of <?php
                $da_field = rtrim( get_field( 'domain_authority', $convert->ID ) );
                echo $da_field;
                ?>)</span>
        </div>
        <?php
        // if( $convert->post_status == 'publish' ) {
        // echo do_shortcode( '[gravityform id="21" title="false" description="false" ajax="false"]' );
        /*
        <div class="expires"><i class="fas fa-comments"></i> Have a question or need more details? <a> Ask the author</a></div>
    <?php } else { */ ?>
        <div class="expires la_message_author">
            <?php echo get_avatar( $author_data->ID, 35 ) ?>
            <span class="bold"><?= get_short_username( $author_data ); ?><br><a href="<?= get_site_url(); ?>/messages/?a_id=<?= $author_data->ID; ?>&p_id=<?= $project->ID; ?>" target="_blank"><?php esc_html_e('Message Author', 'link-able'); ?></a></span>
        </div>
        <?php /* } */ ?>
    </div>


    </div>
    <?php
    //dynamically populate rating form
    echo '<div class="hidden project-id">' . get_the_ID() . '</div>';
    echo '<div class="hidden author-id">' . $convert->post_author . '</div>';

//$url_domain = get_field('url_domain',$convert->ID);

//$url_domain = preg_replace("(^https?://)", "", $url_domain );

    ?>


    <div class="delete-hide-menu">
        <i class="fa fa-times owner-deletion"></i>
        <div class="delete-dropdown edit-ellipses-popup">
            <a class="owner-delete-project owner-delete-bid">Decline & Hide</a>
        </div>
    </div>

    <div class="project-description content-author">
        <!-- <div class="project-header">Content Author's Rating</div>

		  <div class="col-free-reputation">
		<?php //echo print_r(freelancer_rating_score(64));
        $rating = freelancer_rating_score( $convert->post_author );
        ?>

	                    <div class="rate-it" data-score="<?php echo $rating['rating_score']; ?>"></div>
	                    <a class='question-mark'>What's this?</a>

	                </div>
		  <div class='list-item expand-me'>This is the rating other Content Marketers have given this Content Author from previous projects. The rating is based on a scale from 1 to 5 (where 5 is the best) and is meant to help indicate their satisfaction level with the results of this particular Content Author. If there is no rating, it means that the Content Author may be new and has not received any feedback/rating yet.</div> -->


        <div class="project-description no-underline">
            <div class="project-header">AUTHOR’S PROPOSAL:</div>
            <?php echo get_field( 'proposal', $convert->ID ); ?>
        </div>
        <div class="project-description no-underline">
            <div class="project-header">YOUR PAGE THE AUTHOR WILL LINK TO:</div>
            <?php
            $author_will_link = get_post_meta( $convert->ID, 'url_of_page_you_want_to_build_a_link_to', true );
            if( !empty( $author_will_link ) ) {
                echo '<span class="bold green click-to-copy-wrapper"><span class="click-to-copy">' . $author_will_link . '</span></span>';
            } else {
                echo '<i>Not added!</i>';
            } ?>
        </div>
    </div>

    <div class="project-description here-is-what">Here's what you get:</div>

    <div class="bid-section-details">

        <div class="project-description no-underline" style="word-break: break-all;">

            <div class="project-header">A backlink on:</div>
            <?php echo $url_domain; ?>

        </div>

        <div class="project-description no-underline" style="word-break: break-all;">

            <div class="project-header">Domain Authority:</div>
            <?php echo $da_field; ?>

        </div>

        <div class="project-description no-underline">
            <div class="project-header">Estimated Time Frame:</div>
            <?php echo get_field( 'how_long', $convert->ID ); ?>

        </div>

        <div class="project-description no-underline follow-price">
            <div class="project-header">Price (If DoFollow):</div>
            <span class="bold green">$<?php
                $do_price =  get_field( 'dofollow_price', $convert->ID );

                if ($do_price > 0) {
                    echo $do_price;
                } else {
                    echo get_post_field( 'bid_budget' );
                }

                ?></span>

        </div>

        <div class="project-description no-underline follow-price">
            <div class="project-header">Price (If NoFollow):</div>
            <span class="bold green">$<?php echo get_field( 'nofollow_price', $convert->ID ); ?></span>

        </div>


        <div class="project-description no-underline pricing-bids guar">
            <div class="pricing">
                <div class="project-header">Our Link-able Guarantee:</div>
                <span>Always included. <a class="green" href="javascript:void(0);">What's this <i class="fa fa-caret-right"></i></a>
            </div>

        </div>

        <div class="guarantee-big-text">
            <?php echo get_field( 'guarantee_text', 'option' ); ?>
        </div>


    </div>
    <div class="info-for-purchase ie_info-purchase">

        <div class="link-da-notice" style="word-break: break-all;">
            <?php /*
			$url_domain = rtrim( $url_domain, '/' );
			$url_domain = str_replace( 'www.', '', $url_domain );
			echo $url_domain; ?> <span>(DA of <?php
				$da_field = rtrim( get_field( 'domain_authority', $convert->ID ) );
				echo $da_field;
				?>)</span>
            */ ?>
        </div>
        <a class="pending-acceptance"><i class="fas fa-question"></i><strong>Pending your acceptance</strong></a>
        <div class="add-to-cart" value="<?php echo $convert->ID; ?>">
            <div class="accept-decline"><span class="pls">Please accept or decline:</span>
                <a class="accept-app"><span>Accept</span> <i class="fas fa-check-circle"></i></a>
                <a class="decline-app">Decline <i class="fas fa-times-circle"></i></a>
                <?php
                if ( $convert->post_status != 'complete' && $convert->post_status != 'pending-completion' ) {
                    echo do_shortcode( '[gravityform id=15 ajax=true title=false description=false]' );

                }
                ?>
                <script>
                    jQuery("#gform_wrapper_15").hide();
                </script>
            </div>
            <input type="checkbox" name="add-bid-to-cart"/><label>Select this contract</label>
            <div class="price-for-cart"><?php echo $price_in_num; ?></div>
            <div class="bid-id"><?php echo $convert->ID; ?></div>
            <?php

            ?>
        </div>
        <!-- <div class="info-for-cart">
            - Link to <?php echo $url_domain; //echo get_field('url_domain',$convert->ID); ?> - Link DA
            of <?php echo get_field( 'domain_authority', $convert->ID ); ?> - $<?php echo $price_in_num; ?>
        </div> -->
        <div class="info-for-cart">
          Author contract #<?= $convert->ID ?> - backlink on <?= $url_domain ?> - $<?= $price_in_num ?>
        </div>
    </div>

    <div class="application-status <?php echo $post_class ?>">
        <div class="author-app-popup">
            <?php
            if ( $convert->post_status == 'complete' || $convert->post_status == 'pending-completion' ) {
                echo do_shortcode( '[gravityform id="12" title="false" description="false" ajax="false"]' );
            }
            ?>
        </div>
        <?php if ( $convert->post_status == 'complete' || $convert->post_status == 'pending-completion' ) {
            echo '<div class="complete-status">';
            echo '<div class="msg">';
            echo '<strong>Status:</strong> <span class="italic">Completed</span> ';
            echo '</div>';
            echo '<div class="link-and-rate">';


            echo '<a class="show-review-form"><i class="fas fa-question"></i><strong>Rate & review author</strong></a>';

            echo '<div class="final-link-toggle">';
            echo '</div>';


            echo '</div>';
            echo '<div class="single-project-bidding-item-copy">';
            echo '<div class="click-to-copy-wrapper">';
            echo '<div class="final-link-text green click-to-copy"><i class="fa fa-link"></i>' . get_field( 'final_link', $convert->ID ) . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else if ( $post_class == 'accept' ) {
            $time_left   = 0;
            $date_posted = get_field( 'date_accepted', $convert->ID );
            $how_long    = get_field( 'how_long', $convert->ID );
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

            //echo $today;
            $due_date   = strtotime( $due_date );
            $datediff   = $due_date - $today;
            $days_left  = floor( $datediff / ( 60 * 60 * 24 ) );
            $days_label = 'days';
            if ( $days_left == 1 ) {
                $days_label = 'day';
            }
            echo '<div class="status-msg"><strong>Status:</strong> <span class="italic">Active - The author is working on building your link... Please be patient.</span></div><div class="expiration-msg text-uppercase bold"><i class="fas fa-calendar-alt"></i> ETA: ' . $days_left . ' ' . $days_label . ' left until completion</div>';

        } else if ( $convert->post_status == 'cancelled' ) {
            echo '<strong>Status:</strong> <span class="italic">Cancelled - This contract was canceled by the author.</span>';
        } ?>
    </div>
    </div>
    <?php if ( $convert->post_status == 'complete' || $convert->post_status == 'pending-completion' ): ?>
      <?php if (is_page(12714)): ?>
        <?php
        $timestamp      = get_field( 'completed_date', $convert->ID );
        $completed_date = date( "m/d/Y", strtotime( $timestamp ) ); //September 30th, 2013
        $guar_date = date( 'm/d/Y', strtotime( $timestamp . ' + 30 days' ) );
        ?>
        <p class="submessage">The author has completed this contract and your link has been built!</p>
        <div class="completed-project-summary completed-ps-ac">
            <div class="link_result">
              <?= get_field('final_link'); ?>
            </div>
            <div class="col">
                <span class="project-header">COMPLETED DATE:</span>
                <span><?php echo $completed_date; ?></span>
            </div>
            <div class="col">
                <span class="project-header">GUARANTEE DATE:</span>
                <span><?php echo $guar_date; ?></span>
            </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
<?php } ?>

<script type="text/javascript">

    jQuery(window).load(function () {

        //author ID
        jQuery(".project-detail-box").each(function () {
            var authorID = jQuery(this).find(".hidden.author-id").text();
            jQuery(this).find("#input_12_2").val(authorID);
        });

        jQuery(".delete-explanation").each(function () {
            var appending = jQuery(this).closest("#gform_15").find(".gform_body");
            jQuery(this).prependTo(appending);
        })


        // code to trigger on AJAX form render


    });

    jQuery(document).on('gform_post_render', function () {
        jQuery("#gform_15 .gform_footer").each(function () {
            var gBody = jQuery(this).prev();
            var field = gBody.find("#field_15_5");
            jQuery(this).insertBefore(field);
        })


        var valError = jQuery("#gform_15").find(".validation_error");

        if (valError.length > 0) {
            console.log('there is an error');


            jQuery("#gform_15 #gform_fields_15").each(function () {
                var alreadyError = jQuery(this).find(".decline-val-error");

                if (alreadyError.length > 0) {

                } else {
                    jQuery(this).append("<span class='decline-val-error' style='color:red;font-weight:bold;'>This field is required</span>");
                }

            })
        }


    });

</script>
