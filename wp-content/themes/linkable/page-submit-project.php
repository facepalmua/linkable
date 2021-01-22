<?php
/**
 * Template Name: Page Post Project
*/

 add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}

global $user_ID;
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

    <div class="fre-page-section">
        <div class="container">
            <div class="page-post-project-wrap" id="post-place">
                <?php
                    // check disable payment plan or not
                    $disable_plan = ae_get_option('disable_plan', false);
                    if(!$disable_plan) {
                        // template/post-place-step1.php
                        get_template_part( 'template/post-project', 'step1' );
                    }

                    // template/post-place-step3.php
                    get_template_part( 'template/post-project', 'step3' );

                    if(!$disable_plan) {
                        // template/post-place-step4.php
                        get_template_part( 'template/post-project', 'step4' );
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();