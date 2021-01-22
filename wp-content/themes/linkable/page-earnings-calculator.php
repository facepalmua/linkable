<?php
/**
 * Template Name: Earnings Calculator
*/


 add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}
global $user_ID;

 if(ae_user_role() == EMPLOYER) {
	 	wp_redirect( get_home_url() . '/dashboard/' );
	 }
	 
	if ( (!is_user_logged_in()) ) {
		
		$current_url = $_SERVER["SERVER_NAME"]. '/apply-to-project/?' . $_SERVER["QUERY_STRING"];
	wp_redirect( get_home_url() .  '/login' . '?redirect_to="'.$current_url . '"');
} 

get_header();



?>

<style>
	.dashboard-sidebar ul li:first-child a {
		color: white;
	}
	
	.dashboard-sidebar ul li:first-child a i {
		color: #1aad4b;
	}
	
</style>


<div class="fre-page-wrapper entry-content dashboard-page">

<?php 
get_template_part( 'dashboard-side-nav'); ?>
<div class="main-dashboard-content dashboard-landing inner-dashboard">
    <div class="fre-page-section">
	    <div class="project-intro-wrap">
	        <h1><?php echo get_the_title(); ?></h1>
	    </div>
	    <p style="margin-bottom: 20px;"><?php echo get_field('above_form_text'); ?></p>

        <div class="project-detail-box">
        	<?php
            while (have_posts()) : the_post();
            the_content();
            endwhile;

	        //print_r($_POST);
	        
	        $length = $_POST["input_3"];
			//$proposal = preg_replace( "/\r|\n/", "", trim($_POST["input_17"]) );
			$proposal = trim($_POST["input_17"]);
			$project_title = $_POST["input_5"];
			$follow_val = $_POST["input_2"];
	        
	        if (isset($_POST["input_1"]))
			   {
			       $domain_calc = $_POST["input_1"];
			      
			 
	        
	        //moz access ID: mozscape-d19b96ee83
	        // moz secret key: 45b801b858a2da8b59be7eedb23507e2
	      
	      //calculate price
	      
	      //Step 1: Get Domain authority from MOZ API example: 95
	      //Step 2: Calculate price based on pricing grid on Options Page
	      //Step 3: Multiply by follow type multiplier  
	      
/* MOZ API CALL */

$domain_authority = 0;

			// Get your access id and secret key here: https://moz.com/products/api/keys
			$accessID = "mozscape-d19b96ee83";
			$secretKey = "c8d7a78da00e772bc8257143f9d38972";
			
			//old paid API credentials
			//$accessID = "mozscape-db140bc87e";
			//$secretKey = "c4bdc40952faf45b502960c6e42c4c63";
			
			
			// Set your expires times for several minutes into the future.
			// An expires time excessively far in the future will not be honored by the Mozscape API.
			$expires = time() + 300;
			
			// Put each parameter on a new line.
			$stringToSign = $accessID."\n".$expires;
			
			// Get the "raw" or binary output of the hmac hash.
			$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
			
			// Base64-encode it and then url-encode that.
			$urlSafeSignature = urlencode(base64_encode($binarySignature));
			
			// Specify the URL that you want link metrics for.
			$objectURL = $domain_calc;
			
			// Add up all the bit flags you want returned.
			// Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
			$cols = "68719476736";
			
			// Put it all together and you get your request URL.
			// This example uses the Mozscape URL Metrics API.
			$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
			
			// Use Curl to send off your request.
			$options = array(
				CURLOPT_RETURNTRANSFER => true
				);
			
			$ch = curl_init($requestUrl);
			curl_setopt_array($ch, $options);
			$content = curl_exec($ch);
			curl_close($ch);

			//print_r($content);
			
			$b = json_decode($content,true);
			$domain_authority = $b['pda'];
			//echo $domain_authority;
			
			  }

