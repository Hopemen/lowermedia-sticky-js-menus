<?php
/*
Plugin Name: LowerMedia Sticky.js Menu's
Plugin URI: http://lowermedia.net
Description: Activate and make your primary menu sticky!
Version: 0.0.1
Stable: 0.0.1
Author: Pete Lower
Author URI: http://petelower.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


/*############################################################################################
#
#   ADD STICKY JS FILES/LIBRARIES(STICKY.JS)
#   //This function adds sticky javascript libraries and files
*/

function lowermedia_add_sticky_js()  
	{  
		//collect info about the theme to point to theme specific js files
		$theme_data = wp_get_theme();
	    echo 'Theme Title:'.$theme_data['Title'];
	    echo '<br/>Parent Title:'.$theme_data['Template'];

	    if ($theme_data['Template']=='responsive'){
	    	wp_register_script( 'sticky', plugins_url( '/js/jquery.responsive.sticky.js' , __FILE__ ) , array( 'jquery' ), '1.0.0', true);
	    } else if ($theme_data['Template']=='twentyeleven') {
	    	wp_register_script( 'sticky', plugins_url( '/js/jquery.twentyeleven.sticky.js' , __FILE__ ) , array( 'jquery' ), '1.0.0', true);
	    } else {
	    	wp_register_script( 'sticky', plugins_url( '/js/jquery.sticky.js' , __FILE__ ) , array( 'jquery' ), '1.0.0', true);
	    }

		// Register and enque sticky.js 
		// Sticky JS http://www.labs.anthonygarand.com/sticky
		
		wp_register_script( 'run-sticky', plugins_url( '/js/run-sticky.js' , __FILE__ ), array( 'sticky' ), '1.0.0', true);
		wp_enqueue_script( 'run-sticky' );
	}  
add_action( 'wp_enqueue_scripts', 'lowermedia_add_sticky_js' ); 

function my_wp_nav_menu_args( $args = '' )
{
	$args['menu'] = 'primary';
	$args['container_class'] = 'lowermedia_add_sticky';
	return $args;
} // function

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

// add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
// function special_nav_class($classes, $item){
//      //if(is_single() && $item->title == "Blog"){ //Notice you can change the conditional from is_single() and $item->title
//              $classes[] = "special-class";
//      //}
//      return $classes;
// }

// add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
// function add_menu_parent_class( $items ) {
	
// 	$parents = array();
// 	foreach ( $items as $item ) {
// 		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
// 			$parents[] = $item->menu_item_parent;
// 		}
// 	}
	
// 	foreach ( $items as $item ) {
// 		if ( in_array( $item->ID, $parents ) ) {
// 			$item->classes[] = 'menu-parent-item'; 
// 		}
// 	}
	
// 	return $items;    
// }

// add_filter('wp_nav_menu_objects' , 'my_menu_class');
// function my_menu_class($menu) {
//     $level = 0;
//     $stack = array('0');
//     foreach($menu as $key => $item) {
//         while($item->menu_item_parent != array_pop($stack)) {
//             $level--;
//         }   
//         $level++;
//         $stack[] = $item->menu_item_parent;
//         $stack[] = $item->ID;
//         $menu[$key]->classes[] = 'level-'. ($level - 1);
//     }                    
//     return $menu;        
// }

// function add_menuclass($ulclass) {
// 	return 'lowermedia-class';
// }
// add_filter('wp_nav_menu_objects','add_menuclass');

?>