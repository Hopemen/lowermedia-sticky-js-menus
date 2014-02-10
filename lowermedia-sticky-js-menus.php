<?php
/*
Plugin Name: LowerMedia Sticky.js Menu's
Plugin URI: http://lowermedia.net
Description: WordPress plugin that integrates sticky.js and makes your primary navigation menu sticky (will 'stick' to top of screen when rolled over).  Activate and make your primary menu sticky!  Sticky means having your navigation always visible, the nav fixes itself to the top of the page.  This plugin uses the <a href='http://stickyjs.com'>Sticky.js</a> script, props and credit for creating that go to <a href="http://anthonygarand.com">Anthony Garand</a>, Thanks Anthony!   
Version: 2.0.1
Stable: 2.0.1
Author: Pete Lower
Author URI: http://petelower.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*############################################################################################
#	This plugin was designed to work out of the box with any theme by adding a class to 
#	the menu container and then manipulating the HTML tag w/ said class by way of JS
#	
#	Plugins tested to work with this theme work a tad bit differently.  Instead of 
#	adding a class it uses custom js files that have the main navigational selectors 
#	already defined.  JS manipulates the menus by using the already defined tags. 
#
#
#   This plugin has been tested on a growing number of themes including:
#   
#    twentytwelve, twentyeleven, responsive, wp-foundation, required-foundation, neuro, Swtor_NeozOne_Wp, 
#    lowermedia_one_page_theme, expound, customizr, sixteen, destro, swift basic
#
*/

/*############################################################################################
#
#   ADD STICKY JS FILES/LIBRARIES(STICKY.JS)
#   //This function adds sticky javascript libraries and files
#
*/

function lowermedia_add_sticky_js()  
{  
	//collect info about the theme to point to theme specific js files
	$theme_data = wp_get_theme();

	//Some themes have been defined specifically as to what the primary nav wrapper will be, 
	//for the themes still in flux we'll add a class to the nav, this class is used in run-sticky.js
	if ($theme_data['Template']!='twentytwelve' 
		&& $theme_data['Template']!='twentyeleven' 
		&& $theme_data['Template']!='twentyten' 
		&& $theme_data['Template']!='wp-foundation' 
		&& $theme_data['Template']!='required-foundation' 
		&& $theme_data['Template']!='responsive' 
		&& $theme_data['Template']!='neuro' 
		&& $theme_data['Template']!='Swtor_NeozOne_Wp' 
		&& $theme_data['Template']!='lowermedia_one_page_theme'
		&& $theme_data['Template']!='expound'
		&& $theme_data['Template']!='sixteen'
		&& $theme_data['Template']!='destro'
		&& $theme_data['Template']!='attitude'
		&& $theme_data['Template']!='spun'
		&& $theme_data['Template']!='bushwick')
	{
		function my_wp_nav_menu_args( $args = '' )
			{
				$args['container'] = 'nav';
				$args['container_class'] = 'lowermedia_add_sticky';
				return $args;
			}
			add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
	}

    // Register and enque sticky.js - Sticky JS http://www.labs.anthonygarand.com/sticky - Anthony Garand anthonygarand.com
	wp_register_script( 'sticky', plugins_url( '/js/jquery.sticky.js' , __FILE__ ) , array( 'jquery' ), '1.0.0', true);
	wp_register_script( 'run-sticky', plugins_url( '/js/run-sticky.js' , __FILE__ ), array( 'sticky' ), '1.0.0', true);
	wp_enqueue_script( 'run-sticky' );
	
	$params = array(
	  'themename' => $theme_data['Template']
	);
	
	wp_localize_script( 'sticky', 'LMScriptParams', $params );
	wp_localize_script( 'run-sticky', 'LMScriptParams', $params );
}  
add_action( 'wp_enqueue_scripts', 'lowermedia_add_sticky_js' ); 

/*############################################################################################
#
#   ADD SETTINGS LINK UNDER PLUGIN NAME ON PLUGIN PAGE
#   
*/

add_filter('plugin_action_links', 'lowermedia_plugin_action_links', 10, 2);

function lowermedia_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/nav-menus.php">Set Menu</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}
?>