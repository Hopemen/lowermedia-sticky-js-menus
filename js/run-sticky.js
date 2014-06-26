/*
#
#
#   This script recieves a parameter (the active theme's themename) from lowermedia-sticky-js-menus.php,
#   it uses this parameter to decide which div to put the sticky wrapper around.
#
#   The .sticky function is defined in jquery.sticky.js.
#
#   This script also adds two classes to the body for debuging/testing and/or styling if needed
#
#
*/

jQuery(document).ready(function(){
  jQuery('body').addClass('pete-runsticky');
  jQuery('body').addClass(LMScriptParams.themename);
  jQuery('body').addClass(LMScriptParams.disableatwidth);

    {
      jQuery("#site-navigation").sticky({ topSpacing: 0 });//lowermedia_one_page_theme, expound, sixteen, bushwik, or twentytwelve
    }
  else
    {
      jQuery(".lowermedia_add_sticky").sticky({ topSpacing: 0 });//#default
    }
});