<?php
/**
 * Template Name: Help & Support
 */
 
  add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}
 
  //if not logged in, redirect
if (is_user_logged_in()) {
	
} else {
			$current_url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() .  '/login' . '?redirect_to='.$current_url );
	die();
}

get_header();
?>

<style>
	.dashboard-sidebar ul li.la_nav_help_support a {
		color: #ffffff;
	}
	.dashboard-sidebar ul li.la_nav_help_support a i {
		color: #1faa49;
    }
</style>

<div class="entry-content landing-entry-content">

<?php
global $user_ID;
?>

<?php get_template_part( 'dashboard-side-nav'); ?>

<div class="main-dashboard-content inner-dashboard">
	<?php
		if( have_posts() ) :
			while(have_posts()) : the_post();
				the_content();
			endwhile;
		endif;
	?>

</div>

</div>
<?php get_footer(); ?>