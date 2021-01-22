<?php
/**
 * Template Name: Linkable Landing Page
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

$testimonial_headline = get_field('testimonial_heading');

?>

<style>
	.hero-section {background: url('<?php echo $hero_bg; ?>');
		background-size: cover;
		background-repeat: no-repeat;}
</style>


<?php
	echo '<div class="hero-section">';
		//echo '<img class="watch-arrow" src="'.get_home_url() . '/wp-content/themes/linkable/images/watch-video-arrow.svg">';
		echo $hero_text;
	echo '</div>';
	
	echo '<div class="how-it-works-section">';
		echo $how_headline;
		
		echo '<div class="how-icons-row">';	
			//echo $how_icon;
			

			if( have_rows('how_it_works_columns') ): ?>
			
				<?php while( have_rows('how_it_works_columns') ): the_row(); 
						
				
						// vars
						$how_icon = get_sub_field('icon');
						$step_text = get_sub_field('step_text');
						$step_para = get_sub_field('step_paragara');
						?>
						<div class="how-column">
							<div class="how-icon"><img src="<?php echo $how_icon; ?>"></div>
							<div class="step-text"><?php echo $step_text; ?></div>
							<div class="step_para"><?php echo $step_para; ?></div>
						</div>
						
					<?php endwhile; ?>
					
			<?php endif; 
						
		echo '</div>';
	echo '</div>';
	
	
	echo '<div class="how-gray-white-rows">';

			
				if( have_rows('white_and_gray_rows') ): ?>
				
				<?php while( have_rows('white_and_gray_rows') ): the_row(); 
					echo "<div class='gw-row'>";
						echo '<div class="container">';
						
						// vars
						echo "<div class='column'>";
							$white_gray_image = get_sub_field('image');
							echo "<img src='". $white_gray_image . "'>";
						echo "</div>";
						
						echo "<div class='column text'>";
							echo "<div class='text-contain'>";
								$white_gray_text = get_sub_field('text');
								echo $white_gray_text;
							echo "</div>";
						echo "</div>";
						
						echo '</div>';
					echo "</div>";
			
					?>
				<?php endwhile; ?>
				
			<?php endif;


	echo '</div>';
	
	echo '<div class="landing-testimonials">';
		echo '<div class="stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>';
		echo '<h2>' . $testimonial_headline . '</h2>';
		
		$testimonial_shortcode = get_field('testimonial_shortcode');
		
		echo do_shortcode(''.$testimonial_shortcode.'');
		
	echo '</div>';
	
	
	echo '<div class="cta-buttons">';
		echo '<div class="cta-button-column">';
			echo '<h3>Get <strong>started</strong> today!</h3>';
			echo '<a href="'.get_field('registration_link') .'" class="button shortcode-button">Apply Now <i class="fa fa-chevron-circle-right"></i></a>';
		echo '</div>';
		
		echo '<div class="cta-button-column">';
			echo '<h3>Got <strong>questions?</strong></h3>';
			echo '<a href="'. get_home_url() . '/contact/" class="button shortcode-button">Contact Us</a>';
			echo '<a href="'.get_home_url().'/faqs/" class="visit-faq"> or visit our FAQs</a>';
		echo '</div>';
	
	echo '</div>';
		
?>

</div>
<?php get_footer(); ?>