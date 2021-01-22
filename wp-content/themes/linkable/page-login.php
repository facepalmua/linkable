<?php
/**
 * Template Name: Login Page
 */

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.8
 */

global $post;

if ( is_user_logged_in() ) {
	wp_redirect( get_home_url() . '/dashboard' );
	exit();
	/*
	$user = wp_get_current_user();
    $role = ( array ) $user->roles;
	$u_r = $role[0];
	if ($u_r !== 'administrator') {
		
	}
	exit;*/
}

get_header();
// the_post();
// Redirect after login success
//$re_url = get_home_url() . '/dashboard';
$re_url = esc_url($_SERVER['REQUEST_URI']);

echo $_SERVER['QUERY_STRING'];
	$a = 'login=failed';
	$login_failed = false;
	if ( preg_match('/\bfailed\b/',$_SERVER['QUERY_STRING']) ) {
    	$login_failed = true;
    	echo $login_failed;
		}



?>

    <div class="fre-page-wrapper">
        <div class="fre-page-section">
            <div class="container">
                <div class="fre-authen-wrapper">
	                <?php
	                	if ($login_failed == true) {
		echo '<div class="failed-login"><h3>Invalid login credentials. Please try again.</h3></div>';
	}
	?>
	                <?php 
		               
		               if ($_GET['parent_id']) {
			               $args = array(
    'redirect' => 'https://' . $_GET['redirect_to'] . "&parent_id=" . $_GET["parent_id"]
		               );
		               }
		               
		               //print_r($_SERVER);
		              if($_GET['redirect_to'] && $_GET['parent_id'] = ''  ) {
			             // echo 'https://' . $_GET['redirect_to'];
		               		                $args = array(
    'redirect' => 'https://' . $_GET['redirect_to']  
); }
						//echo esc_url($_SERVER['REQUEST_URI']);
                    if( isset( $_GET['redirect_to'] ) ) {
                        $redirectto = $_SERVER['QUERY_STRING'];
                        $rec_links = get_site_url() . '/recommended-links/';
                        $rec_link_text = str_replace(['http://', 'https://'], '', $rec_links );
                        if (strpos($redirectto, $rec_link_text) !== false) {
                            $args['redirect'] = $rec_links;
                        }
                        $msg_links = get_site_url() . '/messages/';
                        $msg_link_text = str_replace(['http://', 'https://'], '', $msg_links );
                        if (strpos($redirectto, $msg_link_text) !== false) {
                            $args['redirect'] = $msg_links;
                        }
                    }
                    echo wp_login_form($args); ?>
                    <div class="not-a-member">
	            	Not a member? Sign up for your <a href="<?= get_site_url(); ?>/client-account-registration/">client account</a> or <a href="<?= get_site_url(); ?>/author-account-registration/">author account</a> to get started!
            </div>
                </div>
                            

            </div>

            
        </div>
    </div>
<?php
get_footer();
?>