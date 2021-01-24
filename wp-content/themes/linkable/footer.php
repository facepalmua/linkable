<?php
wp_reset_query ();
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */
?>
<?php
if ( is_active_sidebar ( 'fre-footer-1' ) || is_active_sidebar ( 'fre-footer-2' )
     || is_active_sidebar ( 'fre-footer-3' ) || is_active_sidebar ( 'fre-footer-4' )
) {
	$flag = true; ?>
    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <div class="row">
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar ( 'fre-footer-1' ) ) {
								dynamic_sidebar ( 'fre-footer-1' );
							} ?>
                        </div>
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar ( 'fre-footer-2' ) ) {
								dynamic_sidebar ( 'fre-footer-2' );
							} ?>
                        </div>
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar ( 'fre-footer-3' ) ) {
								dynamic_sidebar ( 'fre-footer-3' );
							} ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
					<?php if ( is_active_sidebar ( 'fre-footer-4' ) ) {
						dynamic_sidebar ( 'fre-footer-4' );
					} ?>
                </div>
            </div>
        </div>
    </footer>
<?php } else {
	$flag = false;
} ?>
<div class="copyright-wrapper footer_wrapper__left <?php if ( ! $flag ) {
	echo 'footer-copyright-wrapper';
} ?>">
	<?php
	$copyright = ae_get_option ( 'copyright' );
	$col       = 'col-md-6 col-sm-6';
	?>
    <div class="la-container">
        <div class="row footer_menu--row">
            <div class="col-lg-4 col-md-4">
                <a href="<?php echo home_url ( '/' ) ?>" class="footer_logo--link">
                    <img src="<?php echo get_site_url () . '/wp-content/themes/linkable/images/footer_logo.png' ?>"
                         alt="" class="footer_logo">
                </a>
                <p class="footer_text">
                    Link-able is a unique platform that smartly connects businesses with freelance writers who can build
                    quality backlinks and write premium content that will grow traffic.
                </p>
            </div>
            <div class="col-lg-2 col-md-2 footer_menu--border">
                <h6 class="footer_menu--title">COMPANY</h6>
                <?php wp_nav_menu( [
	                'theme_location'  => 'left-footer-menu',
	                'menu_class'      => 'footer_menu--list',
                ] ); ?>
            </div>
            <div class="col-lg-2 col-md-2 footer_menu--border">
                <h6 class="footer_menu--title">SERVICES</h6>
	            <?php wp_nav_menu( [
		            'theme_location'  => 'center-footer-menu',
		            'menu_class'      => 'footer_menu--list',
	            ] ); ?>
            </div>
            <div class="col-lg-2 col-md-2 footer_menu--border">
                <h6 class="footer_menu--title">LEGAL</h6>
	            <?php wp_nav_menu( [
		            'theme_location'  => 'right-footer-menu',
		            'menu_class'      => 'footer_menu--list',
	            ] ); ?>
            </div>
            <div class="col-lg-2 col-md-2 footer_menu--border">
                <h6 class="footer_menu--title">FOLLOW</h6>
	            <?php wp_nav_menu( [
		            'theme_location'  => 'footer-social-menu',
		            'menu_class'      => 'footer_menu--list',
	            ] ); ?>
            </div>
        </div>
    </div>
</div>

<section class="footer_copyright--section">
<div class="la-container">
    <div class="row footer_copyright--row">
        <div class="col-lg-12">
            <p class="text-copyright">© <?php echo date('Y'); ?> Link-able.com | 1320 Tower Road, Schaumburg, IL. 60173</p>
        </div>
    </div>
</div>
</section>

<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name" : "Link-able",
    "url": "<?= get_site_url (); ?>",
     "sameAs" : [
    "https://www.facebook.com/linkableSEO",
    "https://www.twitter.com/linkableSEO",
    "https://www.linkedin.com/company/link-able"
    ]
    }

</script>
<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "LocalBusiness",
      "name" : "Link-able",
      "url": "<?= get_site_url (); ?>",
      "logo": "<?= get_site_url (); ?>/images/logo.png",
      "image": "<?= get_site_url (); ?>/images/logo.png",
      "description": "Link-able is a unique platform that connects website owners with elite authors to grow their traffic.",
  "telephone": "+1 (844) 546-5253",
"address": {
    "@type": "PostalAddress",
    "addressLocality": "Schaumburg",
    "addressRegion": "IL",
    "streetAddress": "1320 Tower Road",
    "postalCode": "60173"
  },
  "openingHours": [
    "Mo-Fr 09:00-17:00"
  ]
  }

</script>

<!-- FOOTER / END -->

<?php

if (/*!is_page_template( 'page-auth.php' ) && !is_page_template('page-submit-project.php') &&*/ ! is_user_logged_in () ) {
	/* ======= modal register template ======= */
//	get_template_part( 'template-js/modal', 'register' );
	/* ======= modal register template / end  ======= */
	/* ======= modal register template ======= */
//	get_template_part( 'template-js/modal', 'login' );
	/* ======= modal register template / end  ======= */
}

