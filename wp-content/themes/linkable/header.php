<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */
global $current_user;
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<?php global $user_ID; ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:200i,300i,300,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php ae_favicon(); ?>
	<?php
	wp_head();
	if ( function_exists( 'et_render_less_style' ) ) {
		//et_render_less_style();
	}

	?>


<!-- Tapfiliate -->
<script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
<script type="text/javascript">
  (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,'tap');
  tap('create', '8498-5cbe8a');
  tap('detect');
</script>




<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K57X2MZ');</script>
<!-- End Google Tag Manager -->




<!-- Global site tag (gtag.js) - Google Ads: 733115435 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-733115435"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-733115435');
</script>


<?php
	if(!is_page(5120)) {
		?>
<!-- Event snippet for CM Signup conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-733115435/haMICIOA5qIBEKvoyd0C',
      'event_callback': callback
  });
  return false;
}
</script>

<?php } ?>





<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-142870547-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-142870547-1');
</script>





</head>
<?php
if (get_field('enroll_header') == 'Yes'):
	?>
	<body <?php body_class($class='academy_header'); ?>>
	<?php
else:
	?>
	<body <?php body_class(); ?>>
	<?php
endif;
?>



<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K57X2MZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<!-- <div class="fre-wrapper"> -->

<header class="fre-header-wrapper">
    <div class="fre-header-wrap" id="main_header">
        <div class="container">
            <div class="fre-site-logo">
                <a href="<?php echo home_url(); ?>">
									<img src="<?php echo get_site_url(); ?>/images/link-able-logo.svg" alt="Link-able">
								</a>

            </div>
                    <!-- Main Menu -->
						<?php if ( has_nav_menu( 'et_header_standard' ) ) { ?>


								<?php
								$args = array(
									'theme_location'  => 'et_header_standard',
									'menu'            => '',
									'container'       => '',
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => '',
									'menu_id'         => '',
									'echo'            => true,
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => ''
								);
								wp_nav_menu( $args );
								?>

						<?php } ?>
							<!-- Main Menu -->

			<?php if ( ! is_user_logged_in() ) { ?>

			<?php } else {
				?>
                <div class="fre-account-wrap dropdown">
                    <a class="fre-notification dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="fa fa-bell" aria-hidden="true"></i>
						<?php
						 if ( function_exists( 'fre_user_have_notify' ) ) {
							 $notify_number = fre_user_have_notify();
							//if ( $notify_number ) {
								echo '<span class="dot-noti"></span>';
								//echo $notify_number;
							//}
						}
						?>
						<div>Notifications</div>
                    </a>
					<?php
                        ob_start();
                        fre_user_notification( $user_ID, 1, 5 );
                        $notifications = ob_get_clean();
                        $notifications = str_replace('You have a new application', 'You have a new contract', $notifications);
                        $notifications = str_replace('Congratulations, your application', 'Congratulations, your contract', $notifications);
                        echo $notifications;
                    ?>
                    <div class="fre-account dropdown">
                        <div class="fre-account-info dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user user-icon" aria-hidden="true"></i>
                            Welcome, <span><?php echo $current_user->first_name; ?>!</span>
                            <?php //print_r($current_user); ?>
                            <i class="fa fa-angle-down caret-icon" aria-hidden="true"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo et_get_page_link( "profile" ) ?>"><?php _e( 'MY PROFILE', ET_DOMAIN ); ?></a>
                            </li>
							<?php do_action( 'fre_header_before_notify' ); ?>
                            <li><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'LOGOUT', ET_DOMAIN ); ?></a></li>
                        </ul>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>
</header>
<!-- MENU DOOR / END -->

<?php
global $user_ID;
if ( $user_ID ) {
	echo '<script type="data/json"  id="user_id">' . json_encode( array(
			'id' => $user_ID,
			'ID' => $user_ID
		) ) . '</script>';
}


?>
