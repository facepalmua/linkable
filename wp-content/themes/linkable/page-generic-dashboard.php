<?php
/**
 * Template Name: Dashboard Generic Text page
 */

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


while ( have_posts() ) : the_post();

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

		<?php get_template_part( 'dashboard-side-nav' ); ?>

        <div class="main-dashboard-content inner-dashboard page-container">

			<?php
			echo '<h1 class="margin-bottom-15">' . get_the_title() . '</h1>';
			the_content();

			?>

        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>