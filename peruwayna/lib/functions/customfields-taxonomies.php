<?php

add_action( 'papa-categories_edit_form_fields', 'papa_categories_taxonomy_custom_fields', 10, 2 );
add_action( 'edited_papa-categories', 'save_taxonomy_custom_fields', 10, 2 );
add_action( 'papa-categories_add_form_fields', 'papa_categories_add_taxonomy_field', 10, 2 );
add_filter( 'manage_edit-papa-categories_columns', 'papa_categories_taxonomy_columns' );
add_filter( 'manage_papa-categories_custom_column', 'papa_categories_taxonomy_column', 10, 3 );
add_action( 'quick_edit_custom_box', 'papa_categories_quick_edit_custom_box', 10, 3);

// A callback function to add a custom field to our "presenters" taxonomy  
function papa_categories_taxonomy_custom_fields($tag) {  
   // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check  
?>  
  
<tr class="form-field">  
    <th scope="row" valign="top">  
        <label for="taxt_order"><?php _e('Order'); ?></label>  
    </th>  
    <td>  
        <input type="text" name="term_meta[taxt_order]" id="term_meta[taxt_order]" size="25" style="width:60%;" value="<?php echo $term_meta['taxt_order'] ? $term_meta['taxt_order'] : ''; ?>"><br />  
        <span class="description"><?php _e('Determines the order which taxonomy appears.'); ?></span>  
    </td>  
</tr>  
  
<?php  
}  

// add image field in add form
function papa_categories_add_taxonomy_field() {
?>
<div class="form-field">
	<label for="taxt_order"><?php _e('Order'); ?></label>
	<input type="text" name="term_meta[taxt_order]" id="term_meta[taxt_order]" value="" />
</div>
<?php
}

// A callback function to save our extra taxonomy field(s)
function save_taxonomy_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

function papa_categories_taxonomy_columns( $columns ) {
	$columns['order'] = 'Order';
    return $columns;
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function papa_categories_taxonomy_column( $columns, $column, $id ) {
	if ( $column == 'order' )
    	$term_meta = get_option( "taxonomy_term_$id" ); // Do the check  

		$columns = $term_meta['taxt_order'] ? $term_meta['taxt_order'] : '';
	
	return $columns;
}

function papa_categories_quick_edit_custom_box($column_name, $screen, $name ) {
	if ( $column_name == 'order' ) :
		$term_meta = get_option( "taxonomy_term_$id" ); // Do the check  
	?>
		<fieldset><div class="inline-edit-col">
			<label>
				<span class="title"><?php _e( 'Order' ); ?></span>
				<span class="input-text-wrap"><input type="text" name="term_meta" class="ptitle" value="<?php $term_meta['taxt_order'] ? $term_meta['taxt_order'] : ''; ?>"></span>
			</label>
		</div></fieldset>
	<?php endif;
}