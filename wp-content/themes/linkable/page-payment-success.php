<?php
/**
 * Template Name: Payment Success Page
 */

if ( !is_user_logged_in() ) {
	//wp_redirect( get_home_url() .  '/login' );
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




?>




<?php

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

<div class="main-dashboard-content inner-dashboard page-container">
	<?php
        while ( have_posts() ) : the_post();
            echo '<h1>' . get_the_title() . '</h1>';
            the_content();
		endwhile;
	?>
</div>

</div>

<?php sleep(5); ?>

<?php get_footer(); ?>

	<?php 
		//print_r($_GET);

		
		$entry_id = $_GET['eid'];
	
		
		//tapfiliate info
		$entry = RGFormsModel::get_lead($entry_id);
		
		$trans_id = $entry['transaction_id'];
		$trans_amount = $entry['payment_amount'];
		
		$user_id = get_current_user_id();
		$user_info = get_userdata($user_id);
		
		$user_email = $user_info->user_email;
		
		?>
		
		<div class="tapfiliate-info">
PayPal transaction ID:<div id="trans-id"><?php echo $trans_id; ?></div>
Transaction amount: <div id="payment_amount"><?php echo $trans_amount; ?></div>
User email: <div id="user_email"><?php echo $user_email; ?></div>
User ID: <div id="user_id"><?php echo $user_id; ?></div>
</div>

<?php
	
/* GET THE AFFILAITE ID BY LOOKING UP EXTERNAL_ID FOR INITIAL OWNER CONVERSION */
	
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.tapfiliate.com/1.6/conversions/?external_id=" . $user_email,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json",
    "Api-Key: 0ea2efeba487c31cfd648ab7e64396c25b27e96f"
  ),
));

$affiliate_id = '';

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $json = json_decode($response,true);
  //print_r(print_r($json));
  foreach($json as $key => $value){
	  //print_r($value);
	  
	  //echo '<br>user email: ' . $user_email;
	  //echo '<br>external id: ' . $value['external_id'];
	  
	  if($value['external_id'] == $user_email) {
		  $affiliate_id = $value['affiliate']['id'];
		  break;
	  }
	  
	  //if external id matches the logged in user id, find the affiliate id and create a conversion for him/her
	  }
}

//echo 'affiliate id is: ' . $affiliate_id;

/* GET THE AFFILAITE ID BY LOOKING UP EXTERNAL_ID FOR INITIAL OWNER CONVERSION */

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.tapfiliate.com/1.6/programs/link-able-affiliate-program/affiliates/" . $affiliate_id . "/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json",
    "Api-Key: 0ea2efeba487c31cfd648ab7e64396c25b27e96f"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

//curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $json = json_decode($response,true);
  //print_r(print_r($json));
  /*  foreach($json as $key => $value){
		$value['link'];
	  }*/
	  
	  //print_r($json['referral_link']['link']);
	  $full_refer_link = $json['referral_link']['link'];
	  
	  $referral_id = parse_url($full_refer_link, PHP_URL_QUERY);
	  $referral_id = substr($referral_id,4);
	  
	  //echo '<br>referral id is: ' . $referral_id;
}

//create conversion

//API URL
$url = 'https://api.tapfiliate.com/1.6/conversions/?override_max_cookie_time=true';

//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST
$data = array(
    "referral_code" => $referral_id
);
$payload = json_encode($data);


$entry_id = $_GET['eid'];
$trans_id = $entry['transaction_id'];
$trans_amount = $entry['payment_amount'];

//************************************************NEED TO INSERT ACTUAL TRANSACTION VALUE HERE************************************************//
$json = '{"referral_code": "'.$referral_id.'","amount": "'.$trans_amount.'","external_id": "'.$trans_id.'"}';


//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER,array(
    "content-type: application/json",
    "Api-Key: 0ea2efeba487c31cfd648ab7e64396c25b27e96f"
  )
);

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);

//close cURL resource
curl_close($ch);

//$data = json_decode(file_get_contents('php://input'), true);

//echo $data;
//echo $result;

?>




<style>.tapfiliate-info{display:none;}</style>



<script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
<script type="text/javascript">
// 	jQuery( window ).load(function() {
// 		if (window.location.href.indexOf('reload')==-1) {
// 			 //window.location.replace(window.location.href+'&reload');
// 		}
// 	});
	
	
 	jQuery(window).load(function() {
        (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,'tap');

        var transID = jQuery("#trans-id").text();
        var transAmount = jQuery("#payment_amount").text();
        var user_email = jQuery("#user_email").text();

        if( ! check_tap_info(transID, user_email) ) {
            tap('create', '8498-5cbe8a');
            tap('conversion', transID, transAmount, {customer_id: user_email});
            store_tap_info(transID, user_email);
        }
       
    });

    function store_tap_info(transId, user_email) {
        var unique_id = transId + user_email;
        localStorage.setItem('conversion_status', unique_id);
    }
    function check_tap_info(transId, user_email) {
        var conv_status = localStorage.getItem('conversion_status');
        if ( conv_status ) {
            var unique_id = transId + user_email;
            return conv_status === unique_id;
        }
        return false;
    }
</script>