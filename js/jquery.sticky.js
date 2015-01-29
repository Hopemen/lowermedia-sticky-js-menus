/**
 *
 *
 *  This script receives a parameter (the active theme's themename) from lowermedia-sticky-js-menus.php,
 *   it uses this parameter to decide which div to put the sticky wrapper around.
 *
 *   The .sticky function is defined in jquery.sticky.js.
 *
 *   This script also adds two classes to the body for debuging/testing and/or styling if needed
 **/

jQuery(document).ready(function(){

  jQuery('body').addClass(LMScriptParams.disableatwidth+' pete-runsticky '+LMScriptParams.themename);

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

// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Modifications for WordPress Plugin Usage by Pete Lower
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
//
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.
//
// Revised by LowerMedia for WordPress Plugin LowerMedia Sticky JS Menus
// Free rock music: i9mh.com

(function($) {

  $('body').addClass('petejsclass');
  console.log(LMScriptParams);
  

  //  THIS IF STATEMENT DECIDES THE WIDTH OF THE STICKY NAV
  //  CONTAINER BASED ON THE DIV SPECIFIED
  var gotwidth;
  if (LMScriptParams.themename=='responsive')
    {
      gotwidth = '#header';//CHANGING VARIABLE LINE PER THEME
    }
  else if (LMScriptParams.themename=='twentytwelve' || LMScriptParams.themename=='required-foundation')
    {
      gotwidth = '.row';
    }
  else if (LMScriptParams.themename=='sixteen' || LMScriptParams.themename=='spun')
    {
      gotwidth = '';
    }
  else if (LMScriptParams.themename=='attitude')
    {
      gotwidth = '#wrapper';
    }
  else if (LMScriptParams.themename=='destro')
    {
      gotwidth = '#content_section';
    }
  else if (LMScriptParams.themename=='Isabelle')
    {
      gotwidth = '.container';
    }
  else
    {
      gotwidth = '#page';//CHANGING VARIABLE LINE PER THEME
    }


    


  //define a variable named defaults that will hold default css declarations
  var defaults = {
      topSpacing: 0,
      bottomSpacing: 0,
      className: 'is-sticky',
      wrapperClassName: 'sticky-wrapper',
      center: false,
      getWidthFrom: gotwidth//CHANGING VARIABLE LINE PER THEME
    },
    $window = $(window),
    $document = $(document),
    sticked = [],
    windowHeight = $window.height(),
    scroller = function() {
      var scrollTop = $window.scrollTop(),
        documentHeight = $document.height(),
        dwh = documentHeight - windowHeight,
        extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

      for (var i = 0; i < sticked.length; i++) {
        var s = sticked[i],
          elementTop = s.stickyWrapper.offset().top,
          etse = elementTop - s.topSpacing - extra;

        if (scrollTop <= etse) {
          if (s.currentTop !== null) {
            s.stickyElement
              .css('position', '')
              .css('top', '')
              .css('width', '')
              .css('z-index', '');
              
            if (LMScriptParams.themename=='twentytwelve') {
              s.stickyElement.css('margin', '');
            }

            if (LMScriptParams.themename=='sixteen') {
              s.stickyElement.css('margin-left', '');
            }

            if (LMScriptParams.themename=='destro') {
              s.stickyElement.css('max-width', '');
            }
            
            s.stickyElement.parent().removeClass(s.className);
            s.currentTop = null;
          }
        }
        else {
          var newTop = documentHeight - s.stickyElement.outerHeight()
            - s.topSpacing - s.bottomSpacing - scrollTop - extra;
          if (newTop < 0) {
            newTop = newTop + s.topSpacing;
          } else {
            newTop = s.topSpacing;
          }
          if (s.currentTop != newTop) {
            s.stickyElement
              .css('position', 'fixed')
              .css('top', newTop)
              .css('width', '')
              .css('z-index', '200');

            if (LMScriptParams.themename=='twentytwelve') {
              s.stickyElement.css('margin', '0');
              s.stickyElement.css('width', s.stickyElement.parent().width() );
            }

            if (LMScriptParams.themename=='sixteen') {
              s.stickyElement.css('margin-left', '-120px');
            }

            if (LMScriptParams.themename=='destro') {
              s.stickyElement.css('width', '94%');
              s.stickyElement.css('max-width', '1122px');
            } else {

              if (typeof s.getWidthFrom !== 'undefined') {
                s.stickyElement.css('width', $(s.getWidthFrom).width());
              }

            }

            s.stickyElement.parent().addClass(s.className);
            $('body').addClass('petejsclass-sticky');
            s.currentTop = newTop;
          }
        }
      }
    },
    resizer = function() {
      windowHeight = $window.height();
    },
    methods = {
      init: function(options) {
        var o = $.extend(defaults, options);
        return this.each(function() {
          var stickyElement = $(this);

          stickyId = stickyElement.attr('id');
          wrapper = $('<div></div>')
            .attr('id', stickyId + '-sticky-wrapper')
            .addClass(o.wrapperClassName);
          stickyElement.wrapAll(wrapper);

          if (o.center) {
            stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
          }

          if (stickyElement.css("float") == "right") {
            stickyElement.css({"float":"none"}).parent().css({"float":"right"});
          }

          var stickyWrapper = stickyElement.parent();
          
          if (LMScriptParams.themename!='responsive') {
            stickyWrapper.css('height', stickyElement.outerHeight());//hide if responsive
            stickyWrapper.css('margin-bottom', stickyElement.outerHeight());//hide if responsive
          }
          
          sticked.push({
            topSpacing: o.topSpacing,
            bottomSpacing: o.bottomSpacing,
            stickyElement: stickyElement,
            currentTop: null,
            stickyWrapper: stickyWrapper,
            className: o.className,
            getWidthFrom: o.getWidthFrom
          });
        });
      },
      update: scroller
    };

  // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
  if (window.addEventListener) {
    window.addEventListener('scroll', scroller, false);
    window.addEventListener('resize', resizer, false);
  } else if (window.attachEvent) {
    window.attachEvent('onscroll', scroller);
    window.attachEvent('onresize', resizer);
  }

  $.fn.sticky = function(method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.sticky');
    }
  };
  $(function() {
    setTimeout(scroller, 0);
  });

  if ($( "#undefined-sticky-wrapper" ).hasClass( "is-sticky" )) {$('body').addClass('petejsclass-is-sticky');}//hide if responsive

})(jQuery);
