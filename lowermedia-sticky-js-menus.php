<?php
/*
Plugin Name: LowerMedia Sticky.js Menu's
Plugin URI: http://lowermedia.net
Description: WordPress plugin that integrates sticky.js and makes your primary navigation menu sticky (will 'stick' to top of screen when rolled over).  Activate and make your primary menu sticky!  Sticky means having your navigation always visible, the nav fixes itself to the top of the page.  This plugin uses the <a href='http://stickyjs.com'>Sticky.js</a> script, props and credit for creating that go to <a href="http://anthonygarand.com">Anthony Garand</a>, Thanks Anthony!   
Version: 3.0.0
Stable: 3.0.0
Author: Pete Lower
Author URI: http://petelower.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*############################################################################################
#	This plugin is designed to work out of the box with any theme by adding a class to 
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
#   SECURITY: BLOCK DIRECT ACCESS TO FILE
#
*/

defined('ABSPATH') or die("Cannot access pages directly.");


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

		//collect option info from wp-admin/options.php
		$lmstickyjs_options = get_option( 'lmstickyjs_option_name' );

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
			&& $theme_data['Template']!='Isabelle'
			&& $theme_data['Template']!='spacious'
			&& $theme_data['Template']!='bushwick'
			&& $theme_data['Template']!='one-page')
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
		  'themename' => $theme_data['Template'],
		  'stickytarget' => $lmstickyjs_options['lmstickyjs_class_selector'],
		  'stickytargettwo' => $lmstickyjs_options['lmstickyjs_class_selector-two'],
		  'disableatwidth' => $lmstickyjs_options['myfixed_disable_small_screen']
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
	        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=lm-stickyjs-settings">Settings</a>';
	        array_unshift($links, $settings_link);
	    }

	    return $links;
	}

/*############################################################################################
#
#   Remove More Jump Link
#   
*/

	function lmstickyjs_remove_more_jump_link($link) 
	{ 
	
		$offset = strpos($link, '#more-');
	
		if ($offset) {
			$end = strpos($link, '"',$offset);
		}
	
		if ($end) {
			$link = substr_replace($link, '', $offset, $end-$offset);
		}
	
		return $link;
	}
	
	add_filter('the_content_more_link', 'lmstickyjs_remove_more_jump_link');

