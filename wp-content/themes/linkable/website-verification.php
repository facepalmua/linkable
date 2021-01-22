

	<form class="verify-form" method="post">
	<input class="website-url" type="url" required name="website-url" placeholder="Enter your website address (ex https://mywebsite.com)" class="verify-website">
	<input type="submit" name="submit-url" value="Verify your website">
	</form>


<?php
	
	//echo $_POST['website-url'] . '/randomfile-5678.txt';


function checkExternalFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $retCode;
}

//$fileExists = checkExternalFile($_POST['website-url'] . '/randomfile-5678.txt');
/*
if ( $fileExists == 200) {
	echo 'Your website was successfully verified.';
	} else {
		echo 'There was a problem verifying your website. Please try again.';
	}
/*
if ( $fileExists == 200) {
	echo 'Your website was successfully verified.';
	//get current user id
	 $acf_id = 'user_' . get_current_user_id();
	 //echo $acf_id;
	
	//add row to repeater field
	$row = array(
		'field_5b783d35b41a1' => $_POST['website-url'],
		'field_5b783da962c9e' => 1
	);
	
	add_row('field_5b783d22b41a0',$row,$acf_id);
	
	} else {
		echo 'There was a problem verifying your website. Please try again.';
	
	}*/
	
	
if(isset($_POST['website-url']) ) {
	
	?>

	
	<?php
		$path = getcwd();
		//echo $path;
    $data = 'The verification file has been properly uploaded and is ready to be verified. Remember to delete this file after verification.';
    //$file = rand(000000,999999);
    $file = substr(md5(microtime()),rand(0,26),15); //this is the verification random string that needs to be saved
    $file_path = $path . "/verification/" . $file . ".html";
    $file_path2 = $path . "/verification/" . $file . ".htm";
    $ret = file_put_contents($path . "/verification/$file.html", $data, FILE_APPEND | LOCK_EX);
    
    $user_file_path = $_SERVER['HTTP_HOST'] . "/verification/" . $file . ".html";
    
    $user_file_path2 = $_SERVER['HTTP_HOST'] . "/verification/" . $file . ".htm";

   // print_r($user_file_path);
    //echo $path;
    
    if($ret === false) {

        die('There was an error writing this file');

    }
    else { ?>
    	<div id="page-mask"></div>
	    <div class="verification-popup">
	<style>
		.verification-popup {
	 position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
    background: white;
    padding: 30px 30px;
        -webkit-box-shadow: 0px 1px 1px 0px rgba(185, 184, 184, 0.75);
    -moz-box-shadow: 0px 1px 1px 0px rgba(185, 184, 184, 0.75);
    box-shadow: 0px 1px 1px 0px rgba(185, 184, 184, 0.75);
    z-index: 5000;
}

.list-item {
	    display: flex;
    align-items: baseline;
    text-align: left;
    margin-bottom: 20px;
}

.first.list-item {
	margin-top: 0;
}

.list li {
	list-style-type: none;
	display: inline;
}

.list .number {
	    margin-right: 10px;
    background: #1aad4b;
    color: #fff;
    border-radius: 50%;
    width: 20px;
    display: inline-block;
    font-size: 12px;
    text-align: center;
    line-height: 20px;
    font-weight: bold;
}

a.verify-your-website {
	font-size: 14px;
	padding: 5px 15px;
	cursor: pointer;
}

#page-mask {
  background: rgba(0, 0, 0, 0.2);
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 100;
}

		<?php $website_url = $_POST['website-url'];
		$website_url = rtrim($website_url,"/");
		
		
		 ?>
	<?php $uploaded_path = $website_url . '/' . $file . '.html'; ?>
	<?php $uploaded_path2 = $website_url . '/' . $file . '.htm'; ?>
	</style>

	<h4>Website Verification Directions:</h4>
		
	<div class="list web-verification">
		
		<div class="list-item first"><span class="number">1</span><li><span class="bold">Download</span> this <a download href="https://<?php echo $user_file_path; ?>" target="_blank">HTML verification file</a></li></div>
		<div class="list-item"><span class="number">2</span><li><span class="bold">Upload</span> the file to <?php echo $website_url?></li></div>
		<div class="list-item"><span class="number">3</span><li><span class="bold">Confirm</span> successful upload by visiting <a href="<?php echo $uploaded_path; ?>" target="_blank"><?php echo $uploaded_path;?></a> in your browser</li></div>
		<div class="list-item"><span class="number">4</span><li><span class="bold">Click</span> the green verification button below</li></div>
	</div>
	
	<p>Once your website has been verified, you can delete the HTML verification file.</p>
	
	<a class="verify-your-website button shortcode-button">Verify your website</a>	
	
	<p class="verify-trouble-text">If you are having difficulties with verification, please email support at <a href="mailto:support@link-able.com">support@link-able.com</a></p>


	
	<script>
		
			//close verification window if click outside
	jQuery("#page-mask").click(function(){
		jQuery(".verification-popup").remove();
		jQuery(this).remove();
	})
		
			jQuery(".verify-your-website").click(function(){
	 // We'll pass this variable to the PHP function example_ajax_request
    var message ='';
     
    // This does the ajax request
    jQuery.ajax({
        url: example_ajax_obj.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
        data: {
            'action': 'example_ajax_request',
            'file_path': '<?php echo $uploaded_path; ?>',
            'file_path2':  '<?php echo $uploaded_path2; ?>',
            'website_url': '<?php echo $website_url; ?>',
            'message': message
        },
        success:function(data) {
            // This outputs the result of the ajax request
            //console.log(data);
            jQuery(".verification-popup").remove();
			jQuery(this).remove();
			
			//jQuery(".website-list").append(message);
			var str1 = 'successfully';
			
			if(data.indexOf(str1) !== -1) {
			
				//jQuery(".website-list").append('<div><?php echo $website_url; ?><span>Verified</span></div>');
				jQuery(".website-list").append('<div class="verification-message"><span>Your website <?php echo $website_url; ?> was successfully verified!</span></div>');	
				} else {
				jQuery(".website-list").append('<div class="verification-message"><span>There was an error verifying your website. Please try again.</span></div>');	
				}
			
        },
        error: function(errorThrown){
            console.log(errorThrown);
            //jQuery(".website-list").append('<div>There was a problem verifying your website. Please try again.</div>');
        }
});

});

	</script>
</div>
	    
	    
	    
	<?php    
	    
	    
       // echo "$ret bytes written to file";
        //echo $file;
    }
}
	


?>







