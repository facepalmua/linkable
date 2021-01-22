<?php
/**
 * Template Name: Link Building Rules
 */

if ( !is_user_logged_in() ) {
			$current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
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

<style>
	.entry-content img {
		max-width: 100%;
		height: auto;
	}
</style>

<div class="main-dashboard-content inner-dashboard page-container">
	
	<?php
    while ( have_posts() ) : the_post();
    if ( $user_role == "employer") {
			wp_redirect( get_home_url() .  '/login' );
	 } else {
		 echo '<h1>'.get_the_title().'</h1>';
		the_content();
	 }
	endwhile;
	?>

</div>

</div>
<?php get_footer(); ?>