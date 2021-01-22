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
$currency               = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );
$comment_for_freelancer = get_comments( array(
	'type'    => 'em_review',
	'status'  => 'approve',
	'post_id' => $bid_accepted
) );

$comment_for_employer   = get_comments( array(
	'type'    => 'fre_review',
	'status'  => 'approve',
	'post_id' => get_the_ID()
) );

$freelancer_info = get_userdata($bid_accepted_author);
$ae_users  = AE_Users::get_instance();
$freelancer_data = $ae_users->convert( $freelancer_info->data );
?>

<div class="project-intro-wrap">

	<a class="button shortcode-button back-my-projects" href="<?php get_home_url(); ?>/my-projects/"><i class="fa fa-arrow-left"></i>Go back to My Projects</a>
	
	<p class="project-summary">Project Summary</p>
	
</div>

<?php
if ( ( fre_share_role() || $role == FREELANCER ) && $project_status == 'complete' && ! empty( $comment_for_freelancer ) ) { ?>

<?php } else if ( ( fre_share_role() || $role == EMPLOYER ) && $project_status == 'complete' && ! empty( $comment_for_employer ) ) { ?>
    <div class="project-detail-box">
        <div class="project-employer-review">
            <span class="employer-avatar-review"><?php echo $freelancer_data->avatar; ?></span>
            <h2><a href="<?php echo $freelancer_data->author_url; ?>" target="_blank"><?php echo $freelancer_data->display_name; ?></a>
            </h2>
            <p><?php echo '"' . $comment_for_employer[0]->comment_content . '"'; ?></p>
            <div class="rate-it"
                 data-score="<?php echo get_comment_meta( $comment_for_employer[0]->comment_ID, 'et_rate', true ); ?>"></div>
        </div>
    </div>
<?php } ?>


<div class="project-detail-box">
    <div class="project-detail-info">
        <div class="row">
	        <?php //print_r($convert); ?>
	        <div class="project-top-bar">
		       <div class="left-bar">
			       <?php /*echo '<pre>';
				       print_r($project); 
				       echo '</pre>';*/ ?>
			        <div class="col-section"><div class="project-header">Category</div> <?php $terms = get_the_terms( $convert->post_parent, 'project_category' ); 
																				    foreach($terms as $term) {
																				      echo $term->name;
																				    } ?></div>
			        <div class="col-section"><div class="project-header">Proposed Link On</div><span class="proposed-url"><?php echo get_field('url_domain',$project->accepted); ?></span></div>
			        <div class="col-section"><div class="project-header">Price</div>$<?php echo get_post_meta($project->accepted, 'owner_price',true); ?></div>
			        <div class="col-section"><div class="project-header">Status</div><?php
		                    $status_arr = array(
			                    'close'     => __( "Active", ET_DOMAIN ),
			                    'complete'  => __( "Completed", ET_DOMAIN ),
			                    'disputing' => __( "Disputed", ET_DOMAIN ),
			                    'disputed'  => __( "Resolved", ET_DOMAIN ),
			                    'publish'   => __( "Active", ET_DOMAIN ),
			                    'pending'   => __( "Pending", ET_DOMAIN ),
			                    'draft'     => __( "Draft", ET_DOMAIN ),
			                    'reject'    => __( "Rejected", ET_DOMAIN ),
			                    'archive'   => __( "Archived", ET_DOMAIN ),
			                    'pending-completion'   => __( "Pending Completion", ET_DOMAIN )
		                    );
		                    echo $status_arr[ $post->post_status ];
		                    ?></div>
		       </div>
	        </div>
                    
            <div class="single-project-description-section">
	            <div><div class="project-header">Description</div><?php echo the_content(); ?></div>
	            <div><div class="project-header">Details and Requirements</div><?php echo get_field('linkable_ideas',$project->ID);?></div>
	            <div><div class="project-header">Link Attribute</div><?php 
		      
		            if (get_field('follow_type',$project->accepted) == "No preference" ) {
			            echo 'NoFollow or DoFollow';
		            } else {
		            echo get_field('follow_type',$project->accepted); }?></div>
            </div>
			<div class="single-project-bottom-bar">
	             <div><div class="project-header">Content Marketer's URL</div><?php echo get_field('url_of_page_you_want_to_build_a_link_to',$project->ID);?></div>
	            <div><?php 
		            //date posted
		            //add time from how long to get due date
		            $time_left = 0;
		            $date_posted = get_the_date();
		            $how_long = get_field('how_long',$project->accepted); 
	
		            if ($how_long =='Less than 2 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 14 days'));
		            } else if ($how_long =='4-8 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 56 days'));
		            } else {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 28 days'));
		            }
		            
		            //echo $how_long;
		            //echo $due_date;
		            $today = time();
		            
		            //echo $today;
		            
		            $due_date = strtotime($due_date);
		            $datediff = $due_date - $today;
		            echo "<div class='days-left'><i class='fa fa-calendar-alt'></i>" . abs(floor($datediff / (60 * 60 * 24))) . " days left to complete</div>";
					
		            ?></div>
			</div>
	        
	        
	        
        </div>
    </div>
