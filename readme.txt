=== LowerMedia Sticky.js Menu's ===
Contributors: hawkeye126
Donate link: http://lowermedia.net/
Tags: js, sticky.js, multisite, navigation
Requires at least: 3.0.1
Tested up to: 3.8.1
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress plugin that integrates sticky.js and makes your primary navigation menu sticky 
(will 'stick' to top of screen when rolled over).  

== Description ==

WordPress plugin that integrates sticky.js and makes your primary navigation menu sticky 
(will 'stick' to top of screen when rolled over).  

Activate and make your primary menu sticky!  
Sticky means having your navigation always visible, the nav fixes itself to the top of the page.  

This plugin uses the <a href='http://stickyjs.com'>Sticky.js</a> script, props and credit for creating that go to 
<a href="http://anthonygarand.com">Anthony Garand</a>, Thanks Anthony!   


<a href='http://lowermedia.net'>LowerMedia.Net</a>
<a href='http://petelower.com'>Dev'd by Pete</a>



More info:

This plugin was designed to work out of the box with a large number of popular themes if not all
the menu container and then manipulating the HTML tag w/ said class by way of JS

Plugins tested to work with this theme work a tad bit differently.  Instead of 
adding a class it uses custom js files that have the main navigational selectors 
already defined.  JS manipulates the menus by using the already defined tags. 

This plugin has been tested on a growing number of themes including: (will, in most cases, work on themes other than the following as well)
   twentythirteen, 
   twentytwelve, 
   twentyeleven, 
   responsive, 
   wp-foundation, 
   required-foundation, 
   neuro, 
   Swtor_NeozOne_Wp, 
   lowermedia_one_page_theme, 
   expound, 
   customizr, 
   sixteen, 
   destro, 
   swift basic

   *Some CSS edits may be required


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `LowerMedia_sticky-js-menus.zip` in the wordpress dashboard upload plugin section or unzip the file and upload the directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make sure you have a menu defined under appearance -> menus

== Frequently Asked Questions ==

= I am using one of the themes this plugin was tested to work on but it's not working. =

Please make sure your child theme has the same header navigation HTML syntax as the parent theme, this plugin is made to work with the latest iteration of the parent theme.

= My menu does not stick to the top of the page, there is some space between the menu and top of the page. =

Some theme styles or template styles may have overwritten the default styles, the site owner may have to tweak their own css to for ideal display.

== Changelog ==

= 1.0 =
*Plugin Launched

= 2.0 =
*Moving all js into two files instead of having individual files for specific themes
*Optimize and shorten code
*Increase number of themes tested with and supporting out of the box

== Upgrade Notice ==

Coming when needed

== Screenshots ==

Coming when needed