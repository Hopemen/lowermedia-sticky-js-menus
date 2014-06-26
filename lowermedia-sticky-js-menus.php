<?php
/*
Plugin Name: LowerMedia Sticky.js Menu's
Plugin URI: http://lowermedia.net
Description: WordPress plugin that integrates sticky.js and makes your primary navigation menu sticky (will 'stick' to top of screen when rolled over).  Activate and make your primary menu sticky!  Sticky means having your navigation always visible, the nav fixes itself to the top of the page.  This plugin uses the <a href='http://stickyjs.com'>Sticky.js</a> script, props and credit for creating that go to <a href="http://anthonygarand.com">Anthony Garand</a>, Thanks Anthony!   
Version: 2.0.3
Stable: 2.0.3
Author: Pete Lower
Author URI: http://petelower.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Block direct acess to the file
defined('ABSPATH') or die("Cannot access pages directly.");

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
		  'disableatwidth' => $lmstickyjs_options['myfixed_disable_small_screen']
		);

		
		wp_localize_script( 'sticky', 'LMScriptParams', $params );
		wp_localize_script( 'run-sticky', 'LMScriptParams', $params );
	}  
	add_action( 'wp_enqueue_scripts', 'lowermedia_add_sticky_js' ); 


// function lmstickyjsmenu_script() {
		
// 		$lmstickyjs_options = get_option( 'lmstickyjs_option_name' );
		
// 		// Register scripts
// 			wp_register_script('lmstickyjsmenu', WP_PLUGIN_URL. '/lowermedia-sticky/lmstickyjsmenu.js', false,'1.0.0', true);
// 			wp_enqueue_script( 'lmstickyjsmenu' );

// 		// Localize lmstickyjsmenu.js script with lmstickyjsmenu options
// 		$lmstickyjs_translation_array = array( 
// 		    'lmstickyjs_string' => $lmstickyjs_options['lmstickyjs_class_selector'] ,
// 			'lmstickyjs_active_on_height_string' => $lmstickyjs_options['lmstickyjs_active_on_height'],
// 			'lmstickyjs_disable_at_width_string' => $lmstickyjs_options['myfixed_disable_small_screen']
// 		);
		
// 			wp_localize_script( 'lmstickyjsmenu', 'lmstickyjs_name', $lmstickyjs_translation_array );
// 	}
// 	add_action( 'wp_enqueue_scripts', 'lmstickyjsmenu_script' );

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
	            <h2>LowerMedia Sticky.js Settings</h2>           
	            <form method="post" action="options.php">
	            <?php
	                // This prints out all hidden setting fields
	                settings_fields( 'lmstickyjs_option_group' );   
	                do_settings_sections( 'lm-stickyjs-settings' );
	                submit_button(); 
	            ?>
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
	            'Sticky Class', // Title 
	            array( $this, 'lmstickyjs_class_selector_callback' ), // Callback
	            'lm-stickyjs-settings', // Page
	            'setting_section_id' // Section         
	        );
	        
			add_settings_field(
	            'myfixed_disable_small_screen', 
	            'Disable at Small Screen Sizes', 
	            array( $this, 'myfixed_disable_small_screen_callback' ), 
	            'lm-stickyjs-settings', 
	            'setting_section_id'
	        );

				  //       add_settings_field(
				  //           'myfixed_zindex', 
				  //           'Sticky z-index', 
				  //           array( $this, 'myfixed_zindex_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );
						
						// add_settings_field(
				  //           'myfixed_bgcolor', 
				  //           'Sticky Background Color', 
				  //           array( $this, 'myfixed_bgcolor_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );
						
						// add_settings_field(
				  //           'myfixed_opacity', 
				  //           'Sticky Opacity', 
				  //           array( $this, 'myfixed_opacity_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );
						
						// add_settings_field(
				  //           'myfixed_transition_time', 
				  //           'Sticky Transition Time', 
				  //           array( $this, 'myfixed_transition_time_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );
						
			
						// add_settings_field(
				  //           'lmstickyjs_active_on_height', 
				  //           'Make visible when scroled', 
				  //           array( $this, 'lmstickyjs_active_on_height_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );
						
						// add_settings_field(
				  //           'myfixed_fade', 
				  //           'Fade or slide effect', 
				  //           array( $this, 'myfixed_fade_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
				  //       );	
						
						// add_settings_field(
				  //           'myfixed_cssstyle', 
				  //           '.myfixed css class', 
				  //           array( $this, 'myfixed_cssstyle_callback' ), 
				  //           'lm-stickyjs-settings', 
				  //           'setting_section_id'
							 
				  //       );
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

	        if( isset( $input['myfixed_disable_small_screen'] ) )
	            $new_input['myfixed_disable_small_screen'] = absint( $input['myfixed_disable_small_screen'] );
				

			//       if( isset( $input['myfixed_zindex'] ) )
			//           $new_input['myfixed_zindex'] = absint( $input['myfixed_zindex'] );
				
			// if( isset( $input['myfixed_bgcolor'] ) )
			//           $new_input['myfixed_bgcolor'] = sanitize_text_field( $input['myfixed_bgcolor'] );
				
			// if( isset( $input['myfixed_opacity'] ) )
			//           $new_input['myfixed_opacity'] = absint( $input['myfixed_opacity'] );
				
			// if( isset( $input['myfixed_transition_time'] ) )
			//           $new_input['myfixed_transition_time'] = sanitize_text_field( $input['myfixed_transition_time'] );
			
			// if( isset( $input['lmstickyjs_active_on_height'] ) )
			//           $new_input['lmstickyjs_active_on_height'] = absint( $input['lmstickyjs_active_on_height'] );
				
			// if( isset( $input['myfixed_fade'] ) )
			//           $new_input['myfixed_fade'] = sanitize_text_field( $input['myfixed_fade'] ); 

			// if( isset( $input['myfixed_cssstyle'] ) )
			//           //$new_input['myfixed_cssstyle'] = esc_textarea( $input['myfixed_cssstyle'] );
			//            $new_input['myfixed_cssstyle'] = sanitize_text_field( $input['myfixed_cssstyle'] );
				 
				 
	        return $new_input;
	    }
		
		 //preload default options
		public function lmstickyjs_default_options() {
			
			global $options;
			
			$default = array(
					'lmstickyjs_class_selector' => '',
					'myfixed_disable_small_screen' => '359'
					// 'myfixed_zindex' => '1000000',
					// 'myfixed_bgcolor' => '#F39A30',
					// 'myfixed_opacity' => '95',
					// 'myfixed_transition_time' => '0.3',
					// 'lmstickyjs_active_on_height' => '320',
					// 'myfixed_fade' => false,
					// 'myfixed_cssstyle' => '.myfixed { margin:0 auto!important; float:none!important; border:0px!important; background:none!important; max-width:100%!important; }'	
				);
			if ( get_option('lmstickyjs_option_name') == false ) {	
				update_option( 'lmstickyjs_option_name', $default );		
			}
	    }
		
	    //section text output
	    public function print_section_info()
	    {
	        print 'Add nice modern sticky menu or header to any theme. Defaults works for Twenty Thirteen theme. <br />For other themes change "Sticky Class" to div class desired to be sticky (div id can be used too).';
	    }

	    //Get the settings option array and print one of its values 
	    public function lmstickyjs_class_selector_callback()
	    {
	        printf(
	            '<p class="description"><input type="text" size="8" id="lmstickyjs_class_selector" name="lmstickyjs_option_name[lmstickyjs_class_selector]" value="%s" /> menu or header div class or id.</p>',
	            isset( $this->options['lmstickyjs_class_selector'] ) ? esc_attr( $this->options['lmstickyjs_class_selector']) : '' 
	        );
	    }
		
	    public function myfixed_disable_small_screen_callback()
		{
			printf(
			'<p class="description">less than <input type="text" size="4" id="myfixed_disable_small_screen" name="lmstickyjs_option_name[myfixed_disable_small_screen]" value="%s" />px width, 0  to disable.</p>',
	            isset( $this->options['myfixed_disable_small_screen'] ) ? esc_attr( $this->options['myfixed_disable_small_screen']) : ''
			);
		}

			//    public function myfixed_zindex_callback()
			//    {
			//        printf(
			//            '<p class="description"><input type="text" size="8" id="myfixed_zindex" name="lmstickyjs_option_name[myfixed_zindex]" value="%s" /> sticky z-index.</p>',
			//            isset( $this->options['myfixed_zindex'] ) ? esc_attr( $this->options['myfixed_zindex']) : ''
			//        );
			//    }

			// public function myfixed_bgcolor_callback()
			//    {
			//        printf(
			//            '<p class="description"><input type="text" size="8" id="myfixed_bgcolor" name="lmstickyjs_option_name[myfixed_bgcolor]" value="%s" /> full width background color.</p>' ,
			//            isset( $this->options['myfixed_bgcolor'] ) ? esc_attr( $this->options['myfixed_bgcolor']) : ''
			//        );
			//    }

			// public function myfixed_opacity_callback()
			//    {
			//        printf(
			//            '<p class="description"><input type="text" size="4" id="myfixed_opacity" name="lmstickyjs_option_name[myfixed_opacity]" value="%s" /> numbers 1-100.</p>',
			//            isset( $this->options['myfixed_opacity'] ) ? esc_attr( $this->options['myfixed_opacity']) : ''
			//        );
			//    }

			// public function myfixed_transition_time_callback()
			//    {
			//        printf(
			//            '<p class="description"><input type="text" size="4" id="myfixed_transition_time" name="lmstickyjs_option_name[myfixed_transition_time]" value="%s" /> in seconds.</p>',
			//            isset( $this->options['myfixed_transition_time'] ) ? esc_attr( $this->options['myfixed_transition_time']) : ''
			//        );
			//    }

			// public function lmstickyjs_active_on_height_callback()
			// {
			// 	printf(
			// 	'<p class="description">after <input type="text" size="4" id="lmstickyjs_active_on_height" name="lmstickyjs_option_name[lmstickyjs_active_on_height]" value="%s" />px, </p>',
			//            isset( $this->options['lmstickyjs_active_on_height'] ) ? esc_attr( $this->options['lmstickyjs_active_on_height']) : ''
			// 	);
			// }

			// public function myfixed_fade_callback()
			// {
			// 	printf(
			// 		'<p class="description"><input id="%1$s" name="lmstickyjs_option_name[myfixed_fade]" type="checkbox" %2$s /> Checked is slide, unchecked is fade.</p>',
			// 		'myfixed_fade',
			// 		checked( isset( $this->options['myfixed_fade'] ), true, false ) 
			// 	);
				
			// } 

			//   public function myfixed_cssstyle_callback()

			//    {
			//        printf(
			//            '
			// 		<p class="description">Add/Edit .myfixed css class to change sticky menu style. Leave it blank for default style.</p>  <textarea type="text" rows="4" cols="60" id="myfixed_cssstyle" name="lmstickyjs_option_name[myfixed_cssstyle]">%s</textarea> <br />
			// 	' ,
			//            isset( $this->options['myfixed_cssstyle'] ) ? esc_attr( $this->options['myfixed_cssstyle']) : ''
			//        );
			// 	echo '<p class="description">Default style: .myfixed { margin:0 auto!important; float:none!important; border:0px!important; background:none!important; max-width:100%!important; }<br /><br />If you want to change sticky hover color first add default style and than: .myfixed li a:hover {color:#000; background-color: #ccc;} .<br /> More examples <a href="http://wordpress.transformnews.com/tutorials/lmstickyjsmenu-extended-style-functionality-using-myfixed-sticky-class-403" target="blank">here</a>.</p>';
			//    }
		
	}//END OF CLASS
	if( is_admin() ) {$my_settings_page = new LowerMediaStickyAdminPage();}
	// end plugin admin settings

	// Remove default option for more link that jumps at the midle of page and its covered by menu

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

	// Create style from options

	// function lmstickyjs_build_stylesheet_content() {
	
	// 	$lmstickyjs_options = get_option( 'lmstickyjs_option_name' );
		
	//     echo
	// '<style type="text/css">';
	// 	if ( is_user_logged_in() ) {
	//     echo '#wpadminbar { position: absolute !important; top: 0px !important;}';
	// 	}
	// 	if (  $lmstickyjs_options['myfixed_cssstyle'] == "" )  {
	// 	echo '.myfixed { margin:0 auto!important; float:none!important; border:0px!important; background:none!important; max-width:100%!important; }';
	// 	}
	// 	echo
	// 	  $lmstickyjs_options ['myfixed_cssstyle'] ;
		
	// 	echo
	// 	'
	// 	#lmstickyjs-nav { width:100%!important;  position: static;';
		    
	// 	if (isset($lmstickyjs_options['myfixed_fade'])){
		
	// 	echo
	// 	'top: -100px;';
	// 	}
	// 	echo
	// 	'}';
		
	// 	if  ($lmstickyjs_options ['myfixed_opacity'] == 100 ){
	   
		
	// 	echo
	// 	'.wrapfixed { position: fixed!important; top:0px!important; left: 0px!important; margin-top:0px!important;  z-index: '. $lmstickyjs_options ['myfixed_zindex'] .'; -webkit-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; -moz-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; -o-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's;  background-color: ' . $lmstickyjs_options ['myfixed_bgcolor'] . '!important;  }
	// 	';
	// 	}
	// 	if  ($lmstickyjs_options ['myfixed_opacity'] < 100 ){
	   
		
	// 	echo
	// 	'.wrapfixed { position: fixed!important; top:0px!important; left: 0px!important; margin-top:0px!important;  z-index: '. $lmstickyjs_options ['myfixed_zindex'] .'; -webkit-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; -moz-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; -o-transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's; transition: ' . $lmstickyjs_options ['myfixed_transition_time'] . 's;   -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=' . $lmstickyjs_options ['myfixed_opacity'] . ')"; filter: alpha(opacity=' . $lmstickyjs_options ['myfixed_opacity'] . '); opacity:.' . $lmstickyjs_options ['myfixed_opacity'] . '; background-color: ' . $lmstickyjs_options ['myfixed_bgcolor'] . '!important;  }
	// 	';
	// 	}
		
	// 	if  ($lmstickyjs_options ['myfixed_disable_small_screen'] > 0 ){
	//     echo
	// 		'@media (max-width: ' . $lmstickyjs_options ['myfixed_disable_small_screen'] . 'px) {.wrapfixed {position: static!important; display: none!important;}}
	// 	';
	// 	}
	// 	echo 
	// '</style>
	// 	';
	// }
	// add_action('wp_head', 'lmstickyjs_build_stylesheet_content');
	
	
	
?>