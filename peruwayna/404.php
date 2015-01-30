<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div class="sixteen columns row top">
		<img src="<?php bloginfo('template_url'); ?>/images/page-banner.jpg" width="940" height="250" />
	</div>

	<div id="primary" class="eleven columns top">
		<div id="content" role="main">

			<h1 class="error404_title"><?php echo get_option('reedwan_404_title');?></h1>
			<div class="clear"></div>
			<h6 class="error404_text"><?php echo get_option('reedwan_404');?></h6>
			<div class="clear"></div>
			<div class="error404_image" >
			<?php if(get_option('reedwan_404_image'))
			{ ?>
				<img src="<?php echo get_option('reedwan_404_image');?>" alt="<?php echo get_option('reedwan_404_title');?>" />
				<?php } 
			?>
			</div>		

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>