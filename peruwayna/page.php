<?php get_header(); ?>

<?php

$gallImages = get_post_meta($post->ID, 'galleryImg_value', true);	

?>

	<div id="primary" class="thirteen columns alpha omega top">
		<?php while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'nine columns alpha' ); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php cmsms_content_composer(get_the_ID()); ?>
			</div><!-- .entry-content -->
		</div><!-- #post -->

		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary -->

	<div id="welcome-box" class="thirteen columns alpha omega top">
		<div class="nine columns alpha">
			<div class="welcome">
				<h1>Bienvenidos a Molinos Avinka</h1>
				<p>Avinka Molinos nos especializamos en la elaboración de alimento balanceado para pollos. En nuestra web encontraras información sobre nuestro proceso productivo y servicios de maquila para clientes.</p>
			</div>
			<div class="others">
				<?php wp_nav_menu( array( 'theme_location' => 'left', 'menu_class' => 'left-menu' ) ); ?>
				<div class="youtube box">
					<iframe width="260" height="195" src="//www.youtube.com/embed/6AsmVWRdfBg" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="four columns omega">
			<img src="<?php echo get_template_directory_uri(); ?>/images/picture02.png">
		</div>
	</div><!-- #welcome-box -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>