/*############################################################################################
#
#   ADD ADMIN PAGE UNDER SETTINGS
#   
*/

	class LowerMediaStickyAdminPage
	{
	    //field callback values
	    private $options;

	    public function __construct()
	    {
	        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	        add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'admin_init', array( $this, 'lmstickyjs_default_options' ) );
	    }

	    //create options page
	    public function add_plugin_page()
	    {
	        // This page will be under "Settings"
	        add_options_page(
	            'Settings Admin', 
	            'Sticky.js Menus', 
	            'manage_options', 
	            'lm-stickyjs-settings', 
	            array( $this, 'create_admin_page' )
	        );
	    }

	    //options page callback
	    public function create_admin_page()
	    {
	        // Set class property
	        $this->options = get_option( 'lmstickyjs_option_name');
	        ?>
	        <div class="wrap">
	            <?php screen_icon(); ?>
	            <h2><a href='http://lowermedia.net'>LowerMedia</a> <a href='http://stickyjs.com'>Sticky.js</a> Settings</h2>           
	            <form method="post" action="options.php">
	            <?php
	                // This prints out all hidden setting fields
	                settings_fields( 'lmstickyjs_option_group' );   
	                do_settings_sections( 'lm-stickyjs-settings' );
	                submit_button(); 
	            ?>
	            <br/><br/>
			        <center>
			        I created this to save you time, for free :D It took some time, feel free to donate:<br/>
			        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="3S66QV3H7L49Y">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					</center>
	            </form>
	        </div>
	        <?php
	    }
		
	    //register and add settings
	    public function page_init()
	    {   
			global $id, $title, $callback, $page;     
	        register_setting(
	            'lmstickyjs_option_group', // Option group
	            'lmstickyjs_option_name', // Option name
	            array( $this, 'sanitize' ) // Sanitize
	        );
			
			add_settings_field( $id, $title, $callback, $page, $section = 'default', $args = array() );

	        add_settings_section(
	            'setting_section_id', // ID
	            'Menu Options', // Title
	            array( $this, 'print_section_info' ), // Callback
	            'lm-stickyjs-settings' // Page
	        );

	        add_settings_field(
	            'lmstickyjs_class_selector', // ID
	            'Sticky Object', // Title 
	            array( $this, 'lmstickyjs_class_selector_callback' ), // Callback
	            'lm-stickyjs-settings', // Page
	            'setting_section_id' // Section         
	        );

	        add_settings_field(
	            'lmstickyjs_class_selector-two', // ID
	            'Additional Sticky Object', // Title 
	            array( $this, 'lmstickyjs_class_selector_two_callback' ), // Callback
	            'lm-stickyjs-settings', // Page
	            'setting_section_id' // Section         
	        );
	        
			add_settings_field(
	            'myfixed_disable_small_screen', 
	            'Disable on Screen Width of', 
	            array( $this, 'myfixed_disable_small_screen_callback' ), 
	            'lm-stickyjs-settings', 
	            'setting_section_id'
	        );
	    }
		
	    /**
	     * Sanitize each setting field as needed
	     *
	     * @param array $input Contains all settings fields as array keys
	     */
	    public function sanitize( $input )
	    {
	        $new_input = array();
	        if( isset( $input['lmstickyjs_class_selector'] ) )
	            $new_input['lmstickyjs_class_selector'] = sanitize_text_field( $input['lmstickyjs_class_selector'] );

	        if( isset( $input['lmstickyjs_class_selector-two'] ) )
	            $new_input['lmstickyjs_class_selector-two'] = sanitize_text_field( $input['lmstickyjs_class_selector-two'] );


	        if( isset( $input['myfixed_disable_small_screen'] ) )
	            $new_input['myfixed_disable_small_screen'] = absint( $input['myfixed_disable_small_screen'] ); 
				 
	        return $new_input;
	    }
		
		 //preload default options
		public function lmstickyjs_default_options() {
			
			global $options;
			
			$default = array(
					'lmstickyjs_class_selector' => '',
					'lmstickyjs_class_selector-two' => '',
					'myfixed_disable_small_screen' => '359'	
				);
			if ( get_option('lmstickyjs_option_name') == false ) {	
				update_option( 'lmstickyjs_option_name', $default );		
			}
	    }
		
	    //section text output
	    public function print_section_info()
	    {
	        print 'Target the div you would like to be sticky.  If you do not this plugin will try and determine your theme and in turn the necessary div/nav to target.  Thank you for using the plugin, please enjoy some free <a href="http://item9andthemadhatters.com">Rock Music</a>.';
	    }

	    //Get the settings option array and print one of its values 
	    public function lmstickyjs_class_selector_callback()
	    {
	        printf(
	            '<p class="description"><input type="text" size="8" id="lmstickyjs_class_selector" name="lmstickyjs_option_name[lmstickyjs_class_selector]" value="%s" /> id (#mydiv) or class (.myclass) of menu you want sticky</p>',
	            isset( $this->options['lmstickyjs_class_selector'] ) ? esc_attr( $this->options['lmstickyjs_class_selector']) : '' 
	        );
	    }

	    public function lmstickyjs_class_selector_two_callback()
	    {
	        printf(
	            '<p class="description"><input type="text" size="8" id="lmstickyjs_class_selector-two" name="lmstickyjs_option_name[lmstickyjs_class_selector-two]" value="%s" /> id (#mydiv) or class (.myclass) of menu you want sticky</p>',
	            isset( $this->options['lmstickyjs_class_selector-two'] ) ? esc_attr( $this->options['lmstickyjs_class_selector-two']) : '' 
	        );
	    }
		
	    public function myfixed_disable_small_screen_callback()
		{
			printf(
			'<p class="description"><input type="text" size="8" id="myfixed_disable_small_screen" name="lmstickyjs_option_name[myfixed_disable_small_screen]" value="%s" /> px or less, use to hide sticky effect on mobile and/or small screens</p>',
	            isset( $this->options['myfixed_disable_small_screen'] ) ? esc_attr( $this->options['myfixed_disable_small_screen']) : ''
			);
		}
		
	}//END OF CLASS
	if( is_admin() ) {$my_settings_page = new LowerMediaStickyAdminPage();}
	// end plugin admin settings	
?>