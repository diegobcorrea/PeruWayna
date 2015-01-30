<?php
add_action('widgets_init', 'vita_posts_load_widgets');

function vita_posts_load_widgets()
{
	register_widget('Vita_Posts_Widget');
}

class Vita_Posts_Widget extends WP_Widget {
	
	function Vita_Posts_Widget()
	{
		$widget_ops = array('classname' => 'vita_posts_widget', 'description' => 'The most recent posts on your site');

		$control_ops = array('id_base' => 'vita_posts_widget');

		$this->WP_Widget('vita_posts_widget', 'Recent Posts With Thumbnails', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$title = $instance['title'];
		$post_type = 'all';
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$url = $instance['url'];
		$images = true;
		
		echo $before_widget;
		?>
		<!-- BEGIN WIDGET -->
		<?php
		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		
		
		<?php
		$recent_posts = new WP_Query(array('showposts' => $posts,'post_type' => 'post','cat' => $categories,));
		$counter = 1; 
		while($recent_posts->have_posts()): $recent_posts->the_post(); 
		
		?>
		<div class="block-small">
				<?php if(has_post_thumbnail()): ?>
				<div class="magz-image small">
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?></a>
				</div>
				<?php endif; ?>
				<div class="small-desc">
					<h4 class="desc-title"><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h4>
					<div><?php the_content(); ?></div>
				</div>
		</div>
		<a href="<?php echo $url; ?>" class="button more"></a>
		<?php $counter++; endwhile; ?>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['post_type'] = 'all';
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['url'] = $new_instance['url'];
		$instance['show_images'] = true;
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'post_type' => 'all', 'categories' => 'all', 'posts' => 5);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Filter by Category:</label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>">URL News:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" />
		</p>
		
	<?php 
	}
}
?>