<?php
/**
 * Template Name: Dashboard
 */
 
/* if ( current_user_can('edit_others_pages') )  {
	wp_redirect( get_home_url() . '/wp-admin' );
}*/

if ( !is_user_logged_in() ) {
			//$current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	//wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
}
 
 add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
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

<div class="entry-content landing-entry-content">
	

<?php
global $user_ID;
?>

<?php get_template_part( 'dashboard-side-nav'); ?>

<div class="main-dashboard-content dashboard-landing">

	<?php if ( $user_role == "employer") {

	the_content();
	 } else {
		echo get_field('content_author_dashboard_content');
	 }
	
	
	?>

</div>

</div>
<?php get_footer(); ?>