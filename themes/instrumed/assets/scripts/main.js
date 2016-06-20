/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  function shuffle(array) {
    var m = array.length, t, i;

    // While there remain elements to shuffle…
    while (m) {

      // Pick a remaining element…
      i = Math.floor(Math.random() * m--);

      // And swap it with the current element.
      t = array[m];
      array[m] = array[i];
      array[i] = t;
    }

    return array;
  }

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        //Open the mobile navigation on click
        $("#mobile_nav_trigger_wrap").click(function(e){
          e.preventDefault();
          $("#sitewrap").toggleClass('mobile_nav_open');
          $(".header-mobile").toggleClass('mobile_nav_open');
        });





        /*setTimeout(function () {
          $(".image_grid .ig_animated img").css('opacity',0);
        }, 10000);*/
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

          "use strict";

          var $container = [$('.isotope_wrapper')];

          jQuery.each($container, function (j, obj) {
              var wall = this.children('.isotope_grid_gallery').isotope({
                itemSelector : '.element-item'
              });

              wall.imagesLoaded().progress( function() {
                wall.isotope('layout');
              });

              //Initialize filter links for each option set
              jQuery.each(this.find('.option-set'), function (index, object) {
                  var $optionLinks = jQuery(this).find('button');
                  $optionLinks.click(function () {
                      var $this = $(this), $optionSet = $this.parents('.option-set'), options = {},
                          key = $optionSet.attr('data-option-key'),
                          value = $this.attr('data-option-value'),
                          target = $this.attr('data-target');
                          
                      // don't proceed if already selected
                      if ($this.hasClass('active')) {
                        return false;
                      }

                      $optionSet.find('.active').removeClass('active');
                      $this.addClass('active');

                      // parse 'false' as false boolean
                      value = value === 'false' ? false : value;
                      options[key] = value;

                      jQuery("#"+target).children('.isotope_grid_gallery').isotope(options);
                      return false;
                  });
              });
          });


      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
