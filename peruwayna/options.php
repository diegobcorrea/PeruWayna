	<!--CSS Options-->
	<style type="text/css" media="screen">
		 a:hover,.sf-menu li.current-menu-item a, .sf-menu li a:hover,
		.widget_calendar table#wp-calendar>tbody>tr>td>a,
		.widget_calendar tfoot>tr>td#prev a,.widget_calendar tfoot>tr>td#next a,
		.comment-post-title, .footer-widget a:hover, .credits a:hover ,
		.footer-widget.widget_calendar tfoot>tr>td#prev a,.widget_calendar tfoot>tr>td#next a,
		.half-meta .half-meta-time .day,.half-meta .half-meta-time .year,.half-meta .half-meta-time .month, .caption-time .day, .flex-caption h3 a:hover, form.nd_form p a:hover.forgotten, span.reedwan-following-info:hover, .newsticker_title, .newsticker a:hover
		{
			color:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;
		}
		
		.sf-menu li a:hover, .sf-menu li.current-menu-item a{
			border-bottom-color:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;
		}
		::-moz-selection {background:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;}
		::selection {background:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;}
		
		.sf-menu .sub-menu, .widget_calendar thead>tr>th, .tagcloud ul li a:hover, .big-title h3,
		.readmore, .block-small .small-desc .desc-title a:hover,.reply a,.topNav li > ul,
		.block-small-noimage .desc-title a:hover, .list_carousel .big-title h3 a,
		.pager a.selected, .single-tags a:hover, .related-post-title a:hover, 
		.description-author span a:hover, .author-social, .single-nav a, #comments .navigation a:hover,
		p.form-submit input#submit, .pagination span, .pagination a:hover,
		.single-content ul.tabs li:hover, .single-content ul.tabs li.active,h5.toggle,
		.footer-widget .tagcloud a:hover, a.reedwan-social-media-icon span.reedwan-Feedburner,
		a.reedwan-social-media-icon span.reedwan-Facebook,
		a.reedwan-social-media-icon span.reedwan-Twitter,
		a.reedwan-social-media-icon span.reedwan-Dribbble,
		a.reedwan-social-media-icon span.reedwan-Forrst,
		a.reedwan-social-media-icon span.reedwan-Vimeo ,
		a.reedwan-social-media-icon span.reedwan-YouTube,
		a.reedwan-social-media-icon span.reedwan-Digg, .rsDefault .rsThumb.rsNavSelected,
		.flex-direction-nav li .flex-prev:hover,
		.flex-direction-nav li .flex-next:hover,.flex-control-nav li a.flex-active ,.half-meta .half-meta-author, .half-meta .half-meta-comment, .half-meta .half-meta-review, ul.nd_tabs li.active, .nd_logged_in ul.links li a, form.nd_form input.button, span.criteria-top, .single-title h1, .blog-title h1,.footer-nav,.footer-nav-wrap, .content-score, #searchbutton, #contactf button[type="submit"]
		
		{
			background-color:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;
		}
		.top-wrap, .ticker, .top,.ticker-content,.ticker-swipe,.ticker-swipe span{}
		
		.single-content blockquote, li.comment > div {
			border-left-color:<?php echo '#'.get_option('reedwan_generalcolor'); ?>;
		}
		
		.header-logo{padding-top:<?php echo get_option('reedwan_logo_pading_top').'px'; ?>;}
		.header-adds{padding-top:<?php echo get_option('reedwan_banner_pading_top').'px'; ?>;}
		.header-logo{padding-bottom:<?php echo get_option('reedwan_logo_pading_bottom').'px'; ?>;}
		.header-adds{padding-bottom:<?php echo get_option('reedwan_banner_pading_bottom').'px'; ?>;}
		
		.newsticker_wrapper, .newsticker_title, .newsticker a, .topNav a{
			font-family:<?php
			if(get_option('reedwan_topnav_font_custom_enable')=='true' && 
			get_option('reedwan_topnav_font_custom_link') &&
			get_option('reedwan_topnav_font_custom_css')):
				echo stripslashes(get_option('reedwan_topnav_font_custom_css'));
			else:
				echo get_option('reedwan_content_font');
			endif;
		?>;
		}
		
		body,.block-small .small-desc .desc-title,.block-small-noimage .desc-title ,
		.related-post-title,#respond textarea{
		font-family:<?php
			if(get_option('reedwan_content_font_custom_enable')=='true' && 
			get_option('reedwan_content_font_custom_link') &&
			get_option('reedwan_content_font_custom_css')):
				echo stripslashes(get_option('reedwan_content_font_custom_css'));
			else:
				echo get_option('reedwan_content_font');
			endif;
		?>;
		}
		
		 h1, h2, h3, h4, h5, h6,
		.widget_calendar table#wp-calendar caption, span.reedwan-following-info .number,
		p.form-submit input#submit,#contactf button[type="submit"],
		.single-content ul.tabs li a { 
		font-family:<?php
			if(get_option('reedwan_heading_font_custom_enable')=='true' && 
			get_option('reedwan_heading_font_custom_link') &&
			get_option('reedwan_heading_font_custom_css')):
				echo stripslashes(get_option('reedwan_heading_font_custom_css'));
			elseif(get_option('reedwan_heading_font')!='Oswald'):
				echo get_option('reedwan_heading_font');
			else:
				echo 'OswaldBook';
			endif;
			
		?>;
		}
		.sf-menu li a { 
		font-family:<?php
			if(get_option('reedwan_mainnav_font_custom_enable')=='true' && 
			get_option('reedwan_mainnav_font_custom_link') &&
			get_option('reedwan_mainnav_font_custom_css')):
				echo stripslashes(get_option('reedwan_mainnav_font_custom_css'));
			elseif(get_option('reedwan_mainnav_font')!='Oswald'):
				echo get_option('reedwan_mainnav_font');
			else:
				echo 'OswaldBook';
			endif;
			
		?>;
		}
		.bottomNav a { 
		font-family:<?php
			if(get_option('reedwan_bottomnav_font_custom_enable')=='true' && 
			get_option('reedwan_bottomnav_font_custom_link') &&
			get_option('reedwan_bottomnav_font_custom_css')):
				echo stripslashes(get_option('reedwan_bottomnav_font_custom_css'));
			elseif(get_option('reedwan_bottomnav_font')!='Oswald'):
				echo get_option('reedwan_bottomnav_font');
			else:
				echo 'OswaldBook';
			endif;
			
		?>;
		}
		<?php if (get_option('reedwan_pattern_bg','true')!='' && get_option('reedwan_pattern_bg_enable','true')=='true'):?>
			body{ background:url(<?php echo get_option('reedwan_pattern_bg','true'); ?>) repeat; }
		<?php endif; ?>
		
		<?php if (get_option('reedwan_themelayout','true')=="full"):?>
			.arrow-wrap{ display:none; }
			.navigation-wrap { background:#fff; }
			.navigation { background:#fff; }
			.main-nav-wrapper { background:#333; }
			.sf-menu li a { margin:0 25px; }
			.arrow-top {display:block;}
			.arrow-top { background:#ffffff; overflow:hidden; }
			.arrow-down.black{
				border-top: 10px solid #333;
				margin-bottom:0;
			}
			@media only screen and (min-width: 768px) and (max-width: 959px) {
				.sf-menu li a {
					font-size:14px;
					margin: 0 15px;
				}
				.sub-menu li a {
					margin-right:0;
				}
			}
		<?php endif; ?>
		<?php if(get_option('reedwan_code_allow_css') == 'true')
			{
				echo stripslashes (get_option('reedwan_customcss'));
			}
		?>
		
	</style>
	<!--Jquery Options-->
	<script type="text/javascript">
	jQuery(window).load(function() {
	// Background
	<?php if(is_single()): ?>
		<?php
			$bg_single = get_post_meta(get_the_ID(), 'reedwan_background_page', true); 
			$category = get_the_category(); 
			$category_ID =  $category[0]->cat_ID;
			$category_image_bg= get_tax_meta($category_ID,'reedwan_cat_image_bg');
			if (isset($category_image_bg) && $category_image_bg !== '') { $category_image_bg_src = $category_image_bg['src']; }
		?>
		<?php if($bg_single!==''): ?>
			jQuery.backstretch(["<?php echo $bg_single; ?>"]);
		<?php elseif(isset($category_image_bg) && $category_image_bg!=='' ): ?>
			jQuery.backstretch(["<?php echo $category_image_bg_src; ?>"]);
		<?php else: ?>
			<?php if(get_option('reedwan_image_bg','true')!=''): ?>
				<?php if(get_option('reedwan_pattern_bg','true')=='' || get_option('reedwan_pattern_bg_enable','true')!='true'): ?>
					jQuery.backstretch(["<?php echo get_option('reedwan_image_bg','true'); ?>"]);
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php elseif(is_page()): ?>
		<?php
		$bg_page = get_post_meta(get_the_ID(), 'reedwan_background_page', true);  
		?>
		<?php if($bg_page!==''): ?>
			jQuery.backstretch(["<?php echo $bg_page; ?>"]);
		<?php else: ?>
			<?php if(get_option('reedwan_image_bg','true')!=''): ?>
				<?php if(get_option('reedwan_pattern_bg','true')=='' || get_option('reedwan_pattern_bg_enable','true')!='true'): ?>
					jQuery.backstretch(["<?php echo get_option('reedwan_image_bg','true'); ?>"]);
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php elseif(is_category()): ?>
		<?php 
			$category_ID = get_query_var('cat'); 
			$category_image_bg= get_tax_meta($category_ID,'reedwan_cat_image_bg');
			if (isset($category_image_bg) && $category_image_bg !== '') { $category_image_bg_src = $category_image_bg['src']; }
		?>
		<?php if(isset($category_image_bg) && $category_image_bg!==''): ?>
			jQuery.backstretch(["<?php echo $category_image_bg_src; ?>"]);
		<?php else: ?>
			<?php if(get_option('reedwan_image_bg','true')!=''): ?>
				<?php if(get_option('reedwan_pattern_bg','true')=='' || get_option('reedwan_pattern_bg_enable','true')!='true'): ?>
					jQuery.backstretch(["<?php echo get_option('reedwan_image_bg','true'); ?>"]);
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php else: ?>
		<?php if(get_option('reedwan_image_bg','true')!=''): ?>
			<?php if(get_option('reedwan_pattern_bg','true')=='' || get_option('reedwan_pattern_bg_enable','true')!='true'): ?>
				jQuery.backstretch(["<?php echo get_option('reedwan_image_bg','true'); ?>"]);
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	// News Ticker
	jQuery('#newsticker1').newsticker({
		'style' : 'fade',
		'showControls' : false,
		'tickerTitle' : '<?php echo get_option('reedwan_ticker_title'); ?>', 
		'autoStart' : true, 
		'fadeOutSpeed' : 'slow',
		'fadeInSpeed' : 'slow', 
		'transitionSpeed' : '<?php echo get_option('reedwan_ticker_speed'); ?>', 
		'pauseOnHover' : true 
	});
	
	// Flex Slider
	jQuery('.flexslider').flexslider({
				animation: '<?php echo get_option('reedwan_slider_animation'); ?>', 
				slideDirection: '<?php echo get_option('reedwan_slider_direction'); ?>',
				slideshow: <?php echo get_option('reedwan_show_slideshow'); ?>,
				slideshowSpeed: <?php echo get_option('reedwan_slideshow_speed'); ?>,  
				animationDuration: <?php echo get_option('reedwan_animation_duration'); ?>,   
				directionNav: <?php echo get_option('reedwan_show_direction'); ?>,             
				controlNav: <?php echo get_option('reedwan_show_control'); ?>              
			  });
		
	
	});
	
	<?php if(get_option('reedwan_code_allow_jquery') == 'true')
		{
				echo stripslashes (get_option('reedwan_customjquery'));
		}
	?>
	</script>