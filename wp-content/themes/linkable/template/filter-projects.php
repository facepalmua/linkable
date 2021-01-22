<?php
$category_project_selected = '';
if ( isset( $_GET['category_project'] ) && $_GET['category_project'] != '' ) {
	$category_project_selected = $_GET['category_project'];
}

?>

<div class="fre-project-filter-box">
    <script type="data/json" id="search_data">
            <?php
		$search_data = $_POST;
		echo json_encode( $search_data );
		?>

    </script>
    <div class="project-filter-header visible-sm visible-xs">
        <a class="project-filter-title" href=""><?php _e( 'Advance search', ET_DOMAIN ); ?></a>
    </div>
    <div class="fre-project-list-filter">
	    <span>Filter by</span>
        <form>
            <div class="row filter-row">

            
                    <div class="fre-input-field">
                        <label for="project_category"
                               class="fre-field-title"><?php _e( 'Category', ET_DOMAIN ); ?></label>
						<?php ae_tax_dropdown( 'project_category', array(
								'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" data-placeholder="' . __( "Select categories", ET_DOMAIN ) . '"',
								'show_option_all' => __( "Category", ET_DOMAIN ),
								'class'           => 'fre-chosen-single',
								'hide_empty'      => false,
								'hierarchical'    => true,
								'selected'        => $category_project_selected,
								'id'              => 'project_category',
								'value'           => 'slug',
							)
						); ?>
                    </div>
      
                
              
                    <div class="fre-input-field">
                        <label for="link_attribute"
                               class="fre-field-title"><?php _e( 'Link Attribute', ET_DOMAIN ); ?></label>
						<?php ae_tax_dropdown( 'project-follow-type', array(
								'attr'            => 'data-chosen-width="100%" data-chosen-disable-search="" data-placeholder="' . __( "Link Attribute", ET_DOMAIN ) . '"',
								'show_option_all' => __( "Link Attribute", ET_DOMAIN ),
								'class'           => 'fre-chosen-single',
								'hide_empty'      => false,
								'hierarchical'    => false,
								'selected'        => $link_attribute_selected,
								'id'              => 'project-follow-type',
								'value'           => 'slug',
							)
						); ?>
                    </div>
         


                           </div>
          
        </form>
    </div>
</div>