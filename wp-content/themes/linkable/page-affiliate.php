<?php
/**
 * Template Name: Affiliate 
 */

get_header();
 
   add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
 function body_class_wpse_85793( $classes, $class )
{
    $classes[] = 'dashboard';
    return $classes;
}
?>

<div class="entry-content landing-entry-content">

<?php
global $user_ID;

$hero_bg = get_field('hero_image_background');
$hero_text = get_field('hero_image_text');
$how_headline = get_field('how_it_works_headline');
$green_headline = get_field('green_bar_text');

$first_section_image = get_field('first_section_image');
$first_section_text = get_field('first_section_text');

$second_section_image = get_field('first_section_image_copy');
$second_section_text = get_field('first_section_text_copy');

$comm_table = get_field('commission_table');
$comm_text = get_field('commission_text');

$our_mission_bg = get_field('background_image');
$our_mission_text = get_field('our_mission_text');

$get_started_text = get_field('top_text');
$how_steps = get_field('how');

$cta_text = get_field('header');

$have_question = get_field('have_a_question_text');

?>

<style>
	.hero-section {background: url('<?php echo $hero_bg; ?>');
		background-size: cover;
		background-repeat: no-repeat;}
</style>


<?php
	echo '<div class="hero-section">';
		echo $hero_text;
	echo '</div>';
	
	echo '<div class="how-it-works-section">';
		echo $how_headline;
		
		echo '<div class="how-icons-row">';	

						
		echo '</div>';
	echo '</div>';
	
	
	echo '<div class="image-text-section first">';
		echo '<div class="image-holder" style="background:url('.$first_section_image.')">';
		echo '</div>';
		
		echo '<div class="text-holder">';
			echo '<div class="text-contain">';
				echo $first_section_text;
			echo '</div>';
		echo '</div>';
	
	echo '</div>';
	
	
	echo '<div class="how-it-works-section green-bar">';
		echo $green_headline;
		
		echo '<div class="how-icons-row">';	

						
		echo '</div>';
	echo '</div>';
	
	echo '<div class="image-text-section second">';
	
		echo '<div class="text-holder">';
			echo '<div class="text-contain">';
				echo $second_section_text;
			echo '</div>';
		echo '</div>';
	
		echo '<div class="image-holder" style="background:url('.$second_section_image.')">';
		echo '</div>';
	
	echo '</div>';
	
	
		
	echo '<div class="affiliate-mission" style="background:url('.$our_mission_bg.');">';
		echo $our_mission_text;
	echo '</div>';
	
	echo '<div class="get-started-affiliate">';
		echo $get_started_text;
		
		if( have_rows('how') ): ?>
			<div class="affiliate-how-contain">
					<?php 
						$i = 1;
						while( have_rows('how') ): the_row(); 
								
								// vars
								$head_text = get_sub_field('header');
								$main_text = get_sub_field('text');
								?>
								<div class="affiliate-how-steps">
									<div class="num-step"><?php echo $i; ?></div>
									<div class="head-text"><?php echo $head_text; ?></div>
									<div class="main-text"><?php echo $main_text; ?></div>
								</div>
								
								<?php $i++; ?>
								
							<?php endwhile; ?>
							
					<?php endif; 
			echo '</div>';
	echo '</div>';
	
	echo '<div class="affiliate-sign-up">';
		echo $cta_text;
	echo '</div>';
	
	echo '<div class="have-a-question">';
		echo $have_question;
	echo '</div>';
	
	
		echo '<div class="cta-buttons faq-cta">';
		echo '<div class="cta-button-column">';
			echo '<p>Ready to get started?</p>';
			echo '<h3>For <strong>clients</strong></h3>';
			echo '<a href="/client-account-registration" class="button shortcode-button">Sign Up <i class="fa fa-chevron-circle-right"></i></a>';
		echo '</div>';
		
		echo '<div class="cta-button-column">';
			echo '<p>Ready to get started?</p>';
			echo '<h3>For <strong>authors</strong></h3>';
			echo '<a href="/author-account-registration" class="button shortcode-button">Apply Now <i class="fa fa-chevron-circle-right"></i></a>';
		echo '</div>';
	
	echo '</div>';
		
?>

</div>
<?php get_footer(); ?>