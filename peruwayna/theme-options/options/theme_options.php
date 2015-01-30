<?php

// Pull all the pages into an array
$options_pages = array();  
$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
$options_pages[''] = 'Select a page:';
foreach ($options_pages_obj as $page) {
    $options_pages[$page->ID] = $page->post_title;
}

$options = array(    
    
    /*
     * 
     * General Settings Section
     * 
     */
	
    array(
        "type" => "section",
        "icon" => "reedwan-icon-home",
        "title" => "General Settings",
        "id" => "general",
        "expanded" => "true"
    ),
    
    array(
        "section" => "general",
        "type" => "heading",
        "title" => "General",
        "id" => "general-visual"
    ),
    
        array(
            "under_section" => "general-visual",
            "type" => "image",
            "placeholder" => "http://example.com/logo.png",
            "name" => "Logo",
            "id" => "reedwan_logo",
            "desc" => "Paste the URL to your logo, or upload it here.",
            "default" => ""),
        
        array(
            "under_section" => "general-visual",
            "type" => "image",
            "placeholder" => "http://example.com/favicon.png",
            "name" => "Favicon",
            "id" => "reedwan_favicon",
            "desc" => "Paste the URL to your favicon, or upload it here (resolution of 32x32 or 16x16)",
            "default" => ""),
    	
    	array(
            "under_section" => "general-visual",
        	"type" => "checkbox",
        	"name" => "<strong>Code integrations</strong>",
        	"id" => array( "reedwan_code_allow_google"),				
        	"options" => array("Google analytics"),
                "desc" => "Choose which code integrations (below) you want to use.",
        	"default" => array("checked")),
        
        array(
            "under_section" => "general-visual",
            "type" => "textarea",
            "name" => "Google analytics",
            "display_checkbox_id" => "reedwan_code_allow_google",
            "placeholder" => "<script>... </script>",
            "id" => "reedwan_analytics",
            "desc" => "Paste here your google analytics code.",),

        array(
            "title" => "Homepage Content",
            "type" => "small_heading",
            "under_section" => "general-visual",
        ),

            array(
                "under_section" => "general-visual",
                "type" => "text",
                "name" => "Page Home",
                "id" => "page_content_home",
                "desc" => "Page ID to show content in front page."),

    array(
        "section" => "general",
        "type" => "heading",
        "title" => "Social Media",
        "id" => "social-media"
    ),
	
        array(
            "under_section" => "social-media",
            "type" => "text",
            "name" => "Facebook",
            "id" => "social_fb_url",
            "placeholder" => "Facebook url",
            "desc" => "(eg.: https://www.facebook.com/honza)",),
         array(
            "under_section" => "social-media",
            "type" => "text",
            "name" => "Twitter",
            "id" => "social_twitter_url",
            "placeholder" => "Twitter url",
            "desc" => "(eg.: https://twitter.com/#!/simecekjann)",),
        array(
            "under_section" => "social-media",
            "type" => "text",
            "name" => "RSS",
            "id" => "social_rss_url",
            "placeholder" => "RSS url",),
        array(
            "under_section" => "social-media",
            "type" => "text",
            "name" => "Youtube",
            "id" => "social_youtube_url",
            "placeholder" => "Youtube url",
            "desc" => "(eg.: http://youtube.com/user/johndoe)",),

    array(
        "section" => "general",
        "type" => "heading",
        "title" => "Contacto",
        "id" => "contact-info"
    ),

        array(
            "under_section" => "contact-info",
            "type" => "textarea",
            "name" => "Contacto Mensaje",
            "id" => "contact_message",
        ),
        array(
            "under_section" => "contact-info",
            "type" => "text",
            "name" => "Dirección",
            "id" => "contact_address",
        ),
        array(
            "under_section" => "contact-info",
            "type" => "text",
            "name" => "Teléfonos",
            "id" => "contact_phone",
        ),
        array(
            "under_section" => "contact-info",
            "type" => "text",
            "name" => "Correo Eléctronico",
            "id" => "contact_mail",
        ),
        array(
            "under_section" => "contact-info",
            "type" => "text",
            "name" => "Facebook",
            "id" => "contact_fb",
        ),
        array(
            "under_section" => "contact-info",
            "type" => "text",
            "name" => "Twitter",
            "id" => "contact_tw",
        ),

    /*
     * 
     *  = General Settings Section
     * 
     */
     
    
    
    /*
     * 
     * Layout Settings Section
     * 
     */
	
    array(
        "type" => "section",
        "icon" => "reedwan-icon-window",
        "title" => "Layout Settings",
        "id" => "layout",
        "expanded" => "true"
    ),
	   
    array(
        "section" => "layout",
        "type" => "heading",
        "title" => "Slider",
        "id" => "homepage_slider"
    ),
 
        array(
            "title" => "Backstretch Slider",
            "type" => "small_heading",
            "under_section" => "homepage_slider",
        ),
    	
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #1",
                "id" => "backstretch_01",
                "default" => ""
            ),
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #2",
                "id" => "backstretch_02",
                "default" => ""
            ),
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #3",
                "id" => "backstretch_03",
                "default" => ""
            ),
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #4",
                "id" => "backstretch_04",
                "default" => ""
            ),
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #5",
                "id" => "backstretch_05",
                "default" => ""
            ),
            array(
                "under_section" => "homepage_slider",
                "type" => "image",
                "name" => "Imagen #6",
                "id" => "backstretch_06",
                "default" => ""
            ),
	
    array(
        "section" => "layout",
        "type" => "heading",
        "title" => "Homepage",
        "id" => "homepage-section",
    ),

        array(        
            "under_section" => "homepage-section",
            "type" => "select",
            "name" => "Tipo de Video",
            "id" => "homepage_video_type",
            "options" => array( "Youtube" ),                  
            "default" => "Youtube" ), 

        array(
            "under_section" => "homepage-section",
            "type" => "text",
            "name" => "Video ID",
            "id" => "homepage_video_id",
            "desc" => "Pega el código del video de Youtube. Ej: eoKNInYpwPI",
            "capability" => "editor",),

        array(
            "under_section" => "homepage-section",
            "type" => "text",
            "name" => "Ver mas videos - Botón",
            "id" => "homepage_morevideos",
            "capability" => "editor",),

        array(
            "title" => "Homepage - Multimedia",
            "type" => "small_heading",
            "under_section" => "homepage-section",
        ),

            array(
                "under_section" => "homepage-section",
                "type" => "image",
                "name" => "Galería Banner",
                "id" => "home_gallery_banner",
            ),

            array(
                "under_section" => "homepage-section",
                "type" => "text",
                "name" => "Galería URL",
                "id" => "home_gallery_url",
            ),

            array(
                "under_section" => "homepage-section",
                "type" => "image",
                "name" => "Blog Banner",
                "id" => "home_blog_banner",
            ),

            array(
                "under_section" => "homepage-section",
                "type" => "text",
                "name" => "Blog URL",
                "id" => "home_blog_url",
            ),


	array(
        "section" => "layout",
        "type" => "heading",
        "title" => "404 page",
        "id" => "layout-404"
    ),
    
        array(
            "under_section" => "layout-404",
            "type" => "image",
            "placeholder" => "http://example.com/404_error_image.png",
            "name" => "404 featured image",
            "id" => "reedwan_404_image",
            "desc" => "Paste the URL to your image, or upload it here.",
            "default" => ""),    
        
        
        array(
            "under_section" => "layout-404",
            "type" => "text",
            "default" => "404 PAGE",
            "name" => "404 page title",
            "id" => "reedwan_404_title",
            "desc" => "Enter 404 page title."),
        
        array(
            "under_section" => "layout-404",
            "type" => "textarea",
            "name" => "404 error message",
            "default" => "Oops... Something went wrong",
            "id" => "reedwan_404",
            "desc" => "Enter a message to display on your 404 (page not found) error pages.",),
    
    /*
     * 
     *  = Layout Settings Section
     * 
     */
    
    
);
?>
