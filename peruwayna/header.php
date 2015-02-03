<?php

session_start();
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<?php if (is_single()) : ?>
	<?php

	$name 			= get_post_meta($post->ID, 'name_value', true);
	$lastname 		= get_post_meta($post->ID, 'lastname_value', true);
	$team 			= get_post_meta($post->ID, 'team_value', true);
	$video_type 	= get_post_meta($post->ID, 'video_type_value', true);
	$video_id 		= get_post_meta($post->ID, 'video_id_value', true);
	$imageShare 	= get_post_meta($post->ID, 'video_image_value', true);
	$votes 			= get_post_meta($post->ID, 'votes_value', true);
	$dni 			= get_post_meta($post->ID, 'dni_value', true);

	?>
	<title>Ficha de <?php echo $name; ?> <?php echo $lastname; ?> | Pichanga Tottus</title>

	<meta property="og:site_name" content="Ficha de <?php echo $name; ?> <?php echo $lastname; ?> | Pichanga Tottus" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:url" content="<?php echo get_permalink( $post->ID ) ?>"/>
	<meta property="og:description" content="Vota por <?php echo $name; ?> <?php echo $lastname; ?> en la Pichanga Tottus" />
	<meta property="og:image" content="<?php echo $imageShare; ?>" />
	<link rel="image_src" href="<?php echo $imageShare; ?>" id="image_src" />
	<!-- if page is others -->
	<?php else : ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<meta property="og:image" content="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png">
	<link rel="image_src" href="http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/bg-widescreen.png" id="image_src" />
	<meta property="og:description" content="<?php echo $description; ?>">
	<meta property="og:site_name" content="Pichanga Tottus">
	<meta property="og:type" content="blog">
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
	<?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if(get_option('tottus_favicon')): ?>
		<link rel="shortcut icon" href="<?php echo get_option('tottus_favicon'); ?>" />
	<?php endif; ?>

	<script type="text/javascript">
		var return_home = "<?php echo get_site_url() ?>/sistema-de-reservas/";
		var close_session = "<?php echo get_site_url() ?>/sistema-de-reservas/cerrar-sesion";
		var url_rel = "<?php echo get_template_directory_uri(); ?>";
	</script>
	
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<?php
	if(get_option('tottus_analytics')) {
		echo stripslashes (get_option('tottus_analytics'));
	}
	?>
</head>

<body <?php body_class(); ?>> 
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '257796824412950',
	    channelUrl : '//maspormenos.com.pe/pichangatottus/channel.html',
	    status     : true,
	    cookie     : true,
	    xfbml      : true
	  });
	};

	(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if   (d.getElementById(id)) {return;}js = d.createElement('script'); js.id = id; js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
		function postToFeed(title, desc, url, image){
		var obj = {method: 'feed',link: url, picture: image, name: title, description: desc};
		function callback(response){}
		FB.ui(obj, callback);
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=257796824412950&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<div class="temp-header" style="text-align: center; width: 100%;">
	<img src="<?php echo get_template_directory_uri(); ?>/images/temp/header.jpg">
</div>
