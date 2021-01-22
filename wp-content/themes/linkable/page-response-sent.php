<?php
/**
 * Template Name: Response Sent */
$sent = false;

get_header();

		
						

						//mark inquiry row in project as interested
						$row_id = $_GET['row_id'];
						$project_id = $_GET['project_id'];
						$author_id = $_GET['author_id'];
						$table_index = $row_id - 1;
						
						
						$author_info = get_userdata($author_id);
						$author_first_name = $author_info->first_name;
						$author_email = $author_info->user_email;

						
						$project_name = get_the_title($project_id);
						$project_link = get_the_permalink($project_id);
						$domain = get_post_meta($project_id,'inquiries_made_for_this_project_'.$table_index.'_url')[0];
						$follow_type = get_post_meta($project_id,'inquiries_made_for_this_project_'.$table_index.'_follow_type')[0];
						
						
						update_sub_field( array('inquiries_made_for_this_project',$row_id,'cm_interested'), true, $project_id);
						
						$interested_field = get_post_meta($project_id,'inquiries_made_for_this_project_'.$table_index.'_cm_interested')[0];
						//populate email body for author
						$email = '<p>Hi '.$author_first_name.',</p>';
						$email .= '<p>Good news! The CM has responded back to your inquiry and is interested.</p>';
						$email .= '<p><a href="'.$project_link.'">'.$project_name.'</a> <strong>is interested in a backlink on</strong> '.$domain.' ('.$follow_type.')</p>';
						$email .= '<p><strong>What to do?</strong></p>';
						$email .= '<p>Now that we know the CM is interested in this particular domain, you\'ll need to login and apply to this project with a well-written application to seal the deal!</p>';
						$email .= '<p><a href="'.$project_link.'">Apply to this project now</a></p>';
						$email .= '<p>Don\'t keep the CM waiting! Also, remember to <a href="https://link-able.com/how-to-effectively-apply-to-projects/">check out our guide</a> for the latest tips on how to effectively apply to projects.</p>';
						$email .= '<p>Cheers!</p>';
						$email .= '<p>The Link-able Team</p>';
						
						//echo $email;
						
						//send email to author
						$headers = array(
						    'Content-Type: text/html; charset=UTF-8',
						    'From: Link-able <noreply@link-able.com>'
					    );
					    
					    
					    if($sent == false && $interested_field !== true) {
					    	wp_mail($author_email, 'A CM is Interested in Your Inquiry', $email, $headers);
					    	$sent = true;
					    }

?>
	<?php if( get_field('styled_class_text') ) { ?>
    <section class="page-header-container">
         <?php $header_text = get_field('styled_class_text'); 
	         echo $header_text;
         ?>
         
    </section>
    
    <?php } ?>

    <div class="container page-container">
        <!-- block control  -->
        <div class="row block-posts block-page">
			<?php
			if ( is_social_connect_page() ) {
			
			} else { ?>
                <div class="col-md-12 col-sm-12 col-xs-12 posts-container" id="left_content">
                    <div class="blog-content">
						<?php
			
				

			echo the_content();

						
						if (get_field('show_green_call_to_action_banner_above_footer') == 1) {
								echo '<div class="cta-buttons default">';
								echo '<div class="cta-button-column">';
									echo '<p class="member-type">Content Marketers</p>';
									echo '<h3>Get <strong>started</strong> today!</h3>';
									echo '<a href="'.get_home_url() .'/content-marketer-registration" class="button shortcode-button">Apply Now <i class="fa fa-chevron-circle-right"></i></a>';
								echo '</div>';
								
								echo '<div class="cta-button-column">';
									echo '<p class="member-type">Content Authors</p>';
									echo '<h3>Get <strong>started</strong> today!</h3>';
									echo '<a href="'.get_home_url() .'/content-author-registration" class="button shortcode-button">Apply Now <i class="fa fa-chevron-circle-right"></i></a>';
								echo '</div>';
							
							echo '</div>';
						}
						?>

                        <div class="clearfix"></div>
                    </div><!-- end page content -->
                </div><!-- LEFT CONTENT -->
			<?php } ?>

        </div>
        <!--// block control  -->
    </div>

<?php
get_footer();
?>