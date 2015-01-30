<?php

/* Widget DATETIME */
add_action('widgets_init','vita_datetime_load_widgets');

function vita_datetime_load_widgets(){
	register_widget("Vita_Datetime_Widget");
}

class Vita_Datetime_Widget extends WP_widget{
	
	function Vita_Datetime_Widget(){
		$widget_ops = array('classname' => 'vita_datetime_widget', 'description' => 'Datetime Widget');

		$control_ops = array('id_base' => 'vita_datetime_widget');

		$this->WP_Widget('vita_datetime_widget', 'Datetime Widget', $widget_ops, $control_ops);
		
	}
	
	function widget($args,$instance){
		extract($args);
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];
		$id = $instance['id'];
		$url = $instance['url'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). 
		if ( $title )
			echo $before_title . $title . $after_title; */
		?>
		<script type="text/javascript">
		function showTime() {
			var today=new Date();
			var h=today.getHours();
			var m=today.getMinutes();
			var s=today.getSeconds();

			// add a zero in front of numbers<10
			h=checkTime(h);
			m=checkTime(m);
			s=checkTime(s);

			jq("#clock").text(h+":"+m);
			t=setTimeout('showTime()',1000);
		}
		function checkTime(i) {
			if (i<10) { i="0" + i; }
			return i;
		}
		function currentDate() {
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;

			jq("#date").text(today);
		}
		function currentDay() {
			var now = new Date();
			var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
			var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

			var day = days[ now.getDay() ];
			var month = months[ now.getMonth() ];

			jq("#day").text(day);
		}

		window.onload = function(){
			showTime();
			currentDate();
			currentDay()
		};
		</script>
		<div id="day"></div>
		<div id="date"></div>
		<div id="clock"></div>
		<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = $new_instance['type'];
		$instance['id'] = $new_instance['id'];
		$instance['url'] = $new_instance['url'];
		return $instance;
	}
	
	function form($instance){
		$defaults = array( 'title' => 'Video' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'theme') ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('type', 'theme') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option <?php if ( 'Youtube' == $instance['type'] ) echo 'selected="selected"'; ?>>Youtube</option>
				<option <?php if ( 'Vimeo' == $instance['type'] ) echo 'selected="selected"'; ?>>Vimeo</option>
				<option <?php if ( 'Dialymotion' == $instance['type'] ) echo 'selected="selected"'; ?>>Dialymotion</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e('Video ID:', 'theme') ?></label>
			<input id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo $instance['id']; ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('Livestream URL:', 'theme') ?></label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" class="widefat" />
		</p>
		<?php

	}
}