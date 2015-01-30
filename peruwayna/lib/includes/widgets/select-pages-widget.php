<?php
add_action('widgets_init', 'select_pages_load_widgets');

function select_pages_load_widgets()
{
	register_widget('Select_Pages_Widget');
}

class Select_Pages_Widget extends WP_Widget {
	
	function Select_Pages_Widget()
	{
		$widget_ops = array('classname' => 'select_pages_widget', 'description' => 'Area for selected pages on your site');

		$control_ops = array('id_base' => 'select_pages_widget');

		$this->WP_Widget('select_pages_widget', 'Selected Pages', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$title = $instance['title'];
		$pages = trim($instance['pages']);
		$show_image = isset($instance['show_image']) ? 'true' : 'false';
		
		echo $before_widget;
		?>
		<!-- BEGIN WIDGET -->
		<?php
		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
	
		<?php
		$arr = explode(",",$pages);
		$selected_pages = new WP_Query(array('post_type' => 'page','post__in' => $arr, 'order' => 'ASC' ));
		$counter = 1; 

		while($selected_pages->have_posts()): $selected_pages->the_post(); 
			global $post;
		?>
		<div id="box-course" class="five columns <?php if ($counter % 2) : echo 'green'; else : echo 'blue'; endif; ?> <?php if ($counter <= 2) : echo 'dorow'; endif ?>" style="margin-right:20px; margin-left:20px">
			<div class="inner">
				<?php if(has_post_thumbnail()): ?>
				<?php if($show_image == 'true'): ?>
				<div class="magz-image small">
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_post_thumbnail( $post->ID, 'homepage-thumb' ); ?></a>
				</div>
				<?php endif; ?>
				<?php endif; ?>
				<div class="small-homedesc">
					<h4 class="desc-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h4>
					<?php $small_content = get_post_meta($post->ID, 'small_content_value', true); ?>
					<div><?php echo $small_content; ?></div>

				</div>
			</div>
		</div>
		<?php $counter++; endwhile; ?>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['pages'] = $new_instance['pages'];
		$instance['show_image'] = $new_instance['show_image'];
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Selected Pages', 'post_type' => 'page', 'show_image'=>null);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('pages'); ?>">Pages ID (separated by commas. Ex: 1, 2, 3, 4):</label> 
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('pages'); ?>" name="<?php echo $this->get_field_name('pages'); ?>" value="<?php echo $instance['pages']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_image'); ?>">Show thumbnail image</label>
		</p>
		
	<?php 
	}
}
?>