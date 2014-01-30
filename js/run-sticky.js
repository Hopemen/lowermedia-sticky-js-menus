jQuery(document).ready(function(){
  //
  //	DEFAULT
  //
  //jQuery(".lowermedia_add_sticky").sticky({ topSpacing: 0 });//#nav-wrapper
  //jQuery("#topbar").sticky({ topSpacing: 0 });//#nav-wrapper
  //document.write(LMScriptParams.themename);
  jQuery('body').addClass('pete-runsticky');
  jQuery('body').addClass(LMScriptParams.themename);

  if (LMScriptParams.themename=='twentythirteen') 
  	{
		jQuery("#navbar").sticky({ topSpacing: 0 });//#twentythirteen
	} 
  else if (LMScriptParams.themename=='twentytwelve')
    {
		jQuery("#site-navigation").sticky({ topSpacing: 0 });//twentytwelve
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
  else if (LMScriptParams.themename=='required-foundation') 
  	{
		jQuery("#access").sticky({ topSpacing: 0 });// required-foundation
	}
  else if (LMScriptParams.themename=='wp-foundation') 
  	{
		jQuery(".top-nav").sticky({ topSpacing: 0 });// wp-foundation
	}
  else 
  	{
		jQuery(".lowermedia_add_sticky").sticky({ topSpacing: 0 });//#default
    }
});