

<?php
	/* MOZ API CALL */

			// Get your access id and secret key here: https://moz.com/products/api/keys
			$accessID = "mozscape-d19b96ee83";
			$secretKey = "45b801b858a2da8b59be7eedb23507e2";
			
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
			$objectURL = "anneschmidt.co";
			
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
			echo $domain_authority;
			
/* END MOZ API CALL */

the_field('domain_authority_pricing_schedule','option');




?>