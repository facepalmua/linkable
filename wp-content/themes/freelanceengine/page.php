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

    <section class="blog-header-container">
        <div class="container">
            <!-- blog header -->
            <div class="row">
                <div class="col-md-12 blog-classic-top">
                    <h2><?php the_title(); ?></h2>
                </div>
            </div>
            <!--// blog header  -->
        </div>
    </section>

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
                <div class="col-md-8 col-sm-12 col-xs-12 posts-container" id="left_content">
                    <div class="blog-content">
						<?php
						the_content();
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', ET_DOMAIN ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
						?>

                        <div class="clearfix"></div>
                    </div><!-- end page content -->
                </div><!-- LEFT CONTENT -->
			<?php } ?>
            <div class="col-md-4 col-sm-12 col-xs-12 page-sidebar blog-sidebar" id="right_content">
				<?php get_sidebar( 'page' ); ?>
            </div><!-- RIGHT CONTENT -->
        </div>
        <!--// block control  -->
    </div>
<?php
get_footer();
?>