</div>
	

<div class="instructions-and-submit">
	
	<p><strong>Your application has been accepted by the Content Marketer and this project is now active! Here’s what you need to do:</strong></p>
	<div class="white-bg">
		<div class="list-item"><span>1</span>Work on writing your article for <a href="http://<?php echo get_field('url_domain',$project->accepted); ?>" target="_blank"><?php echo get_field('url_domain',$project->accepted); ?> </a> <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Remember to make sure your article is about the topic you described in your application to the Content Marketer.</div>
		</div>
		<div class="list-item"><span>2</span>Add the Content Marketer’s link within your article <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Make sure the link is relevant and you’ve used the correct Content Marketer’s URL (listen above). 
Remember to follow our Link Building rules and terms and conditions.</div>
		</div>
		<div class="list-item"><span>3</span>Publish the article with the link <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">The article will need to be published on the correct domain you promised, with a link to the correct Content Marketer’s URL.</div>
		</div>
		<div class="list-item"><span>4</span>Mark this project as complete and share the URL of your published article <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Both us and the Content Marketer will need to view your article to ensure the correct link has been used.</div>
		</div>
		<div class="list-item"><span>5</span>Sit back and relax (or work on other projects) as we verify the work and release your payment! <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Before we release your payment, we will need to verify your work to ensure quality for the Content Marketer. 
Fuurthermore, we must wait 30 days to ensure the link remains live and adhere to our 30 day guarantee for Content Marketers.</div>
		</div>
	</div>
	
	<?php 
		
		$viewing_bid = $project->accepted;
		//echo $viewing_bid;

		$current_status = get_post_status($viewing_bid);
		
		$final_link = get_field('final_link',$viewing_bid);
		
		$timestamp = get_field('completed_date',$viewing_bid); 
		$completed_date = date("m/j/Y", strtotime($timestamp)); //September 30th, 2013
		
		$guar_date = date('m/j/Y', strtotime($timestamp. ' + 30 days'))
		
		
		 ?>
	<?php if (($current_status == 'pending-completion') || ($current_status == 'complete')) { ?>
		<p class="mark-complete completed"><strong>You've marked this project as complete. Awesome!</strong></p>
	<?php } else { ?>
		<p class="mark-complete"><strong>Mark this project as complete!</strong></p>
	<?php } ?>

	<?php if (($current_status == 'pending-completion') || ($current_status == 'complete')) { ?>
		<div class="white-bg footer">
			<!--<p class="finished-link" style="margin-bottom: 0;"><a class="bold" target="_blank" href="http://<?php echo get_field('final_link');?>"><?php echo get_field('final_link');?></a></p>-->
			<?php if (($current_status == 'pending-completion')) { ?>
				<p class="mark-complete completed"><strong><i class="fa fa-check"></i>Marked as Completed</strong></p>
				<p class="website-link"><a href="<?php echo $final_link; ?>" target="_blank"><?php echo $final_link; ?></a></p>
			<p>We will verify the work and send a notification to the client that their link is now live. As <a href="#">per our terms</a>, we require a 30-day wait period to ensure the link remains active before releasing your payment.</p>
			<div class="completed-project-summary">
				<div class="col">
					<span class="project-header">COMPLETED DATE:</span>
					<span><?php echo $completed_date;?></span>
				</div>
				<div class="col">
					<span class="project-header">GUARANTEE DATE:</span>
					<span><?php echo $guar_date;?></span>
				</div>
				<div class="col">
					<span class="project-header">ESTIMATED PAYMENT DATE:</span>
					<span>1-7 days after Guarantee Date</span>
				</div>
			</div>
			
			
			
<?php } ?>
		</div>
	
	<?php } else { ?>
	
	<div class="white-bg footer">
		<?php echo do_shortcode('[gravityform id=6 title=false description=false]'); ?>
	</div>
	<p class="have-a-problem">Have a problem with this project? <a href="<?php echo get_home_url(); ?>/help-and-support/">Contact us</a> or <a class="cancel-refund">cancel & refund</a> this project for Content Marketer.</p>
	
	<?php 

		echo do_shortcode('[gravityform id=11 title=false description=false]'); 
				//bid id		
				
		?>
		<script>
			jQuery("#input_11_2").val("<?php echo $bid_accepted; ?>");
			jQuery(".cancel-refund").click(function(){
				jQuery("#gform_11").slideToggle();
			})
		</script>
	<?php } ?>
</div>

<script>

jQuery("#input_6_3").val(<?php echo $project->accepted; ?>);

</script>