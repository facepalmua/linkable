<script type="text/template" id="ae-project-loop">

    <div class="project-list-wrap fre-table-row">
	    <div class="project-top-bar">
		    <div class="left-container">
			    <div class="col-section">
		    <span class="project-header">Category</span>
		    <span class="bold green">
		    			<?php 
					//display category
				    $terms = get_the_terms( $post->ID, 'project_category' ); 
				    foreach($terms as $term) {
				      echo $term->name;
				    }
				?>	 
		    </span>
			    </div>

			
<?php 
	//posted x hours ago
	?>
	   <div class="col-section">
		   <?php
	echo ' <span class="project-header">Posted</span><span class="bold">' . human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; 
	
	echo '</span></div>';
	
	echo '</div>';

?>
	
		    
		     <a class="button green-bg" href="http://localhost/linkable/apply-to-project/?title_field=<?php echo the_title(); ?>&parent_id=<?php echo get_the_ID(); ?>">Apply Now</a>
		     
		     	    </div>
	<div class="project-description">
		<div class="project-header">Description</div>

<?php
	//Description
	the_content();
	
	?>
	</div>
	<div class="project-description padding-bottom">
		<div class="project-header">Linkable Ideas</div>
	<?php
	
	//Linkable ideas
	the_field('linkable_ideas');
	
	?>
	
	</div>
	<div class="project-description no-bottom-border">
		<div class="project-header">Link Attribute</div>
		<span class="italic">
	<?php
	
	//Link attribute
	 $terms = get_the_terms( $post->ID, 'project-follow-type' ); 
			    foreach($terms as $term) {
			      echo $term->name;
			    }
			    
			    ?>
		</span>
	</div>
	<?php
			    
				
	
	
	?>
	   
	    
	    


        <!-- <div class="project-list-bookmark">
            <a class="fre-bookmark" href="">Bookmark</a>
        </div> -->
    </div>



</script>