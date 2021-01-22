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
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}


if (!is_user_logged_in()) {
		wp_redirect(get_home_url() . '/login/');	
}

get_header();
$current_page = $post->ID;
$shown_project = 'Project <span class="form-bid-id">' . $current_page.'</span>';
$user_role = ae_user_role( $user_ID );

if(ae_user_role() == EMPLOYER) {
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
										'posts_per_page'   => -1
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

	?>
	


<style>
	.dashboard-sidebar > ul > li:nth-child(2) a {
		color: white;
		font-weight: bold;
	}
	
	.dashboard-sidebar > ul > li:nth-child(2) a i {
		color: #1aad4b;
	}
	
</style>


<div class="entry-content landing-entry-content">
<?php 
	
	
		if( $user_role == 'administrator'){
			
			} else if(get_the_author_id() !== $user_ID) {

	    	wp_redirect(get_home_url() . '/dashboard/');
	    	}
	    

		get_template_part( 'dashboard-side-nav');
		


	?>
    <div class="main-dashboard-content dashboard-landing inner-dashboard">

	    
    <div class="fre-page-wrapper">
        <div class="container">
	        <h1><?php echo get_the_title(); ?></h1>

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

	<a class="button shortcode-button back-my-projects" href="<?php echo get_home_url(); ?>/my-applications/"><i class="fa fa-arrow-left"></i>Go back to My Applications</a>
	
	<p class="project-summary">Project Summary</p>
	
</div>

<?php //print_r($project); ?>

<?php //echo $project->post_parent;
	$parent_project = $project->post_parent;
	 ?>

<div class="project-detail-box">
    <div class="project-detail-info">
        <div class="row">
	        <?php //print_r($convert); ?>
	        <div class="project-top-bar">
		       <div class="left-bar">
			       <?php 
				       //echo get_post_status();
				       /*echo '<pre>'; 
				       
				       print_r($project); 
				       echo '</pre>';*/ ?>
			        <div class="col-section"><div class="project-header">Category</div> <?php $terms = get_the_terms( $convert->post_parent, 'project_category' ); 
																				    foreach($terms as $term) {
																				      echo $term->name;
																				    } ?></div>
			        <div class="col-section"><div class="project-header">Proposed Link On</div><span class="proposed-url"><?php echo get_field('url_domain'); ?></span></div>
			        <div class="col-section"><div class="project-header">Link Attribute</div><span class="link-attribute"><?php echo get_field('follow_type'); ?></span></div>
			        <div class="col-section"><div class="project-header">Price</div>$<?php echo get_field('owner_price'); ?></div>
			      <?php  
				  
				      if(get_post_status() == 'accept' || get_post_status() == 'complete' || get_post_status() == 'pending-completion' || get_post_status() == 'completed') { ?>
			        <div class="col-section"><div class="project-header">Application Accepted</div>
		                   <?php 
			                   $timestamp = get_field('date_accepted');
			                   
			                
							   $completed_date = date("m/j/Y", strtotime($timestamp));
							   
							  echo $completed_date;
			                 /*
			                  $str = get_field('date_accepted');
			                  $date_string =  DateTime::createFromFormat('d/m/Y', $str);
			                  echo $date_string->format('m/d/Y');*/
			                   	 ?>
			                  
		                    </div>
		                    <?php  	}?>
		       </div>
	        </div>
                    
            <div class="single-project-description-section">
	            <div><div class="project-header">Description</div><?php echo get_post_field('post_content', $parent_project);?></div>
	            <div><div class="project-header">Linkable Ideas</div><?php echo get_field('linkable_ideas',$parent_project);?></div>
	            <div><div class="project-header">Website Owner's URL</div><span class="bold green"><?php echo get_field('url_of_page_you_want_to_build_a_link_to',$parent_project);?></span></div>
            </div>
			<div class="single-project-bottom-bar">
	             <div><div class="project-header">Your Application</div><?php echo get_field('proposal');?></div>
	               <div><div class="project-header">Your Promised Timeframe</div><?php echo get_field('how_long');?></div>
			</div>
			<div class="single-bid status-bar project-status-bar">
				<?php
					//project status:
					//pending-acceptance (submitted but nothing done with it yet - same as publish
					//active (paid for, waiting for author to complete) - same as accept
					//declined
					//cancelled (author cancels)
					//pending-completion (completed but still in 30 day period)
					//completed (after 30 day period, paid and completely done)
					date_default_timezone_set('America/Chicago');
					$bid_status = get_post_status();
					$bid_status_text = '';
					
					
					if($bid_status == 'publish' || $bid_status=='pending-acceptance') {
						$bid_status_text = 'Pending Acceptance';
					} else if ($bid_status == 'accept' || $bid_status =='active') {
						$bid_status_text = 'Active';
					} else if( $bid_status == 'declined') {
						$bid_status_text = 'Declined';
					} else if ($bid_status == 'cancelled') {
						$bid_status_text = 'Cancelled';
					} else if ($bid_status == 'pending-completion') {
						$bid_status_text = 'Completed';
					} else if ($bid_status == 'completed') {
						$bid_status_text = 'Completed';
					}
					
					?>
				
				<div class="status"><strong>Project Status:</strong> <span class="italic"><?php echo $bid_status_text; ?></span></div>
	            <div><?php 
		            //date posted
		            //add time from how long to get due date
		            $time_left = 0;
		            $date_posted = get_the_date();
		            $how_long = get_field('how_long'); 
	
		            if ($how_long =='Less than 2 weeks' || $how_long == '1 to 2 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 14 days'));
		            } else if ($how_long =='2 to 3 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 21 days'));
		            } else if ($how_long =='4 to 6 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 42 days'));
		            } else if ($how_long =='7 to 8 weeks') {
			            $due_date = date('Y-m-d', strtotime($date_posted. ' + 56 days'));
			            }
		            
		            //echo $how_long;
		            //echo $due_date;
		            $today = time();
		            
		            //echo $today;
		            
		            $due_date = strtotime($due_date);
		            $datediff = $due_date - $today;
		            if(get_post_status() == 'active' || get_post_status() == 'accept'){
		            echo "<div class='days-left'><i class='fa fa-calendar-alt'></i>" . abs(floor($datediff / (60 * 60 * 24))) . " days left to complete</div>";
		            }
					
		            ?></div>
			</div>
	        
	        
	        
        </div>
    </div>
