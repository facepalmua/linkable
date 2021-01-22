<?php
/**
 * The template for displaying no bidding info in a project details page
 * @since 1.0
 * @author Dakachi
 */
?>
<div class="freelancer-bidding-not-found">
	<div class="row">
	<?php
		global $wp_query, $ae_post_factory, $post,$user_ID;
		// get current project post data
	    $project_object = $ae_post_factory->get(PROJECT);;
	    $project = $project_object->current_post;

		$role = ae_user_role();
		if($project->post_status == 'publish' ){
		 	if( (int) $project->post_author == $user_ID || $role != FREELANCER ){?>
		 <!--
		 			<p>Sit tight! Your project is posted and awaiting applications from Content Authors. If a Content Author thinks your project is the right fit for their work, they will apply to this project and you’ll see their application listed here. We’ll also send you an email notification for each application you receive so that you won’t miss any! </p>
<p>Tip: If you’re not receiving any applications, it could be that your project description is not detailed enough. Try posting a new project and rewriting the description to be more informative about your page. Also write a more convincing reason why your page is link-worthy for Content Authors. </p>
<p class="pending">Any applications for this project that are pending your acceptance or declination would show up here. However, it currently looks like you do not have any yet for us to display here.</p>

<p class="accepted">Any applications for this project that that you have accepted/purchased would show up here. However, it currently looks like you do not have any yet for us to display here.</p>

<p class="completed">Any applications for this project that have been completed would show up here. However, it currently looks like you do not have any yet for us to display here.</p>

<p class="cancelled">Any applications for this project that have been cancelled would show up here. However, it currently looks like you do not have any yet for us to display here.</p>-->

				<?php if($role == FREELANCER || !is_user_logged_in()) {
					$href = et_get_page_link('login', array('ae_redirect_url'=> $project->permalink));
				?>
				<?php } ?>
			<?php } else if( $role == 'freelancer' || !$user_ID ) { ?>
				<!-- <div class="col-md-12">
					<p>
						<?php _e('There are no bids yet.',ET_DOMAIN);?>
						You currently have no pending contracts to show.
					</p>
				</div> -->

			<?php }
		}  else {
			// echo '<div class="col-md-12" ><p>';
			// // $status = 	array(	'pending' => __('This project is pending', ET_DOMAIN),
			// // 					'archive' => __('This project has been archived',ET_DOMAIN) ,
			// // 					'reject'  => __('This project has been rejected',ET_DOMAIN) );
			// // if(isset($status[$project->post_status]))
			// // 	printf($status[$project->post_status]);
			// echo "You currently have no pending contracts to show.";
			// echo '</p></div>';
		}
	?>
	</div>
</div>
