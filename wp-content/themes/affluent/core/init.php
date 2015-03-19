<?php
//Theme options setup
if(!function_exists('cpotheme_setup')){
	add_action('after_setup_theme', 'cpotheme_setup');
	function cpotheme_setup(){
		//Set core variables
		cpotheme_update_option('cpo_core_version', '1.9.0');
		
		//Initialize supported theme features
		add_editor_style();
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('woocommerce');
		add_post_type_support('page', 'excerpt');
		
		//Remove WordPress version number for security purposes
		remove_action('wp_head', 'wp_generator');
		
		//Load translation text domain and make translation available
		$languages_path = get_template_directory().'/core/languages';
		if(defined('CPO_CORE')) $languages_path = CPO_CORE.'/languages';
		load_theme_textdomain('cpocore', $languages_path);
		load_theme_textdomain('cpotheme', get_template_directory().'/languages');
		$locale = get_locale();
		$locale_file = get_template_directory()."/languages/$locale.php";
		if(is_readable($locale_file)) require_once($locale_file);
	}
}

//Add Public scripts
if(!function_exists('cpotheme_scripts_front')){
	add_action('wp_enqueue_scripts', 'cpotheme_scripts_front');
	function cpotheme_scripts_front( ){
		$scripts_theme_path = get_template_directory_uri().'/scripts/';
		$scripts_path = get_template_directory_uri().'/core/scripts/';
		if(defined('CPO_CORE_URL')) $scripts_path = CPO_CORE_URL.'/scripts/';

		//Enqueue necessary scripts already in the WordPress core
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-effects-fade');
		wp_enqueue_script('thickbox');
		if(is_singular() && get_option('thread_comments')) 
			wp_enqueue_script('comment-reply');
		
		wp_enqueue_script('cpotheme_html5', $scripts_path.'html5.js');
		//Register custom scripts for later enqueuing
		wp_register_script('cpotheme_stellar', $scripts_path.'jquery-stellar.js', array(), false, true);
		wp_register_script('cpotheme_waypoints', $scripts_path.'jquery-waypoints.js', array(), false, true);
		wp_register_script('cpotheme_waypoints_sticky', $scripts_path.'jquery-waypoints-sticky.js', array('cpotheme_waypoints'), false, true);
		wp_enqueue_script('cpotheme_jquery_cycle', $scripts_path.'jquery-cycle.js', array(), false, true);
		wp_enqueue_script('cpotheme_jquery_prettyphoto', $scripts_path.'jquery-prettyphoto.js', array(), false, true);
		//Add custom scripts
		wp_enqueue_script('cpotheme_core', $scripts_path.'core.js', array(), false, true);
		wp_enqueue_script('cpotheme_general', $scripts_theme_path.'general.js', array(), false, true);
	}
}
	
//Add Admin scripts
if(!function_exists('cpotheme_scripts_back')){
	add_action('admin_enqueue_scripts', 'cpotheme_scripts_back');
	function cpotheme_scripts_back( ){
		$scripts_theme_path = get_template_directory_uri().'/scripts/';
		$scripts_path = get_template_directory_uri().'/core/scripts/';
		if(defined('CPO_CORE_URL')) $scripts_path = CPO_CORE_URL.'/scripts/';

		//Common scripts
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-effects-fade');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');        
		wp_enqueue_script('script_general_admin', $scripts_path.'admin.js');
		wp_enqueue_script('wp-color-picker');	
	}
}

//Add public stylesheets
if(!function_exists('cpotheme_add_styles')){
	add_action('wp_enqueue_scripts', 'cpotheme_add_styles');
	function cpotheme_add_styles(){
		$stylesheets_path = get_template_directory_uri().'/core/css/';
		if(defined('CPO_CORE_URL')) $stylesheets_path = CPO_CORE_URL.'/css/';
		
		//Common styles
		wp_enqueue_style('thickbox');     
		wp_enqueue_style('cpotheme-base', $stylesheets_path.'base.css');
		wp_enqueue_style('cpotheme-prettyphoto', $stylesheets_path.'prettyphoto.css');
		wp_enqueue_style('cpotheme-fontawesome', $stylesheets_path.'fontawesome.css');
		wp_enqueue_style('cpotheme-main', get_bloginfo('stylesheet_url'));
		//Responsive Stylesheet (if it exists)
		$responsive_styles = get_template_directory_uri().'/style-responsive.css';
		if(cpotheme_get_option('layout_responsive') != 0){
			wp_enqueue_style('cpotheme-base-responsive', $stylesheets_path.'base-responsive.css');
			wp_enqueue_style('cpotheme-responsive', $responsive_styles);
		}
	}
}

//Add admin stylesheets
if(!function_exists('cpotheme_add_admin_styles')){
	add_action('admin_print_styles', 'cpotheme_add_admin_styles');
	function cpotheme_add_admin_styles(){
		$stylesheets_path = get_template_directory_uri().'/core/css/';
		if(defined('CPO_CORE_URL')) $stylesheets_path = CPO_CORE_URL.'/css/';
		
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('style_admin', $stylesheets_path.'admin.css');
		wp_enqueue_style('style_fontawesome', $stylesheets_path.'fontawesome.css');
		wp_enqueue_style('thickbox');    
	}
}


//Add all Core components
$core_path = get_template_directory().'/core/';
if(defined('CPO_CORE')) $core_path = CPO_CORE;
	
//Classes
require_once($core_path.'classes/class_menu.php');
require_once($core_path.'classes/class_tgm.php');
//Main Components
require_once($core_path.'general.php');
require_once($core_path.'filters.php');
require_once($core_path.'meta.php');
require_once($core_path.'metaboxes.php');
require_once($core_path.'custom.php');
require_once($core_path.'forms.php');
require_once($core_path.'settings.php');
require_once($core_path.'branding.php');
require_once($core_path.'taxonomy.php');
require_once($core_path.'layout.php');
require_once($core_path.'plugins.php');
require_once($core_path.'woocommerce.php');
//Metadata
require_once($core_path.'metadata/data_general.php');
require_once($core_path.'metadata/data_settings.php');
require_once($core_path.'metadata/data_metaboxes.php');