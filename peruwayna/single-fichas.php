<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('estadio'); ?>

	<?php while ( have_posts() ) : the_post(); global $post; ?>

	<?php

	$name 			= get_post_meta($post->ID, 'name_value', true);
	$lastname 		= get_post_meta($post->ID, 'lastname_value', true);
	$team 			= get_post_meta($post->ID, 'team_value', true);
	$video_type 	= get_post_meta($post->ID, 'video_type_value', true);
	$video_id 		= get_post_meta($post->ID, 'video_id_value', true);
	$imageShare 	= get_post_meta($post->ID, 'video_image_value', true);
	$votes 			= get_post_meta($post->ID, 'votes_value', true);
	$dni 			= get_post_meta($post->ID, 'dni_value', true);

	$permalink 		= get_permalink($post->ID);

	if( isset($team) ) $background_image = 'background-image: url(http://maspormenos.com.pe/pichangatottus/wp-content/themes/tottus/images/forms/bg-'.$team.'.png)';

	switch ($team) {
	    case 'peru':
	        $teamName = 'Perú';
	        break;
	    case 'brasil':
	        $teamName = 'Perú';
	        break;
	    case 'spain':
	        $teamName = 'España';
	        break;
	    case 'colombia':
	        $teamName = 'Colombia';
	        break;
	    case 'holand':
	        $teamName = 'Holanda';
	        break;
	    case 'germany':
	        $teamName = 'Alemania';
	        break;
	    case 'italy':
	        $teamName = 'Italia';
	        break;
	    case 'argentina':
	        $teamName = 'Argentina';
	        break;
	}

	$replacement = "102.mp4";

	if( $video_type == "instagram" ) $instavid = substr($imageShare, 0, -5).$replacement;

	?>

	<div id="box" class="block-02 slide" data-section="2" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="title-ficha02"></div>
			<div id="fichaTecnica" style="<?php echo $background_image ?>">
				<div class="user-info">
					<div class="user-name"><?php echo $name; ?> <?php echo $lastname; ?></div>
					<div class="user-team"><?php echo $teamName; ?></div>
				</div>
				<div class="videoThumbPreview">
					<div class="share-video-overlay" id="share-video-overlay">
						<iframe src="<?php echo get_stylesheet_directory_uri(); ?>/fb_likebutton.php?postID=<?php echo $post->ID; ?>&url=<?php echo $permalink; ?>&num=<?php echo $dni; ?>" width="75" height="20" frameborder="0" scrolling="no" id="iframe"></iframe>
					</div>
					<?php if( $video_type == "youtube" ) : ?>
					<iframe width="387" height="202" src="//www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
				<?php elseif( $video_type == "vimeo" ) : ?>
					<iframe src="//player.vimeo.com/video/<?php echo $video_id; ?>" width="387" height="202" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				<?php else: ?>
					<video width="320" height="202" controls>
					  <source src="<?php echo $instavid; ?>" type="video/mp4">
					  <object data="<?php echo $instavid; ?>" width="320" height="202"></object> 
					</video>
				<?php endif; ?>
				</div>
				<div class="options">
					<a href="http://maspormenos.com.pe/pichangatottus/estadio/" class="goStadium"></a>

					<div class="shareOptions">
						<a href="#" data-url="<?php the_permalink() ?>" data-image="<?php echo $imageShare; ?>" data-title="Ver Ficha de <?php echo $name; ?> <?php echo $lastname; ?> | Pichanga Tottus" data-desc="Vota por <?php echo $name; ?> <?php echo $lastname; ?> en la Pichanga Tottus" class="btnShare shareFB">
						<a href="#" data-url="<?php the_permalink() ?>" data-title="¡Tú también participa en #LaPichangaDeTottus! Mira mi video en " class="btnShare shareTW"></a>
					</div>
				</div>
			</div>
		</div>
	</div><!-- #box -->

	<?php endwhile; ?>

<?php get_footer(); ?>