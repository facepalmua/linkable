
<?php
	
$employer_current_project_query = new WP_Query(
									array(
										'posts_per_page' => -1,
										'is_author'        => true,
										'post_type'        => PROJECT,
										'author'           => $user_ID,
										'suppress_filters' => true,
										'orderby'          => 'date',
										'order'            => 'DESC',
										'paged'			   => $paged
									)
									
								);

								$no_result_current = '';
								
								$total_emp_posts = $employer_current_project_query->found_posts;
								$complete = 0;
								$with_app = 0;
								$with_accepted_app = 0;
								$with_pending_app = 0;
								$no_app = 0;
								$deleted = 0;
								$cancelled = 0;
								
								$status_class= '';
								
								while ( $employer_current_project_query->have_posts() ) : $employer_current_project_query->the_post(); 
								
								/*echo '<pre>';
									echo get_post_status();
								echo '</pre>';*/
													
													if(get_post_status() == 'deleted-accepted-app' || get_post_status() == 'deleted') {
													
						
														$deleted++;
														$status_class = 'deleted';
		
													} 
													
													$bid_query = new WP_Query( array(
															'post_type'      => 'bid',
															'post_parent'    => get_the_ID(),
															'posts_per_page' => -1
														)
													);
													
													$bid_posts = $bid_query->posts;
													
													$all_status = [];

													if ( $bid_query->have_posts() ) : while ( $bid_query->have_posts() ) : $bid_query->the_post();

													
													/*echo '<pre>';
														echo get_post_status();
													echo '</pre>';*/
													
														//count the posts
														
														array_push($all_status,get_post_status());
														
													
													endwhile;
													
													

													else:
													
													if (get_post_status() != 'deleted-accepted-app' ) {
														$no_app++;
													}
													
													endif;
													
													//print_r($all_status);
													
													if(in_array("publish",$all_status)) {
														$with_pending_app++;
													}
													
													if(in_array("accept",$all_status) || in_array("admin-review",$all_status)) {
														$with_accepted_app++;
													}
													
													if(in_array("complete",$all_status)) {
														$complete++;
													}
													
													if(in_array("pending-completion",$all_status)) {
														$complete++;
													}
													
													if(in_array("cancelled",$all_status)) {
														$cancelled++;
													}
													
											
								
								endwhile;
							
?>

 <div class="employer-project-nav">
		                                        <ul class="fre-tabs">
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/">All Projects (<?php echo $total_emp_posts; ?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/pending-application/">Pending Contracts (<?php echo $with_pending_app;?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/accepted-application/">Accepted Contracts (<?php echo $with_accepted_app;?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/without-applications/">Without Contracts (<?php echo $no_app; ?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/completed/">Completed Contracts (<?php echo $complete; ?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/cancelled/">Cancelled Contracts (<?php echo $cancelled; ?>)</a></li>
		                                        	<li><a href="<?php echo get_home_url(); ?>/my-projects/deleted/">Deleted Projects (<?php echo $deleted; ?>)</a></li>
		                                        </ul>
	                                        </div>
