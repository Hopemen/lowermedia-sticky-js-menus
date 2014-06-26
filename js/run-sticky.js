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

  if (jQuery('body').width() > LMScriptParams.disableatwidth) {
    if(LMScriptParams.stickytarget)
      {
        jQuery('body').addClass('target-'+LMScriptParams.stickytarget);
        jQuery(LMScriptParams.stickytarget).sticky({ topSpacing: 0 });
      }
    else
      {
        jQuery('body').addClass('sticky-using-default-target');

        //IF THE USER DOESN'T TARGET WE WILL TRY AND DO IT FOR THEM
        if (LMScriptParams.themename=='twentythirteen')
          {
            jQuery("#navbar").sticky({ topSpacing: 0 });//#twentythirteen
          }
        else if (LMScriptParams.themename=='twentyeleven')
          {
            jQuery("nav#access").sticky({ topSpacing: 0 });//twentyeleven
          }
        else if (LMScriptParams.themename=='twentyten')
          {
            jQuery("#access").sticky({ topSpacing: 0 });//twentyten
          }
        else if (LMScriptParams.themename=='responsive')
          {
            jQuery(".main-nav").sticky({ topSpacing: 0 });//responsive
          }
        else if (LMScriptParams.themename=='virtue')
          {
            jQuery("#topbar").sticky({ topSpacing: 0 });//virtue
          }
        else if (LMScriptParams.themename=='wp-foundation')
          {
            jQuery(".top-nav").sticky({ topSpacing: 0 });//wp-foundation
          }
        else if (LMScriptParams.themename=='neuro')
          {
            jQuery("#navigation_menu").sticky({ topSpacing: 0 });//neuro
          }
        else if (LMScriptParams.themename=='Swtor_NeozOne_Wp')
          {
            jQuery(".art-nav").sticky({ topSpacing: 0 });//Swtor_NeozOne_Wp
          }
        else if (LMScriptParams.themename=='destro')
          {
            jQuery("#menu").sticky({ topSpacing: 0 });//destro
          }
        else if (LMScriptParams.themename=='attitude' || LMScriptParams.themename=='required-foundation')
          {
            jQuery("#access").sticky({ topSpacing: 0 });//attitude or required-foundation
          }
        else if (LMScriptParams.themename=='spun')
          {
            jQuery(".site-navigation").sticky({ topSpacing: 0 });//spun
          }
        else if (LMScriptParams.themename=='Isabelle')
          {
            jQuery(".nav").sticky({ topSpacing: 0 });//spun
          }
        else if (LMScriptParams.themename=='one-page')
          {
            jQuery(".header_wrapper").sticky({ topSpacing: 0 });//one-page
            jQuery(".homepage_nav_title").sticky({ topSpacing: 0 });//spun
          }
        else if (LMScriptParams.themename=='spacious')
          {
            jQuery("#header-text-nav-container").sticky({ topSpacing: 0 });//spun
          }
        else if (LMScriptParams.themename=='lowermedia_one_page_theme' || LMScriptParams.themename=='expound' || LMScriptParams.themename=='sixteen' || LMScriptParams.themename=='bushwick' || LMScriptParams.themename=='twentytwelve')
          {
            jQuery("#site-navigation").sticky({ topSpacing: 0 });//lowermedia_one_page_theme, expound, sixteen, bushwik, or twentytwelve
          }
        else
          {
            jQuery(".lowermedia_add_sticky").sticky({ topSpacing: 0 });//#default
          }
      }

    if(LMScriptParams.stickytargettwo)
      {
        jQuery('body').addClass('target-'+LMScriptParams.stickytargettwo);
        jQuery(LMScriptParams.stickytargettwo).sticky({ topSpacing: 0 });
      }
  }
});