<?php
/**
 * Template Name: Dashboard NEW
 */

/* if ( current_user_can('edit_others_pages') )  {
	wp_redirect( get_home_url() . '/wp-admin' );
}*/

if ( ! is_user_logged_in() ) {
	$current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';

	return $classes;
}


get_header();


global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
//convert current user
$ae_users  = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
?>

<?php
    if ( $user_role == 'freelancer' ) {
        $intercom_role = 'author';
    } else if ( $user_role == 'employer' ) {
        $intercom_role = 'client';
    } else {
        $intercom_role = $role;
    }
    ?>

    <script>
	    jQuery(window).load(function() {
		    window.intercomSettings = {app_id: 'n8kh4ch9',user_type: '<?php echo $intercom_role; ?>',email: '<?php echo $current_user->user_email; ?>'};
		    Intercom('update', intercomSettings);
		});
	</script>

    <div class="entry-content landing-entry-content">


		<?php
		global $user_ID;
		?>

		<?php get_template_part( 'dashboard-side-nav' );
		$queried_object = get_queried_object();
		$post_id        = $queried_object->ID;

		?>

        <div class="main-dashboard-content dashboard-landing">

			<?php if ( $user_role == "employer" ) { //client and owner
				echo '<div class="intro-video-wrap closed">';
				echo '<div class="show-hide-wrap">';
				echo get_field( 'content_client_dashboard_content', $post_id );
				// while( have_posts() ) {
				// 	the_post();
				// 	//this is the intro text and video
				// 	the_content();
				// }
				echo '<img class="cm-dash-image" src="' . get_field( 'cm_image' ) . '">';
				$bottom_button_text = get_field( 'cm_button_text' );
				$bottom_button_link = get_field( 'cm_button_link' );
				echo '<div class="cm-button-wrap"><a class="cm-button button button shortcode-button gray" href="' . $bottom_button_link . '">' . $bottom_button_text . ' <i class="fa fa-chevron-circle-right"></i></a></div>';

				echo '</div>';

				echo '<div class="show-hide-dash-intro">Hide welcome message<i class="fa fa-angle-up"></i></div>';


				echo '</div>';


				echo '<div class="dashboard-stat-section">';
				echo '<h2>Dashboard</h2>';
				echo '<p class="stat-intro">' . get_field( 'owner_stat_dashboard_text', $post_id ) . '</p>';

				echo '<div class="row dashboard-stats">';
				echo do_shortcode( '[owner_pending_apps_new]' );
				// echo do_shortcode( '[owner_pending_apps]' );
				echo '</div>';
				echo '<div class="resources-to-help">';
				$title_resource = get_field('title_resources_to_help_client', $post_id);
				echo '<h4>'.$title_resource.'</h4>';
				if ( have_rows( 'resources_to_help_you_client', $post_id ) ):
					while ( have_rows( 'resources_to_help_you_client', $post_id ) ) : the_row();
						$new_tab    = get_sub_field( 'open_in_new_window' );
						$title      = get_sub_field( 'title' );
						$link       = get_sub_field( 'link' );
						$fa_code    = get_sub_field( 'font_awesome_icon_code' );
						$text_below = get_sub_field( 'text_below_icon' );

						$target = "_self";

						if ( $new_tab[0] === 'Yes' ) {
							$target = "_blank";
						}


						echo '<p>';
						echo '<a target="' . $target . '" href="' . $link . '">';

						echo '<i class="' . $fa_code . '"></i>   ';
						echo '<span class="padding-link">' . $title. '</span>';
						echo '</a>';
						echo '</p>';
					endwhile;
				endif;
				echo '</div>';

				// echo do_shortcode( '[show_graph]' );

				// echo '<div class="quick-tip">' . get_field( 'owner_quick_tip', $post_id ) . '</div>';
				
				echo '</div>';

			} else {  // author and other
				echo '<div class="intro-video-wrap closed">';
				echo '<div class="show-hide-wrap">';
				echo get_field( 'content_author_dashboard_content', $post_id );
				echo '<img class="cm-dash-image" src="' . get_field( 'cm_image' ) . '">';
				// echo '<div class="icon-col-block">';
				// if ( have_rows( 'ca_icons_+_text' ) ):
				// 	while ( have_rows( 'ca_icons_+_text' ) ) : the_row();
				// 		$new_tab    = get_sub_field( 'open_in_new_window' );
				// 		$title      = get_sub_field( 'title' );
				// 		$link       = get_sub_field( 'link' );
				// 		$fa_code    = get_sub_field( 'font_awesome_icon_code' );
				// 		$text_below = get_sub_field( 'text_below_icon' );

				// 		$target = "_self";

				// 		if ( $new_tab[0] === 'Yes' ) {
				// 			$target = "_blank";
				// 		}


				// 		echo '<div class="col">';
				// 		echo '<a target="' . $target . '" href="' . $link . '">';


				// 		echo '<h3>' . $title . '<i class="fas fa-chevron-right"></i></h3>';
				// 		echo '<div class="icon"><i class="fas fa-' . $fa_code . '"></i></div>';
				// 		echo '<p class="text-below">' . $text_below . '</p>';
				// 		echo '</a>';
				// 		echo '</div>';
				// 	endwhile;
				// endif;

				// echo '</div>';


				$bottom_button_text = get_field( 'ca_button_text' );
				$bottom_button_link = get_field( 'ca_bottom_button_link' );
				echo '<div class="cm-button-wrap"><a class="cm-button button button shortcode-button gray" href="' . $bottom_button_link . '">' . $bottom_button_text . ' <i class="fa fa-chevron-circle-right"></i></a></div>';


				echo '</div>';

				echo '<div class="show-hide-dash-intro">Hide welcome message<i class="fa fa-angle-up"></i></div>';
				echo '</div>';

				echo '<div class="dashboard-stat-section">';
				echo '<h2>Dashboard</h2>';
				echo '<p class="stat-intro">' . get_field( 'content_author_stat_dashboard_text' ) . '</p>';
				echo '<div class="row dashboard-stats">';
				$contents = do_shortcode( '[author_stats_new]' );
				$contents = str_replace('Active applications', 'Active contracts', $contents);
				echo $contents;
				echo '</div>';
				echo '<div class="resources-to-help">';
				$title_resource = get_field('title_resources_to_help_author', $post_id);
				echo '<h4>'.$title_resource.'</h4>';
				if ( have_rows( 'resources_to_help_you_author', $post_id ) ):
					while ( have_rows( 'resources_to_help_you_author', $post_id ) ) : the_row();
						$new_tab    = get_sub_field( 'open_in_new_window' );
						$title      = get_sub_field( 'title' );
						$link       = get_sub_field( 'link' );
						$fa_code    = get_sub_field( 'font_awesome_icon_code' );
						$text_below = get_sub_field( 'text_below_icon' );

						$target = "_self";

						if ( $new_tab[0] === 'Yes' ) {
							$target = "_blank";
						}


						echo '<p>';
						echo '<a target="' . $target . '" href="' . $link . '">';

						echo '<i class="' . $fa_code . '"></i>  ';
						echo '<span class="padding-link">' . $title. '</span>';
						echo '</a>';
						echo '</p>';
					endwhile;
				endif;
				echo '</div>';

				// echo do_shortcode( '[show_author_graph]' );

				// echo '<div class="quick-tip">' . get_field( 'author_quick_tip', $post_id ) . '</div>';
				
				echo '</div>';
			}


			?>

        </div>

    </div>
<?php get_footer(); ?>