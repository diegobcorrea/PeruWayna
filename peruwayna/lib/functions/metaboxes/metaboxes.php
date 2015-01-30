<?php

class ReedwanMetaboxes {
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
	}
	public function add_meta_boxes()
	{
		$this->add_meta_box('post_general','Post Settings', 'post');
		$this->add_meta_box('page_general','Page Settings', 'page');
		$this->add_meta_box('post_reviews','Review Settings', 'post');
		
		
	}
	public function add_meta_box($id, $label, $post_type)
	{
	    add_meta_box( 
	        'reedwan_' . $id,
	        $label,
	        array($this, $id),
	        $post_type,'normal' , 'low'
	    );
	}
	public function save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			update_post_meta($post_id, $key, $value);
		}
	}
	
	public function post_reviews()
	{		
		include 'review-metaboxes.php';
	}
	public function post_general()
	{		
		include 'general-metaboxes.php';
	}
	public function page_general()
	{		
		include 'page-metaboxes.php';
	}
	public function text($id, $label, $desc = '')
	{
		global $post;
		
		$html .= '<div class="reviewtext section">';
			$html .= '<label for="reedwan_' . $id . '">';
			$html .= '<strong>' .$label. '</strong>';
			$html .= '</label>';
			$html .= '<div class=" field">';
				$html .= '<input type="text" id="reedwan_' . $id . '" name="reedwan_' . $id . '" value="' . get_post_meta($post->ID, 'reedwan_' . $id, true) . '" />';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	public function textarea($id, $label, $desc = '')
	{
		global $post;
		
		$html .= '<div class="review section">';
			$html .= '<label for="reedwan_' . $id . '">';
			$html .= '<em>' .$label. '</em>';
			$html .= '</label>';
			$html .= '<div class=" field">';
				$html .= '<textarea id="reedwan_' . $id . '" name="reedwan_' . $id . '" cols="50" rows="4"> ' . get_post_meta($post->ID, 'reedwan_' . $id, true) . '</textarea>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	public function select($id, $label, $options, $desc = '')
	{
		global $post;
		
		$html .= '<div class=" review section">';
			$html .= '<label for="reedwan_' . $id . '">';
			$html .= '<em>' .$label. '</em>';
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<select class="small" id="reedwan_' . $id . '" name="reedwan_' . $id . '">';
				foreach($options as $key => $option) {
					if(get_post_meta($post->ID, 'reedwan_' . $id, true) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					
					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	
}

$metaboxes = new ReedwanMetaboxes;