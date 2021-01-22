<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */

//if not logged in, redirect


add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';

    return $classes;
}


if ( is_user_logged_in() ) {
    $user_role = ae_user_role( $user_ID );

    if ( $user_role == 'freelancer' ) {
        $current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
    }


} else {
    $current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
    die();
}

get_header();
$current_page  = $post->ID;
$shown_project = 'Project ' . $current_page;
$user_role     = ae_user_role( $user_ID );

$employer_current_project_query = new WP_Query(
    array(
        'post_status'      => array(
            'close',
            'disputing',
            'publish',
            'pending',
            'draft',
            'reject',
            'archive',
            'pending-completion'
        ),
        'is_author'        => true,
        'post_type'        => PROJECT,
        'author'           => $user_ID,
        'suppress_filters' => true,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'posts_per_page'   => - 1
    )
);

$post_object       = $ae_post_factory->get( PROJECT );
$no_result_current = '';


?>


<?php


global $wp_query, $ae_post_factory, $post, $user_ID;
$post_object = $ae_post_factory->get( PROJECT );
$convert     = $post_object->convert( $post );
if ( have_posts() ) {
    the_post();

    ?>


    <style>
        .dashboard-sidebar > ul > li:nth-child(2) a {
            color: white;
            font-weight: bold;
        }

        .dashboard-sidebar > ul > li:nth-child(2) a i {
            color: #1aad4b;
        }

        .fre-project-detail-wrap > div {
            padding: 20px;
        }

        .single-project .fre-project-detail-wrap .bid-nav {
            margin-bottom: 25px;
        }

        .url-for-author {
            margin-top: 0;
            padding-bottom: 18px;
            margin-bottom: 20px;
            padding-right: 20px;
            padding-top: 15px;
        }
        #gform_18 .ginput_container_textarea .ginput_counter:not(:first-child) {
          display: none;
        }
    </style>


    <div class="entry-content landing-entry-content">
        <?php
        if ( $user_role == 'employer' ) {
            if ( get_the_author_id() !== $user_ID ) {
                wp_redirect( get_home_url() . '/dashboard/' );
            }
            get_template_part( 'dashboard-side-nav-projects' );
        } else {
            get_template_part( 'dashboard-side-nav' );
        }


        ?>
        <div class="main-dashboard-content dashboard-landing inner-dashboard">


            <div class="cart-banner">
                <div class="left-column">
                    <div class="num-selected"><span class="num">0</span> <span class="app-numberdd"></span>author
                        contracts selected
                    </div>
                    <ul class="selected-project-names">
                    </ul>
                </div>
                <div class="right-column">
                    <div class="total-header">Total:</div>
                    <div class="total-price green">$<span></span></div>
                    <?php echo do_shortcode( '[gravityform id="5" title="false" description="false"]' ); ?>
                </div>
            </div>

            <div class="fre-page-wrapper">
                <div class="container">
                    <h1 style="margin-bottom: 30px">Project Workroom</h1>
                    <div class="fre-project-detail-wrap">

                        <?php
                        if ( ( isset( $_REQUEST['workspace'] ) && $_REQUEST['workspace'] ) || $user_role == FREELANCER ) {
                            get_template_part( 'template/project-workspace', 'info' );
                            //get_template_part( 'template/project-workspace', 'content' );
                        } else {
                            if ( isset( $_REQUEST['dispute'] ) && $_REQUEST['dispute'] ) {
                                get_template_part( 'template/project', 'report' );
                            } else {
                                get_template_part( 'template/single-project', 'info' );
                                //get_template_part( 'template/single-project', 'content' );
                                get_template_part( 'template/single-project', 'bidding' );
                            }
                        }
                        echo '<script type="data/json" id="project_data">' . json_encode( $convert ) . '</script>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        if (jQuery("#gform_confirmation_message_11").length) {
            jQuery(".project-intro-wrap").hide();
            jQuery(".project-detail-box").hide();
            jQuery(".instructions-and-submit .white-bg").hide();
            jQuery(".instructions-and-submit p:first-child").hide();
            jQuery(".mark-complete").hide();
            jQuery(".have-a-problem").hide();

            jQuery(".freelancer.single-project h1").css("margin-left", "0px");
            jQuery(".instructions-and-submit").css("padding-left", "0px");

        }
        ;

        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });


    </script>
<?php }


get_footer();