if ( is_page_template ( 'page-profile.php' ) ) {
	/* ======= modal add portfolio template ======= */
//get_template_part( 'template-js/modal', 'add-portfolio' );

//get_template_part( 'template-js/modal', 'delete-portfolio' );

//	get_template_part( 'template-js/modal', 'edit-portfolio' );

//	get_template_part( 'template-js/modal', 'delete-meta-history' );
//	get_template_part( 'template-js/modal', 'upload-avatar' );
	/* ======= modal add portfolio template / end  ======= */
}
/* ======= modal change password template ======= */
get_template_part ( 'template-js/modal', 'change-pass' );
/* ======= modal change password template / end  ======= */

get_template_part ( 'template-js/post', 'item' );
if ( is_page_template ( 'page-home.php' ) ) {
//	get_template_part( 'template-js/project', 'item-old' );
//	get_template_part( 'template-js/profile', 'item-old' );
} else {
	get_template_part ( 'template-js/project', 'item' );
	get_template_part ( 'template-js/profile', 'item' );
}
get_template_part ( 'template-js/user', 'bid-item' );

get_template_part ( 'template-js/portfolio', 'item' );
get_template_part ( 'template-js/work-history', 'item' );
get_template_part ( 'template-js/skill', 'item' );

if ( is_singular ( 'project' ) ) {

	//get_template_part( 'template-js/bid', 'item' );
	//get_template_part( 'template-js/modal', 'review' );
	//get_template_part( 'template-js/modal', 'bid' );
	//get_template_part( 'template-js/modal', 'not-bid' );
	//get_template_part( 'template-js/modal', 'transfer-money' );
	//get_template_part( 'template-js/modal', 'arbitrate' );
	if ( ae_get_option ( 'use_escrow' ) ) {
		//get_template_part( 'template-js/modal', 'accept-bid' );
	} else {
		//get_template_part( 'template-js/modal', 'accept-bid-no-escrow' );
	}
}

if ( is_author () ) {
	//get_template_part( 'template-js/author-project', 'item' );
}
//print modal contact template
if ( is_singular ( PROFILE ) || is_author () ) {
	//get_template_part( 'template-js/modal', 'contact' );
	/* ======= modal invite template ======= */
	//get_template_part( 'template-js/modal', 'invite' );
}

/* ======= modal invite template / end  ======= */
/* ======= modal forgot pass template ======= */
get_template_part ( 'template-js/modal', 'forgot-pass' );


/* ======= modal view portfolio  ======= */
//get_template_part( 'template-js/modal', 'view-portfolio' );
//get_template_part( 'template-js/modal', 'delete-project' );
//get_template_part( 'template-js/modal', 'archive-project' );
//get_template_part( 'template-js/modal', 'approve-project' );
//get_template_part( 'template-js/modal', 'reject-project' );
//get_template_part( 'template-js/modal', 'cancel-bid' );
//get_template_part( 'template-js/modal', 'remove-bid' );

//get_template_part( 'template-js/modal', 'delete-file' );
//get_template_part( 'template-js/modal', 'lock-file' );
//get_template_part( 'template-js/modal', 'unlock-file' );

// modal edit project
if ( ( get_query_var ( 'author' ) == $user_ID && is_author () )
     || current_user_can ( 'manage_options' ) || is_post_type_archive ( PROJECT )
     || is_page_template ( 'page-profile.php' ) || is_singular ( PROJECT )
) {
	//get_template_part( 'template-js/modal', 'edit-project' );
	//get_template_part( 'template-js/modal', 'reject' );
}

if ( is_singular ( PROJECT ) ) {
//	get_template_part( 'template-js/message', 'item' );
//	get_template_part( 'template-js/report', 'item' );
}
if ( is_page_template ( 'page-list-testimonial.php' ) ) {
//	get_template_part( 'template-js/testimonial', 'item' );
}
get_template_part ( 'template-js/notification', 'template' );

get_template_part ( 'template-js/freelancer-current-project-item' );
get_template_part ( 'template-js/freelancer-previous-project-item' );
get_template_part ( 'template-js/employer-current-project-item' );
get_template_part ( 'template-js/employer-previous-project-item' );

wp_footer ();


?>
<script>

</script>
<script type="text/template" id="ae_carousel_template"></script>


<script type="text/javascript">
    _linkedin_partner_id = "1590212";
    window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
    window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script>
<script type="text/javascript">
    (function () {
        var s = document.getElementsByTagName("script")[0];
        var b = document.createElement("script");
        b.type = "text/javascript";
        b.async = true;
        b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
        s.parentNode.insertBefore(b, s);
    })();
</script>
<noscript>
    <img height="1" width="1" style="display:none;" alt=""
         src="https://px.ads.linkedin.com/collect/?pid=1590212&fmt=gif"/>
</noscript>


</body>
</html>
