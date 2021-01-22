<?php
wp_reset_query();
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
if ( is_active_sidebar( 'fre-footer-1' ) || is_active_sidebar( 'fre-footer-2' )
     || is_active_sidebar( 'fre-footer-3' ) || is_active_sidebar( 'fre-footer-4' )
) {
	$flag = true; ?>
    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <div class="row">
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar( 'fre-footer-1' ) ) {
								dynamic_sidebar( 'fre-footer-1' );
							} ?>
                        </div>
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar( 'fre-footer-2' ) ) {
								dynamic_sidebar( 'fre-footer-2' );
							} ?>
                        </div>
                        <div class="col-sm-4">
							<?php if ( is_active_sidebar( 'fre-footer-3' ) ) {
								dynamic_sidebar( 'fre-footer-3' );
							} ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
					<?php if ( is_active_sidebar( 'fre-footer-4' ) ) {
						dynamic_sidebar( 'fre-footer-4' );
					} ?>
                </div>
            </div>
        </div>
    </footer>
<?php } else {
	$flag = false;
} ?>
<div class="copyright-wrapper <?php if ( ! $flag ) {
	echo 'footer-copyright-wrapper';
} ?>">
	<?php
	$copyright = ae_get_option( 'copyright' );
	$col       = 'col-md-6 col-sm-6';
	?>
    <div class="container">
        <div class="row">
            <div class="<?php echo $col ?>">
                <div class="fre-footer-logo">
                    <a href="<?php echo home_url(); ?>" class="logo-footer"><?php fre_logo( 'site_logo' ) ?></a>
                </div>
            </div>
            <div class="<?php echo $col; ?> ">
                <p class="text-copyright">
					<?php if ( $copyright ) {
						echo $copyright;
					} ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER / END -->

<?php

if (/*!is_page_template( 'page-auth.php' ) && !is_page_template('page-submit-project.php') &&*/ ! is_user_logged_in() ) {
	/* ======= modal register template ======= */
	get_template_part( 'template-js/modal', 'register' );
	/* ======= modal register template / end  ======= */
	/* ======= modal register template ======= */
	get_template_part( 'template-js/modal', 'login' );
	/* ======= modal register template / end  ======= */
}

if ( is_page_template( 'page-profile.php' ) ) {
	/* ======= modal add portfolio template ======= */
	get_template_part( 'template-js/modal', 'add-portfolio' );

	get_template_part( 'template-js/modal', 'delete-portfolio' );

	get_template_part( 'template-js/modal', 'edit-portfolio' );

	get_template_part( 'template-js/modal', 'delete-meta-history' );
	get_template_part( 'template-js/modal', 'upload-avatar' );
	/* ======= modal add portfolio template / end  ======= */
}
/* ======= modal change password template ======= */
get_template_part( 'template-js/modal', 'change-pass' );
/* ======= modal change password template / end  ======= */

get_template_part( 'template-js/post', 'item' );
if ( is_page_template( 'page-home.php' ) ) {
	get_template_part( 'template-js/project', 'item-old' );
	get_template_part( 'template-js/profile', 'item-old' );
} else {
	get_template_part( 'template-js/project', 'item' );
	get_template_part( 'template-js/profile', 'item' );
}
get_template_part( 'template-js/user', 'bid-item' );

get_template_part( 'template-js/portfolio', 'item' );
get_template_part( 'template-js/work-history', 'item' );
get_template_part( 'template-js/skill', 'item' );

if ( is_singular( 'project' ) ) {

	get_template_part( 'template-js/bid', 'item' );
	get_template_part( 'template-js/modal', 'review' );
	get_template_part( 'template-js/modal', 'bid' );
	get_template_part( 'template-js/modal', 'not-bid' );
	get_template_part( 'template-js/modal', 'transfer-money' );
	get_template_part( 'template-js/modal', 'arbitrate' );
	if ( ae_get_option( 'use_escrow' ) ) {
		get_template_part( 'template-js/modal', 'accept-bid' );
	} else {
		get_template_part( 'template-js/modal', 'accept-bid-no-escrow' );
	}
}

if ( is_author() ) {
	get_template_part( 'template-js/author-project', 'item' );
}
//print modal contact template
if ( is_singular( PROFILE ) || is_author() ) {
	get_template_part( 'template-js/modal', 'contact' );
	/* ======= modal invite template ======= */
	get_template_part( 'template-js/modal', 'invite' );
}

/* ======= modal invite template / end  ======= */
/* ======= modal forgot pass template ======= */
get_template_part( 'template-js/modal', 'forgot-pass' );


/* ======= modal view portfolio  ======= */
get_template_part( 'template-js/modal', 'view-portfolio' );
get_template_part( 'template-js/modal', 'delete-project' );
get_template_part( 'template-js/modal', 'archive-project' );
get_template_part( 'template-js/modal', 'approve-project' );
get_template_part( 'template-js/modal', 'reject-project' );
get_template_part( 'template-js/modal', 'cancel-bid' );
get_template_part( 'template-js/modal', 'remove-bid' );

get_template_part( 'template-js/modal', 'delete-file' );
get_template_part( 'template-js/modal', 'lock-file' );
get_template_part( 'template-js/modal', 'unlock-file' );

// modal edit project
if ( ( get_query_var( 'author' ) == $user_ID && is_author() )
     || current_user_can( 'manage_options' ) || is_post_type_archive( PROJECT )
     || is_page_template( 'page-profile.php' ) || is_singular( PROJECT )
) {
	get_template_part( 'template-js/modal', 'edit-project' );
	get_template_part( 'template-js/modal', 'reject' );
}

if ( is_singular( PROJECT ) ) {
	get_template_part( 'template-js/message', 'item' );
	get_template_part( 'template-js/report', 'item' );
}
if ( is_page_template( 'page-list-testimonial.php' ) ) {
	get_template_part( 'template-js/testimonial', 'item' );
}
get_template_part( 'template-js/notification', 'template' );

get_template_part( 'template-js/freelancer-current-project-item' );
get_template_part( 'template-js/freelancer-previous-project-item' );
get_template_part( 'template-js/employer-current-project-item' );
get_template_part( 'template-js/employer-previous-project-item' );

wp_footer();
?>

<script type="text/template" id="ae_carousel_template">
    <li class="image-item" id="{{= attach_id }}">
        <div class="attached-name"><p>{{= name }}</p></div>
        <div class="attached-size">{{= size }}</div>
        <div class="attached-remove"><span class=" delete-img delete"><i class="fa fa-times"></i></span></div>
    </li>
</script>


</body>
</html>