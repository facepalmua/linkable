<?php 
/**
 * Template Name: Page List Notification 
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */
  add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}
global $user_ID;
get_header();
?>
<div class="fre-page-wrapper entry-content dashboard-page">

<?php 
get_template_part( 'dashboard-side-nav'); ?>
<div class="main-dashboard-content dashboard-landing inner-dashboard">
	<div class="fre-page-wrapper">

			<div class="container">
				<h1>Your Notifications</h1>
			</div>
	

		<div class="fre-page-section">
			<div class="container">
				<div class="page-notification-wrap" id="fre_notification_container">
                    <?php
                    ob_start();
                    fre_user_notification( $user_ID, 1,'', 'fre-notification-list');
                    $notifications = ob_get_clean();
                    $notifications = str_replace('You have a new application', 'You have a new contract', $notifications);
                    $notifications = str_replace('Congratulations, your application', 'Congratulations, your contract', $notifications);
                    echo $notifications;
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

 <?php get_footer(); ?>
