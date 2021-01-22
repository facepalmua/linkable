<?php
/**
 * Template Name: Linkable FAQ Page
 */

get_header();
?>


    <section class="page-header-container">
         <?php $header_text = get_field('styled_class_text'); 
	         echo $header_text;
         ?>
         
    </section>

<div class="entry-content faq-entry-content">

<?php
global $user_ID;

?>

<div class="faq-nav">
	<div class="column web-owners">
		
		<a class="active web-owner"><i class="fas fa-user-tie"></i><h2>For clients</h2></a>
	</div>
	
	<div class="column">
		
		<a class="content-author"><i class="fas fa-pencil-alt"></i><h2>For authors</h2></a>
	</div>
	
</div>

<div class="website-owner-qa">
	<?php 
		if( have_rows('website_owner_q&a') ): ?>
		
		<?php while( have_rows('website_owner_q&a') ): the_row(); 
	
			// vars
			$question = get_sub_field('question');
			$answer = get_sub_field('answer');
	
			?>
			<div class="faq-row">
				<div class="question"><?php echo $question; ?></div>
				<div class="answer"><?php echo $answer; ?></div>
			</div>
			
		<?php endwhile; ?>
		
	<?php endif; ?>
	
</div>

<div class="content-author-qa">
	<?php 
		if( have_rows('content_author_q&a') ): ?>
		
		<?php while( have_rows('content_author_q&a') ): the_row(); 
	
			// vars
			$question = get_sub_field('question');
			$answer = get_sub_field('answer');
	
			?>
			<div class="faq-row">
				<div class="question"><?php echo $question; ?></div>
				<div class="answer"><?php echo $answer; ?></div>
			</div>
		<?php endwhile; ?>
		
	<?php endif; ?>

</div>

<div class="faq-dont-see">
	<h3>Don't see your question?</h3>
	<p>Have a question you’d like answered? Email us at <a href="mailto:info@link-able.com">info@link-able.com</a></p>
	
</div>

    </div>
<?php
	
	
	echo '<div class="cta-buttons faq-cta">';
		echo '<div class="cta-button-column">';
			echo '<p>Ready to get started?</p>';
			echo '<h3>For <strong>clients</strong></h3>';
			echo '<a href="/client-account-registration" class="button shortcode-button">Sign up <i class="fa fa-chevron-circle-right"></i></a>';
		echo '</div>';
		
		echo '<div class="cta-button-column">';
			echo '<p>Ready to get started?</p>';
			echo '<h3>For <strong>authors</strong></h3>';
			echo '<a href="/author-account-registration" class="button shortcode-button">Apply now <i class="fa fa-chevron-circle-right"></i></a>';
		echo '</div>';
	
	echo '</div>';
		
?>



<?php get_footer(); ?>