<?php
/**
 * Template Name: My Project with COMPLETED apps
 */
add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    $classes[] = 'dashboard';
    $classes[] = 'page-template-page-my-project';
    $classes[] = 'ie-my-project';

    return $classes;
}

$user_role = ae_user_role( $user_ID );

if ( ( ! is_user_logged_in() ) || ( $user_role == 'freelancer' ) ) {
    //wp_redirect( get_home_url() .  '/login' );
    $current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}

get_header();
global $wpdb, $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role = ae_user_role( $user_ID );
define( 'NO_RESULT', __( '', ET_DOMAIN ) );
$currency = ae_get_option( 'currency', array( 'align' => 'left', 'code' => 'USD', 'icon' => '$' ) );

?>


    <style>
        .dashboard-sidebar > ul > li.la_nav_app_project a {
            color: white;
            font-weight: bold;
        }
        .dashboard-sidebar > ul > li.la_nav_app_project a i {
            color: #1aad4b;
        }

        .employer-project-nav ul li:nth-child(5) a {
            color: #1aad4b;
            border-bottom: 1px solid #1faa49;
        }

        .project-sub-nav li:nth-child(5) a {
            color: white;
            font-weight: bold;
        }

    </style>


    <div class="entry-content landing-entry-content">

        <?php get_template_part( 'dashboard-side-nav-projects' ); ?>

        <div class="main-dashboard-content dashboard-landing inner-dashboard">
            <h1 class="entry-title">My Projects</h1>
            <p class="optional-text my-projects"><?php


                echo get_field( 'intro_text_copy' );

                echo '</p>';

                ?>
            </p>
            <div class="fre-page-section">
                <div class="container">
                    <div class="my-work-employer-wrap">

                        <div class="fre-tab-content">

                            <!-- EMPLOYER CONTENT STARTS HERE --->

                            <div id="current-project-tab" class="employer-current-project-tab fre-panel-tab active">
                                <?php
                                wp_reset_query();
                                $employer_current_project_query = new WP_Query(
                                    array(
                                        'posts_per_page'   => - 1,
                                        'is_author'        => true,
                                        'post_type'        => PROJECT,
                                        'author'           => $user_ID,
                                        'suppress_filters' => true,
                                        'orderby'          => 'date',
                                        'order'            => 'DESC',
                                        'paged'            => $paged
                                    )

                                );

                                $post_object       = $ae_post_factory->get( PROJECT );
                                $no_result_current = '';

                                $total_emp_posts   = $employer_current_project_query->found_posts;
                                $complete          = 0;
                                $with_app          = 0;
                                $with_accepted_app = 0;
                                $with_pending_app  = 0;
                                $no_app            = 0;

                                $all_status = [];

                                $status_class = '';

                                while ( $employer_current_project_query->have_posts() ) : $employer_current_project_query->the_post();


                                    $bid_query = new WP_Query( array(
                                            'post_type'      => BID,
                                            'post_parent'    => get_the_ID(),
                                            'posts_per_page' => - 1
                                        )
                                    );

                                    $bid_posts     = $bid_query->posts;
                                    $parent_status = get_post_status( get_the_ID() );

                                endwhile;

                                ?>

                                <div class="fre-work-project-box">
                                    <div class="current-employer-project">
                                        <div class="fre-table">

                                            <h2>My Projects</h2>

                                            <p class="optional-text my-projects">
                                                <?php if ( $user_role == 'employer' ) {
                                                    echo get_field( 'intro_text_projects_owner', 12 );
                                                } else if ( $user_role == 'freelancer' ) {
                                                    echo get_field( 'intro_text_copy' );
                                                }
                                                ?>
                                            </p>


                                            <?php include( locate_template( 'employer-project-query.php' ) );
                                            wp_reset_query(); ?>


                                            <div class="fre-current-table-rows">
                                                <?php


                                                $count = 0;

                                                if ( $complete == 0 ) {
                                                    echo 'Any project with completed contracts would show up here. However, it currently looks like you do not have any yet for us to display here.';
                                                } else if ( $employer_current_project_query->have_posts() ) {

                                                    $postdata     = array();
                                                    $num          = $employer_current_project_query->found_posts;
                                                    $count        = $num - ( $employer_current_project_query->posts_per_page * $employer_current_project_query->paged );
                                                    $num_pages    = $employer_current_project_query->max_num_pages;
                                                    $current_page = $paged = get_query_var( 'paged', 1 );


                                                    while ( $employer_current_project_query->have_posts() ) {
                                                        $employer_current_project_query->the_post();
                                                        $convert        = $post_object->convert( $post, 'thumbnail' );
                                                        $postdata[]     = $convert;
                                                        $project_status = $convert->post_status;
                                                        $count ++;

                                                        $total_posts = $num;


                                                        $bid_query = new WP_Query( array(
                                                                'post_type'      => 'bid',
                                                                'post_parent'    => get_the_ID(),
                                                                'posts_per_page' => - 1,
                                                                'post_status'    => array(
                                                                    'pending-completion',
                                                                    'complete',
                                                                    'completed'
                                                                )
                                                            )
                                                        );

                                                        $bid_posts     = $bid_query->posts;
                                                        $parent_status = get_post_status( get_the_ID() );

                                                        if ( ! empty( $bid_posts ) ) {


                                                            ?>


                                                            <?php //print_r($convert);
                                                            //echo get_post_status();
                                                            ?>

                                                            <div class="fre-table-row pending-completion">
                                                                <div class="fre-table-row-inner">
                                                                    <div class="project-details-head">
                                                                        <div>
                                                                            <h3 class="my-proj-title"><?php echo get_the_title(); ?></h3>
                                                                            <span class="green bold click-to-copy-wrapper">
                                                                                <span class="click-to-copy"><?php echo get_field( 'url_of_page_you_want_to_build_a_link_to', $convert->ID ) ?></span>
                                                                            </span>
                                                                        </div>
                                                                        <div>
                                                                            <div class="time-posted col-section">
                                                                                <?php echo '<span class="project-header">Posted: </span> ' . human_time_diff( get_the_time( 'U', $convert->post_parent ), current_time( 'timestamp' ) ) . ' ago'; ?>
                                                                            </div>
                                                                            <div class="project-category col-section">
                                                                                <span class="project-header">Category: </span>
                                                                                <?php
                                                                                //display category
                                                                                //			print_r($convert);
                                                                                $terms = get_the_terms( $convert->post_parent, 'project_category' );
                                                                                foreach ( $terms as $term ) {
                                                                                    echo $term->name;
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="project-description line-break"
                                                                         style="border-bottom: none">
                                                                        <div class="project-header">PROJECT
                                                                            DESCRIPTION:
                                                                        </div>
                                                                        <p><?php echo get_post_field( 'post_content', $convert->post_parent ); ?></p>
                                                                    </div>
                                                                    <div class="project-description no-underline line-break">
                                                                        <div class="project-header">DETAILS &
                                                                            REQUIREMENTS:
                                                                        </div>
                                                                        <p><?php
                                                                            if ( get_post_field( 'linkable_ideas', $convert->post_parent ) ) {
                                                                                echo get_post_field( 'linkable_ideas', $convert->post_parent );
                                                                            } else {
                                                                                echo 'None';
                                                                            }
                                                                            ?></p>
                                                                    </div>
                                                                    <div class="project-description no-underline attribute">
                                                                        <div class="project-header">Link Attribute</div>
                                                                        <p><?php $terms = get_the_terms( $convert->ID, 'project-follow-type' );

                                                                            $follow_type = [];
                                                                            $no_pref     = array(
                                                                                'NoFollow',
                                                                                'DoFollow'
                                                                            );
                                                                            foreach ( $terms as $term ) {
                                                                                array_push( $follow_type, $term->name );
                                                                            }
                                                                            if ( count( array_intersect( $follow_type, $no_pref ) ) == 2 ) {

                                                                                echo "NoFollow or DoFollow";
                                                                            } else {
                                                                                echo $follow_type[0];
                                                                            }
                                                                            ?>

                                                                        </p>
                                                                    </div>
	                                                                <?php
                                                                        $preferred_pages = get_field('preferred_pages_to_link', $convert->ID);
                                                                        echo la_build_backlinks_to_markup($preferred_pages);
	                                                                ?>
                                                                </div>

                                                                <div class="project-footer-bar <?= $parent_status; ?>">
                                                                    <div class="project-status-bar">
                                                                        <?php
                                                                        if ( $parent_status == 'complete' ) {
                                                                            echo '<strong>Project Status:</strong> <i>This project was unpublished</i>';
                                                                        } else if ( $parent_status == 'deleted' ) {
                                                                            echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                                        } else if ( $parent_status == 'cancelled' ) {
                                                                            echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                                        } else if ( $parent_status == 'deleted-accepted-app' ) {
                                                                            echo '<strong>Project Status:</strong> <i>This project was unpublished or has expired and will not receive any offers from new authors.</i>';
                                                                        } else if ( $status_class == 'no-app' ) {
                                                                            echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                                        } else if ( $status_class == 'active-app' ) {
                                                                            echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                                        } else if ( $status_class == 'accepted-app' ) {
                                                                            echo '<strong>Project Status:</strong> <i>Published and viewable for authors to apply.</i>';
                                                                        }

                                                                        $time_posted = current_time( 'timestamp' ) - get_the_time( 'U', $convert->post_parent );

                                                                        $expiration_days = get_field( 'project_expiration_time_in_days', 'option' );


                                                                        $seconds_in_month = 2592000;
                                                                        $seconds_in_day   = 86400;

                                                                        $seconds_allowed = $expiration_days * $seconds_in_day;

                                                                        $time_left = floor( ( $seconds_allowed - $time_posted ) / $seconds_in_day );
                                                                        if ( $time_left < 0 || get_post_status() == 'deleted' || get_post_status() == 'cancelled' ) {
                                                                            $time_text = " Expired";
                                                                        } else {
                                                                            $time_text = ' Expires in <span>' . $time_left . '</span> days';
                                                                        }

                                                                        //														if ( $parent_status != 'deleted' ) {
                                                                        //															echo '<span class="expires-wrap days-left"><i class="fa fa-calendar-alt"></i>' . $time_text . '</span>';
                                                                        //														}
                                                                        ?>

                                                                        <span class="hidden-id"><?php echo $convert->ID; ?></span>
                                                                        <?php if ( get_post_status() !== 'deleted' && get_post_status() !== 'cancelled' ) { ?><i
                                                                                class="fa fa-times owner-deletion">
                                                                            Unpublish
                                                                        </i>
                                                                        <?php } ?>

                                                                        <div class="delete-dropdown edit-ellipses-popup">
                                                                            <a class="owner-delete-project">Delete
                                                                                Project</a>
                                                                        </div>
                                                                        <?php
                                                                        echo do_shortcode( '[gravityform id=14 title=false description=false]' ); ?>
                                                                    </div>
                                                                    <a class="workspace-button"
                                                                       href="<?php echo get_permalink( $convert->ID ) ?>">
                                                                        Go to workroom <i class="fas fa-sign-out-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>


                                                    <?php }
                                                } else {
                                                    $no_result_current = 'Any project with completed contracts would show up here. However, it currently looks like you do not have any yet for us to display here.';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                        if ( $no_result_current != '' ) {
                                            //echo $no_result_current;
                                        }
                                        ?>
                                    </div>
                                </div>

                                <?php ?>

                                <nav>
                                    <?php echo paginate_links( array(
                                        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'format'  => '?paged=%#%',
                                        'current' => max( 1, get_query_var( 'paged' ) ),
                                        'total'   => $wp_query->max_num_pages
                                    ) );
                                    ?>
                                </nav>

                                <?php

                                wp_reset_postdata();
                                wp_reset_query();
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>