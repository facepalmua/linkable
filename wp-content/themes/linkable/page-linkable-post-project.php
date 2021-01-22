<?php
/**
 * Template Name: Linkable Post a Project
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
	$classes[] = 'dashboard';

	return $classes;
}

if ( ! is_user_logged_in() ) {
	$current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}

if ( ae_user_role() == FREELANCER ) {
	wp_redirect( get_home_url() . '/dashboard/' );
}

get_header();
?>

    <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript"
            charset="utf-8"></script>
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css" type="text/css"
          rel="stylesheet"/>
    <style>
        .dashboard-sidebar ul li:first-child a {
            color: white;
            font-weight: bold;
        }

        .dashboard-sidebar ul li:first-child a i {
            color: #1aad4b;
        }

        .featherlight-content {
            width: 80%;
        }

        .featherlight-content .project-list-wrap {
            display: block;
        }

    </style>

    <div class="entry-content landing-entry-content">

		<?php
		global $user_ID;
		?>

		<?php get_template_part( 'dashboard-side-nav' ); ?>

        <div class="main-dashboard-content dashboard-landing inner-dashboard">


            <h1 class="entry-title"><?php the_title(); ?></h1>

            <div class="entry-content">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						the_content();
					endwhile;
				endif;
				?>
            </div>

            <div class="preview-panel">

                <div class="popup" id="mylightbox">
                    <div class="caveat">This is just a preview to show you how authors will see your project
                        once it's posted:
                    </div>
                    <li class="project-item">
                        <div class="project-list-wrap fre-table-row cm-project-post-review">
                            <div class="project-details-head">
                                <div>
                                    <h3 class="my-proj-title"></h3>
                                    <div class="project-description owner-url no-bottom-border">
                                        <span class="green bold">
                                            <span></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="left-container">
                                    <div class="col-section">
                                        <span class="project-header">Category</span>
                                        <span class="cat-name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="project-top-bar">

                                <div class="project-description description no-bottom-border">
                                    <div class="project-header">Project Description:</div>
                                    <span></span>
                                </div>

                                <div class="project-description linkable-ideas padding-bottom no-bottom-border">
                                    <div class="project-header">Details & Requirements:</div>
                                    <span></span>

                                </div>

                                <div class="project-description backlink-on no-bottom-border">
                                    <div class="project-header">Wants a backlink on:</div>
                                    <span></span>
                                </div>

                                <div class="project-description link-attribute no-bottom-border">
                                    <div class="project-header">Desired Link Attribute:</div>
                                    <span class="italic">
                                        <span></span>
                                    </span>
                                </div>



                            </div>
                        </div>
                    </li>
                </div>
            </div>

        </div>

    </div>

    <script>

        //hide page info after posting a project
        if (jQuery("#gform_confirmation_message_3").length) {
            jQuery(".entry-content p:first-child").hide();
            jQuery("h1.entry-title").text("Project Posted!");
        }
        ;


    </script>


<?php get_footer(); ?>