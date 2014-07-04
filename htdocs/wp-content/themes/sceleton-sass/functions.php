<?php

/*
* ADMIN FUNCTIONS
* additional functionality to admin and wordpress
*/

	/* SETUP HEAD */
	
    // Translations can be filed in the /languages/ directory
    load_theme_textdomain( 'sceleton', TEMPLATEPATH . '/languages' );
	
	// Add RSS links to <head> section
	add_theme_support( 'automatic-feed-links' );
	
	// Clean up head from automatic links. Remove the ones you need!
	function removeHeadLinks() {
    	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
		remove_action('wp_head', 'wp_generator');
    }
    add_action('init', 'removeHeadLinks');
	
	//Prevent pingbacks with XMLRPC! Remove if this need to be used. Prevented to avoid DDOS attacks. 
	add_filter('xmlrpc_methods', 'disable_pingbacks', 1, 10);
	function disable_pingbacks( $methods ){
		unset($methods['pingback.ping']);
		return $methods;
	}
	
	//Add featured image to posts
    add_theme_support( 'post-thumbnails' );
    
    //Allow shortcodes in regular textwidget
    add_filter( 'widget_text', 'do_shortcode' );
    
	//Replace and/or remove accents and other special characters in filenames on upload, prevents issues with FTP transfers for example
	add_filter( 'sanitize_file_name', 'extended_sanitize_file_name', 10, 2 );
	function extended_sanitize_file_name( $filename ) {
		$sanitized_filename = remove_accents( $filename );
		return $sanitized_filename;
	}
    
    //Javascript the right way!
	if (!is_admin()) add_action("wp_enqueue_scripts", "sceleton_javascript_enqueue", 11);
	function sceleton_javascript_enqueue() {
	   wp_enqueue_script('jquery');
	   wp_enqueue_script('modernizr', get_bloginfo('template_directory').'/includes/js/modernizr.js', '', '', true);
	   wp_enqueue_script('scripts', get_bloginfo('template_directory').'/includes/js/script.js', array('jquery'), '', true);
	}
    
	/* ADD STUFF TO ADMIN */
	
    //Add menu positions
    register_nav_menus(array(
		'primary' => 'Huvudmeny',
	));
	
	//Register sidebars
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => __('Sidebar Widgets','sceleton' ),
    		'id'   => 'sidebar-widgets',
    		'description'   => __( 'These are widgets for the sidebar.','sceleton' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h3>',
    		'after_title'   => '</h3>'
    	));
    }
    
/*
* THEME FUNCTIONS
* functions for use in templates to display frontend content
*/


/*
* SHORTCODE FUNCTIONS
* functions for creating custom shortcodes
*/


?>