<?php

if (!function_exists('write_log')) {
	  function write_log ( $log )  {
	        if ( true === WP_DEBUG ) {
	            if ( is_array( $log ) || is_object( $log ) ) {
	                error_log( print_r( $log, true ) );
	            } else {
	                error_log( $log );
	            }
	        }
	    }
	}

/*
* ADMIN FUNCTIONS
* additional functionality to admin and wordpress
*/

	/* SETUP HEAD */
	
    // Translations can be filed in the /languages/ directory
    load_theme_textdomain( 'sceleton', TEMPLATEPATH . '/languages' );
	
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
		wp_enqueue_script('equalheights', get_bloginfo('template_directory').'/includes/js/jquery.matchHeight-min.js', '', '', true);
		wp_register_script( 'scripts', get_bloginfo('template_directory').'/includes/js/script.js', array('jquery'), '', true);
		wp_localize_script( 'scripts', 'hq_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
		wp_enqueue_script('scripts', get_bloginfo('template_directory').'/includes/js/script.js', array('jquery'), '', true);
	}
    
	/* ADD STUFF TO ADMIN */
	
    //Add menu positions
    register_nav_menus(array(
		'primary' => 'Huvudmeny',
	));
    
    //remove admin css in frontend form
    add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
	function my_deregister_styles() {
		wp_deregister_style( 'wp-admin' );
	}
	
	//Make sure visitor is logged in first!
	function hq_redirect(){
		if(!is_user_logged_in()){
			wp_redirect(wp_login_url(home_url()));
		}	
	}
	add_action('get_header', 'hq_redirect');
	
	
	/**
	 * Redirect user after successful login.
	 *
	 * @param string $redirect_to URL to redirect to.
	 * @param string $request URL the user is coming from.
	 * @param object $user Logged user's data.
	 * @return string
	 */
	function my_login_redirect( $redirect_to, $request, $user ) {
		//is there a user to check?
		return home_url();
	}
	
	add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
	
	/* CLEAN UP ADMIN */
	//Remove bio stuff from profile
	add_filter( 'user_contactmethods', 'update_contact_methods',10,1);
	function update_contact_methods( $contactmethods ) {
		unset($contactmethods['aim']);  
		unset($contactmethods['jabber']);  
		unset($contactmethods['yim']); 
		unset($contactmethods['googleplus']);  
		unset($contactmethods['twitter']); 
		unset($contactmethods['facebook']); 
		 
		return $contactmethods;
	}
	
	function wps_admin_bar() {
		if(!current_user_can('update_core')){
			global $wp_admin_bar;
		    $wp_admin_bar->remove_menu('wp-logo');
		    $wp_admin_bar->remove_menu('about');
		    $wp_admin_bar->remove_menu('wporg');
		    $wp_admin_bar->remove_menu('documentation');
		    $wp_admin_bar->remove_menu('support-forums');
		    $wp_admin_bar->remove_menu('feedback');
		    $wp_admin_bar->remove_menu('comments');
		    $wp_admin_bar->remove_menu('new-content');
		}
	}
	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );
	
	//remove menu items
	add_action( 'admin_menu', 'remove_links_menu', 99);
	function remove_links_menu() {
		if(!current_user_can('update_core')){ //non admin
			remove_menu_page('tags'); // Dashboard
			remove_menu_page('edit.php?post_type=acf'); // acf
			remove_menu_page('edit.php');
			remove_menu_page('edit.php?post_type=page');
			remove_menu_page('edit-comments.php');
			remove_menu_page('tools.php');
			remove_submenu_page('themes.php','theme-editor.php'); // Remove the Theme Editor submenu 
		}
	}

	//Hide stuff from dashboard
	function remove_dashboard_widgets() {
		if(!current_user_can('edit_tribe_events')){
			global $wp_meta_boxes;
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
			unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
			unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
			
		}
	}
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
	
	
	function hq_disable_admin_bar() {
	   if (!current_user_can('update_core')){
	      add_filter( 'show_admin_bar', '__return_false' );
	      add_action( 'admin_print_scripts-profile.php', 'yoast_hide_admin_bar_settings' );
	   }
	}
	add_action( 'init', 'hq_disable_admin_bar' , 9 );
    
/*
* THEME FUNCTIONS
* functions for use in templates to display frontend content
*/

	//Delete array value, first parameter is array, second is string
	function array_delete($array, $element) {
	    $indexPos = array_search($element, $array);
	    unset($array[$indexPos]);
		return $array;
	}

	//Adds or removes cards been used by current user. 
	add_action("wp_ajax_ajax_set_cards", "ajax_set_cards");
	function ajax_set_cards() {
	
		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'hq_ajax_nonce')) {
		  exit('No naughty business please');
		}  
		$post_id = $_REQUEST['post_id'];
		$action = $_REQUEST['todo'];
		$current_user = wp_get_current_user();
		$used_cards = get_user_meta($current_user->ID, 'used_cards', true);
		if($used_cards != ''){
			if($action == 'add'){
				$used_cards[] = $post_id;
			}else if($action == 'remove'){
				$used_cards = array_delete($used_cards, $post_id);
			}
			$status = update_user_meta($current_user->ID, 'used_cards', $used_cards);
		}else{
			$used_cards = array($post_id);
			$status = update_user_meta($current_user->ID, 'used_cards', $used_cards);
		}
	   
		if($status === false) {
		  $result['type'] = 'error';
		}
		else {
		  $result['type'] = 'success';
		  $result['used_cards'] = $used_cards;
		}
				
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		  $result = json_encode($result);
		  echo $result;
		}
		else {
		  header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
		
		die();
	}
	
	//Removes all used cards from current user. A blank slate!
	add_action("wp_ajax_ajax_reset_cards", "ajax_reset_cards");
	function ajax_reset_cards() {
	
		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'hq_ajax_nonce')) {
		  exit('No naughty business please');
		}  
		$current_user = wp_get_current_user();
		$status = delete_user_meta($current_user->ID, 'used_cards');
		
		if($status === false) {
		  $result['type'] = 'error';
		}
		else {
		  $result['type'] = 'success';
		}
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		  $result = json_encode($result);
		  echo $result;
		}
		else {
		  header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
		die();
	}


?>