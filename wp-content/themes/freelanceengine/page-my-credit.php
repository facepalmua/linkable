<?php
/**
 * Created by PhpStorm.
 * User: Vosydao
 * Date: 6/5/2017
 * Time: 10:41 AM
 * Template Name: My Credit
 */

global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role = ae_user_role($current_user->ID);

if(!is_user_logged_in()){
	wp_redirect(et_get_page_link('login').'?ae_redirect_url='.urlencode(et_get_page_link('my-credit')));
}

if(!ae_get_option('user_credit_system')){
	wp_redirect(get_site_url());
}
get_header();

//do_action('fre_profile_tab_content');
do_action('fre_profile_tab_content_credit');
?>

<?php get_footer() ?>
