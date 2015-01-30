<?php

function rd_add_post_metabox() {
add_meta_box( 'videof_settings', __('"Video" Format Settings', 'unicorn'), 'rd_videof_metabox_inner', 'post', 'normal' , 'high' );
add_meta_box( 'galleryf_settings', __('"Gallery" Format Settings', 'unicorn'), 'rd_galleryf_metabox_inner', 'post', 'normal' , 'high' );

}
add_action( 'add_meta_boxes', 'rd_add_post_metabox' );
add_action( 'save_post', 'rd_videof_metabox_save' );
add_action( 'save_post', 'rd_galleryf_metabox_save' );



//-----------------------------//
// DYNAMIC IMAGE UPLOAD ROW
//-----------------------------//
function Print_gallery_image_fileds($cnt, $gallImgUrl = null) {
if ($gallImgUrl === null){
    $a = '';
}else{
    $a = $gallImgUrl;
}
return 
'<div class="dynamicField">
	<input type="text" name="gallImg['.$cnt.']" value="'.$a.'">
	<input type="button" name="upload_image_button" class="upload_img button" value="'. __('Upload', 'unicorn') .'" />
	<input type="button" name="remove" class="remove button" value="&times;" />
</div>';}


//========================================//
// RENDER METABOXS
//========================================//


//-----------------------------//
// VIDEO POST FORMAT
//-----------------------------//
function rd_videof_metabox_inner( $post ) {
	global $post;
	$post_vals = get_post_custom( $post->ID );

	$videoType = isset( $post_vals['video_type'] ) ? esc_attr( $post_vals['video_type'][0] ) : '';
	$videoUrl = isset( $post_vals['video_url'] ) ? esc_attr( $post_vals['video_url'][0] ) : '';

	wp_nonce_field( 'video_meta_box_nonce', 'video-meta-box-nonce' ); 
	?>
	
	<div class="section first">
		<ul>
			<li>
				<div class="box">
					<label class="fix">Tipo de video : </label>
					<select name="video_type" id="video_type">
						<option value="0">Seleccionar video</option>
						<option value="vimeo" <?php echo $videoType == 'vimeo' ? 'selected="selected"' : ''; ?> >Vimeo</option>
						<option value="youtube" <?php echo $videoType == 'youtube' ? 'selected="selected"' : ''; ?> >Youtube</option>						
					</select>
				</div>
			</li>
			<li>
				<div class="box">
					<label class="fix">Video id : </label>
					<input type="text" name="video_url" id="video_url" value="<?php echo !empty($videoUrl) ? $videoUrl : ''; ?>" />						
				</div>
			</li>
		</ul>
	</div>
	
	<?php 
}


//-----------------------------//
// GALLERY POST FORMAT
//-----------------------------//
function rd_galleryf_metabox_inner( $post ) {
	global $post;
	$gallImages = get_post_meta($post->ID,"gallImg",true);
	
	wp_nonce_field( 'gallery_meta_box_nonce', 'gallery-meta-box-nonce' );
	?>
	
	
	
	<div class="section">
		<div id="gallImgs">
			<label for="prevImg"><strong><?php _e('Gallery Slides', 'unicorn');?></strong></label>
			<?php
			$c = 1;
			if (count($gallImages) > 0){
				foreach((array)$gallImages as $gallImgUrl ){
					echo Print_gallery_image_fileds($c,$gallImgUrl);
					$c = $c +1;
				}
			
			}?>
		</div>
		<span id="here"></span>
		<input type="button" name="add" class="add button" value="<?php _e('+ Add Slide Image', 'unicorn');?>" />
		
		<script>
	        var $ =jQuery.noConflict();
	            $(document).ready(function() {
	            
	            if ( $('.dynamicField:first input:first').val() == '' ){
	            	$('.dynamicField:first .remove').hide();
	            }
	            
	            
	            $('.dynamicField:first').find('input:first').change(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').hide();
	            	}
	            	else {
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            $('.dynamicField:first').find('.upload_img').click(function() {
	            	if ( $('.dynamicField:first input:first').val() == '' ){
	            		$('.dynamicField:first .remove').show();
	            	}
	            });
	            
	            
	            var count = <?php echo $c; ?>;
	            $(".add").click(function() {
	                count = count + 1;
	                $('#gallImgs').append('<?php echo implode('',explode("\n",Print_gallery_image_fileds('count'))); ?>'.replace(/count/g, count));
	                return false;
	            });
	            $(".remove").live('click', function() {
	                $(this).parent().remove();
	            });
	        });
	    </script>
	</div>
	
	<?php 
}



//========================================//
// SAVE METABOXS
//========================================//


//-----------------------------//
// VIDEO POST FORMAT
//-----------------------------//
function rd_videof_metabox_save( $post_id )  {  
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	if( !isset( $_POST['video-meta-box-nonce'] ) || !wp_verify_nonce( $_POST['video-meta-box-nonce'], 'video_meta_box_nonce' ) ) return; 
	if( !current_user_can( 'edit_post' ) ) return;  
	
	if( isset( $_POST['video_type'] ) )  
		update_post_meta( $post_id, 'video_type', esc_attr( $_POST['video_type'] ) );
	if( isset( $_POST['video_url'] ) )  
		update_post_meta( $post_id, 'video_url', esc_attr( $_POST['video_url'] ) );
}


//-----------------------------//
// GALLERY POST FORMAT
//-----------------------------//
function rd_galleryf_metabox_save( $post_id )  {  
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	if( !isset( $_POST['gallery-meta-box-nonce'] ) || !wp_verify_nonce( $_POST['gallery-meta-box-nonce'], 'gallery_meta_box_nonce' ) ) return; 
	if( !current_user_can( 'edit_post' ) ) return;  
	
	
	if (isset($_POST['gallImg'])){
        $gallImages = $_POST['gallImg'];
        update_post_meta($post_id,'gallImg',$gallImages);
    }else{
        delete_post_meta($post_id,'gallImg');
    }
}