/* END MOZ API CALL */


	      //$domain_authority = 85;
	      $price_from_da = 0; //price based on pricing grid on options page
	      $follow_multiplier = 1;
	      $commission = get_field('commission_rate_%','option');
	      
	      //get multipliers
	        if( have_rows('follow_type_calculation','option') ): ?>
		
		
			<?php while( have_rows('follow_type_calculation','option') ): the_row(); 
		
				// vars
				$no_follow_mult = get_sub_field('nofollow_multiplier');
				$do_follow_mult = get_sub_field('dofollow_multiplier');
				
				
				?>
		
			<?php endwhile; ?>
			
		<?php endif; 
	      
	      //get price from grid based on DA
	      $override_exists = false;
	      
	      //first see if domain has an override
	      if( have_rows('domain_overrides','option') ) {
		      while( have_rows('domain_overrides','option') ): the_row(); 
		      		$domain_name = get_sub_field('domain_override_field');
		      		$domain_name = parse_url($domain_name);
			  		$domain_name = $domain_name['host'];
			  		$domain_name = str_replace('www.','',$domain_name);
			  		$domain_name = strtolower($domain_name);
			  		
			  		//echo $domain_name;
			  		
			  		$entered_domain = $_POST["input_1"];
			  		$entered_domain = parse_url($entered_domain);
			  		$entered_domain = $entered_domain['host'];
			  		$entered_domain = str_replace('www.','',$entered_domain);
			  		$entered_domain = strtolower($entered_domain);
			  		
			  		//echo $entered_domain;
			  		
			  		if( $domain_name == $entered_domain) {
				  		$override_exists = true;
				  		//here we need to get the price
				  		$price_from_da = get_sub_field('price');
				  		
				  		break;
			  		}
			  		
			  		

		      endwhile;
	      }
	      
	     // echo $override_exists;
	      
	      if($override_exists) {
		      
		      
		      
		      
	      }else {
	      
		  if( have_rows('domain_authority_pricing_schedule','option') ): ?>
		  
		
		
			<?php while( have_rows('domain_authority_pricing_schedule','option') ): the_row(); 
		
				// vars
				$low = get_sub_field('range_low');
				$high = get_sub_field('range_high');
				$price = get_sub_field('dollar_value');
		
				if ( ($domain_authority >= $low) && ($domain_authority <= $high) ) {
					$price_from_da = $price;
				}
				
				?>
		
			<?php endwhile; ?>
			
		<?php endif; 
			
			}

			//grab domain authority from moz api
			//calc based on table
     
     
			//get domain authority selection
			if (isset($_POST['input_2'])) {
				$radioVal = $_POST["input_2"];	
				
				if($radioVal == "NoFollow") {
					$follow_multiplier = $no_follow_mult;
					?>
					<script>
						jQuery("#choice_4_2_0").prop("checked",true);
					</script>
					<?php
				} else {
					$follow_multiplier = $do_follow_mult;
					?>
					<script>
						jQuery("#choice_4_2_1").prop("checked",true);
					</script>
					<?php
				}
			}
     
	      //echo 'calc value:' . $dollar_value;
	      echo '<div class="price-calc">';
		      echo 'We would suggest charging this price: <span class="price-value">$';
		
		       $owner_price = $price_from_da * $follow_multiplier;
		       // $paid_price = (1-($commission/100)) * $owner_price; // Commission Turned off
		       $paid_price = number_format((float)$owner_price, 2, '.', '');
		       

			   	 echo $paid_price;
			   	
		  echo '</span>';
		  echo '<div class="how-calc"><a class="how-calc">How is this price calculated?</a></div>';
		  echo '<div class="list-item-expanded">This price was automatically calculated to help you determine the approximate amount you should charge for building a backlink on a specific domain. The price is only a suggestion and you are free to set your own price. Keep in mind, Link-able is all about quality and we encourage authors to charge a premium price for a premium job.</div>';
		  echo '</div></div>';
		  
		  
	      
	      //add price to hidden field
	      ?>
	      <script>
		      
		      jQuery(document).bind('gform_post_render', function (event, formId, current_page) {
			     
   	if (current_page == 2) {
	 
				jQuery("#gform_page_17_1 .gform_page_footer").hide();
				}
});
		      		//move calc price button
		      		
		jQuery(document).bind('gform_post_render', function(){
			
		
			
			jQuery("#gform_page_17_2 .gform_page_footer").addClass("apply-button");
			jQuery("#gform_page_17_1 .gform_page_footer").addClass("calc-button");
			jQuery("#gform_page_17_1 .gform_page_footer").insertBefore("#gform_page_4_2 .gform_page_footer");
			jQuery("#gform_page_17_2").show();
			
			jQuery(".apply-button").hide();
			jQuery(".price-calc").hide();
			jQuery(".price-calc").css("display","none");
			
			var postData = <?php echo $_POST; ?>;
			if( (jQuery(".validation_error").text() == '') && (window.location.hash) ) {
				
				console.log('have a price');
				
				jQuery("#gform_page_17_2").show();
					jQuery(".apply-button").show();
					jQuery(".price-calc").show();
				
				jQuery("#gform_page_17_2 .gform_page_footer:nth-child(3)").css("visibility","hidden");
				jQuery("#gform_page_17_2 .gform_page_footer:nth-child(3)").css("height","0px");
				jQuery("#input_17_1").prop("readonly",true);
				jQuery("#input_17_1").addClass("disabled");
				
				jQuery("#input_17_2").addClass("disabled");
				jQuery("#input_17_3").addClass("disabled");
				
				jQuery("#input_17_4").prop("readonly",true);
				jQuery("#input_17_4").addClass("disabled");
				
				jQuery("#input_17_7 input").attr("readonly","readonly");
				jQuery("#input_17_7").addClass("disabled original");
				jQuery("#field_4_7").clone().addClass("copy-disabled").appendTo("#gform_fields_4");
				jQuery("#field_4_7.copy-disabled input").prop("disabled",true);
				
				jQuery("#field_4_7:not(.copy-disabled)").hide();
				
				jQuery("#gform_wrapper_17").css("margin-bottom","0px");
				
				
				jQuery('#input_17_2 input:not(:checked)').prop('disabled', true);
				
				jQuery("#gform_page_17_2 .gform_page_footer").append("<div class='gform_reset_button reset-application'><a>Clear/Reset</a></div>");
				
			}
			
			//jQuery("#gform_next_button_4_13").attr("disabled","disabled");
			//jQuery("#gform_next_button_4_13").addClass("disabled");
			
			});
		      
		   jQuery("#input_17_18").val('<?php echo $owner_price; ?>');
		    jQuery("#field_4_18").hide();
		      
	      jQuery("#input_17_11").val('<?php echo $paid_price; ?>');
	      jQuery(".price-calc").insertAfter("#gform_page_4_2 .gform_page_fields");
	      
	      jQuery("#input_17_15").val('<?php echo $domain_authority; ?>');
	      
	      //auto populate other saved data
	      //jQuery("#input_17_5").val('<?php echo $project_title; ?>');
	      jQuery("#input_17_1").val('<?php echo $domain_calc; ?>');
	      if($proposal) {
	      	jQuery("#input_17_4").val('<?php echo json_encode($proposal, JSON_HEX_APOS); ?>');
	      }
	    
	
	if(jQuery("#gform_confirmation_wrapper_4").length) {
		jQuery(".entry-content p:first-child").hide();
		jQuery(".project-summary").hide();
		jQuery(".project-detail-box.project-info").hide();
		jQuery(".project-summary.second").hide();
		jQuery(".project-intro-wrap h1").text("Application Submitted!");
	};
	

	      
	      </script>
	      <?php
	      //echo 800 * .5;
	      //echo '<div class="price-based-on-moz-api">Price</div>';
	      


	        
	    ?>
        
            </div>
                	 <?php echo get_field('below_form_text'); ?>
</div>
</div>
<?php
get_footer();