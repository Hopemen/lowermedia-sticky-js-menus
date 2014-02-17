// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.

// Revised by Pete Lower for WordPress Plugin LowerMedia Sticky JS Menus
// Free rock music: i9mh.com

(function($) {

  $('body').addClass('petejsclass');
  
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
