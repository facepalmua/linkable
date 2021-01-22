<?php
/**
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

global $post;
$session = et_read_session();
get_header();
if ( isset( $session['project_id'] ) ) {
	et_destroy_session( 'project_id' );
}
if ( isset( $_REQUEST['project_id'] ) ) {
	// save Session
	et_write_session( 'project_id', $_REQUEST['project_id'] );
}
the_post();
?>
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
	<?php if( get_field('styled_class_text') ) { ?>
    <section class="page-header-container">
         <?php $header_text = get_field('styled_class_text'); 
	         echo $header_text;
         ?>
         
    </section>
    
    <?php } ?>

    <div class="container page-container">
        <!-- block control  -->
        <div class="row block-posts block-page">
			<?php
			if ( is_social_connect_page() ) {
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', ET_DOMAIN ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			} else { ?>
                <div class="col-md-12 col-sm-12 col-xs-12 posts-container" id="left_content">
                    <div class="blog-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', ET_DOMAIN ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
						
						if (get_field('show_green_call_to_action_banner_above_footer') == 1) {
								echo '<div class="cta-buttons default">';
								echo '<div class="cta-button-column">';
									echo '<p class="member-type">Ready to get started?</p>';
									echo '<h3>For <strong>clients</strong></h3>';
									echo '<a href="'.get_home_url() .'/client-account-registration" class="button shortcode-button">Sign up <i class="fa fa-chevron-circle-right"></i></a>';
								echo '</div>';
								
								echo '<div class="cta-button-column">';
									echo '<p class="member-type">Ready to get started?</p>';
									echo '<h3>For <strong>authors</strong></h3>';
									echo '<a href="'.get_home_url() .'/author-account-registration" class="button shortcode-button">Apply now <i class="fa fa-chevron-circle-right"></i></a>';
								echo '</div>';
							
							echo '</div>';
						}
						?>

                        <div class="clearfix"></div>
                    </div><!-- end page content -->
                </div><!-- LEFT CONTENT -->
			<?php } ?>

        </div>
        <!--// block control  -->
        <?php //print_r($_POST); ?>
    </div>
    <script>
    	if(jQuery("#gform_confirmation_message_2").length) {
			jQuery(".blog-content > h1").hide();
			jQuery(".blog-content > p").hide();
	};
	
		if(jQuery("#gform_confirmation_message_1").length) {
			jQuery(".blog-content > h1").hide();
			jQuery(".blog-content > p").hide();
			
		
	};
	
	jQuery(document).on('gform_confirmation_loaded', function(event, formId){
		
		if(formId == 1) {
                // window.intercomSettings = {app_id: 'n8kh4ch9',user_type: 'pending client',email: '<?php echo $_POST['input_1']; ?>',name: '<?php echo $_POST['input_6_3']; ?> <?php echo $_POST['input_6_6']; ?>'};
                
            } else if(formId == 2) {
                // run code specific to form ID 2
            }
	   // Intercom('update', intercomSettings);
	});
	</script>
<?php
get_footer();
?>