</div>
	
<?php if( get_post_status() != 'complete' && get_post_status() != 'pending-completion') { ?>
<div class="instructions-and-submit">
	
	<p><strong>Your application has been accepted by the Website Owner and this project is now active! Here’s what you need to do:</strong></p>
	<div class="white-bg">
		<div class="list-item"><span>1</span>Work on writing your article for <a><?php echo get_field('url_domain',$project->accepted); ?> </a> <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Remember to make sure your article is about the topic you described in your application to the Website Owner.</div>
		</div>
		<div class="list-item"><span>2</span>Add the Website Owner’s link within your article <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Make sure the link is relevant and you’ve used the correct Website Owner’s URL (as shown in the Project Summary above). Remember to follow our <a href="/link-building-rules" target="_blank">link building rules</a> and <a href="/terms-of-service" target="_blank">terms of service</a>. If your work does not, this could be grounds for dismissal from Link-able without payment. We take quality work seriously! </div>
		</div>
		<div class="list-item"><span>3</span>Publish the article with the link <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">The article will need to be published on the same domain you promised on your application, with a link to the correct Website Owner’s URL.</div>
		</div>
		<div class="list-item"><span>4</span>Mark this project as complete and share the URL of your published article <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Both us and the Website Owner will need to view your article to ensure the correct link has been used.</div>
		</div>
		<div class="list-item"><span>5</span>Sit back and relax (or work on other projects) as we verify the work and release your payment! <i class='fa fa-question-circle'></i>
			<div class="list-item-expanded">Before we release your payment, we will need to verify your work to ensure quality for the Website Owner. 
Furthermore, we must wait 30 days to ensure the link remains live and adhere to our 30 day guarantee for Website Owners.</div>
		</div>
	</div>
	
	<?php 
		}
		
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
		<p class="mark-complete" style="margin-left: -20px;"><strong>Mark this project as complete!</strong></p>
	<?php } ?>

	<?php if (($current_status == 'pending-completion') || ($current_status == 'complete')) { ?>
		<div class="white-bg footer">
			<!--<p class="finished-link" style="margin-bottom: 0;"><a class="bold" target="_blank" href="http://<?php echo get_field('final_link');?>"><?php echo get_field('final_link');?></a></p>-->
			<?php if (($current_status == 'pending-completion') || ($current_status == 'complete')) { ?>
				<p class="mark-complete completed"><strong><i class="fa fa-check"></i>Marked as Completed</strong></p>
				<p class="website-link"><a><?php echo $final_link; ?></a></p>
			<p>We will verify the work and send a notification to the Website Owner that their link is now live. As <a href="<?php echo get_home_url(); ?>/terms-of-service/">per our terms</a>, we require a 30-day wait period to ensure the link remains active before releasing your payment.</p>
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
	
	<div class="white-bg footer" style="margin-left: -20px;">
		<?php echo do_shortcode('[gravityform id=6 title=false description=false]'); ?>
	</div>
	<p class="have-a-problem" style="margin-left: -20px;">Have a problem with this project? <a href="<?php echo get_home_url(); ?>/help-and-support/">Contact us</a> or <a class="cancel-refund">cancel & refund</a> this project for website owner.</p>
	
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
	
            </div>
        </div>
    </div>
    </div>
</div>

													<script>
														
if(jQuery("#gform_confirmation_message_11").length) {
		jQuery(".project-intro-wrap").hide();
		jQuery(".project-detail-box").hide();
		jQuery(".instructions-and-submit .white-bg").hide();
		jQuery(".instructions-and-submit p:first-child").hide();
		jQuery(".mark-complete").hide();
		jQuery(".have-a-problem").hide();
		
		jQuery(".freelancer.single-project h1").css("margin-left","0px");
		jQuery(".instructions-and-submit").css("padding-left","0px");
		
	};


	</script>
<?php }
	
	
get_footer();