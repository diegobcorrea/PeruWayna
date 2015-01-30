<?php
add_action('widgets_init', 'tweets_load_widgets');

function tweets_load_widgets()
{
	register_widget('Tweets_Widget');
}

class Tweets_Widget extends WP_Widget {
	
	function Tweets_Widget()
	{
		$widget_ops = array('classname' => 'tweets', 'description' => '');

		$control_ops = array('id_base' => 'tweets-widget');

		$this->WP_Widget('tweets-widget', 'Twitter', $widget_ops, $control_ops);
	}

	function ago($time){
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year");
	   $lengths = array("60","60","24","7","4.35","12","10");

	   $now = time();
	   $difference = $now - $time;
	   $tense = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		   $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference != 1) {
		   $periods[$j].= "s";
	   }

	   return "$difference $periods[$j] ago ";
	}

	/**
	 * Display out latest Tweets using the Twitter 1.1 API
	 */
	function display_latest_tweets($username,$no_tweets,$reply,$instance){

		$consumer_key = $instance['tweet_consumer_key'];
		$consumer_secret = $instance['tweet_consumer_secret'];
		$access_token = $instance['tweet_access_token'];
		$token_secret = $instance['tweet_token_secret'];

		$twitterConnection = new TwitterOAuth(
			$consumer_key,	// Consumer Key
			$consumer_secret, // Consumer secret
			$access_token,	// Access token
			$token_secret   // Access token secret
		);

		$twitterData = $twitterConnection->get(
			'statuses/user_timeline',
			array(
				'screen_name'     => $username, 	// Your Twitter Username
				'count'           => $no_tweets, 		// Number of Tweets to display
				'exclude_replies' => $reply
			)
		);	

		if($twitterData && is_array($twitterData)) {
		?>
            <ul class="tweets">
                <?php foreach($twitterData as $tweet): ?>
                <li>
                    <span>
                    <?php
                    $latestTweet = $tweet->text;
                    $latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $latestTweet);
					echo $latestTweet;
                    ?>
                    </span>
                    <?php
                    $twitterTime = strtotime($tweet->created_at);
                    $timeAgo = $this->ago($twitterTime);
                    ?>
                    <div class="meta"><a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>/statuses/<?php echo $tweet->id_str; ?>" class="jtwt_date"><?php echo $timeAgo; ?></a></div>
                </li>
                <?php endforeach; ?>
            </ul>
		<?php
		}
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$twitter_id = $instance['twitter_id'];
		$follow = $instance['follow'];
		$count = $instance['count'];

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($twitter_id) { ?>
		<div class="widget_twitter">
			<?php echo $this->display_latest_tweets($twitter_id,$count,true,$instance);?>
		</div>
		<?php }
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['count'] = $new_instance['count'];
		$instance['tweet_consumer_key'] = $new_instance['tweet_consumer_key'];
		$instance['tweet_consumer_secret'] = $new_instance['tweet_consumer_secret'];
		$instance['tweet_access_token'] = $new_instance['tweet_access_token'];
		$instance['tweet_token_secret'] = $new_instance['tweet_token_secret'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Tweets', 'twitter_id' => '', 'count' => 3);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" />
		</p>

			<label for="<?php echo $this->get_field_id('count'); ?>">Number of Tweets:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
		</p>
		</p>

			<label for="<?php echo $this->get_field_id('tweet_consumer_key'); ?>">Consumer Key:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tweet_consumer_key'); ?>" name="<?php echo $this->get_field_name('tweet_consumer_key'); ?>" value="<?php echo $instance['tweet_consumer_key']; ?>" />
		</p>
		</p>

			<label for="<?php echo $this->get_field_id('tweet_consumer_secret'); ?>">Consumer Secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tweet_consumer_secret'); ?>" name="<?php echo $this->get_field_name('tweet_consumer_secret'); ?>" value="<?php echo $instance['tweet_consumer_secret']; ?>" />
		</p>
		</p>

			<label for="<?php echo $this->get_field_id('tweet_access_token'); ?>">Access Token:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tweet_access_token'); ?>" name="<?php echo $this->get_field_name('tweet_access_token'); ?>" value="<?php echo $instance['tweet_access_token']; ?>" />
		</p>
		</p>

			<label for="<?php echo $this->get_field_id('tweet_token_secret'); ?>">Token Secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tweet_token_secret'); ?>" name="<?php echo $this->get_field_name('tweet_token_secret'); ?>" value="<?php echo $instance['tweet_token_secret']; ?>" />
		</p>

	<?php
	}
}
?>