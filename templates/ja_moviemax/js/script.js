/**
 * ------------------------------------------------------------------------
 * JA Moviemax Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */


(function($){

  $(window).load(function () {
    ////////////////////////////////
    // equalheight for col
    ////////////////////////////////
    var ehArray = ehArray2 = [],
      i = 0;

    $('.equal-height').each (function(){
      var $ehc = $(this);
      if ($ehc.has ('.equal-height')) {
        ehArray2[ehArray2.length] = $ehc;
      } else {
        ehArray[ehArray.length] = $ehc;
      }
    });
    for (i = ehArray2.length -1; i >= 0; i--) {
      ehArray[ehArray.length] = ehArray2[i];
    }

    var equalHeight = function() {
      for (i = 0; i < ehArray.length; i++) {
        var $cols = ehArray[i].children().filter('.col'),
          maxHeight = 0,
          equalChildHeight = ehArray[i].hasClass('equal-height-child');

      // reset min-height
        if (equalChildHeight) {
          $cols.each(function(){$(this).children().first().css('min-height', 0)});
        } else {
          $cols.css('min-height', 0);
        }
        $cols.each (function() {
          maxHeight = Math.max(maxHeight, equalChildHeight ? $(this).children().first().innerHeight() : $(this).innerHeight()) + 1;
        });
        if (equalChildHeight) {
          $cols.each(function(){
            $(this).children().first().css('min-height', maxHeight);
      });
        } else {
          $cols.css('min-height', maxHeight);
        }
      }
      // store current size
      $('.equal-height > .col').each (function(){
        var $col = $(this);
        $col.data('old-width', $col.width()).data('old-height', $col.innerHeight());
        var $child=0;
        $col.children().each(function(){
          $child += $(this).innerHeight();
        });
        $col.attr('child-height', $child);
      });
    };

    equalHeight();

    // monitor col width and fire equalHeight
    setInterval(function() {
      $('.equal-height > .col').each(function(){
        var $col = $(this);
    var $child=0;
        $col.children().each(function(){
          $child += $(this).innerHeight();
        });

        if (parseInt($child) != parseInt($col.attr('child-height')) || ($col.data('old-width') && $col.data('old-width') != $col.width()) ||
            ($col.data('old-height') && $col.data('old-height') != $col.innerHeight())) {
          equalHeight();
          // break each loop
          return false;
        }
      });
  }, 500);
  });


})(jQuery);

// Right Sidebar Button
// --------------------
(function($){
  $(document).ready(function(){
    $('.btn-sidebar').click(function() {
        $('.btn-sidebar').toggleClass('open');
        $('.t3-big-sidebar').toggleClass('open');
        $('.t3-wrapper').toggleClass('sidebar-open');
        $('html').toggleClass('noscroll');
    });

    $(".t3-big-sidebar > .inner").mCustomScrollbar();
    $(".head-cart > .dropdown-menu").mCustomScrollbar();
    $(".t3-off-canvas .t3-off-canvas-header + .t3-off-canvas-body").mCustomScrollbar();

    if($('.t3-big-sidebar.hidden-lg').length > 0) {
      $('.t3-main-content').css('width', '100%'); 
      var $contentHeight = $('.t3-main-content').outerWidth();
      $('.t3-header').css('width', $contentHeight); 
      $(window).resize(function(){
        var $contentHeight = $('.t3-main-content').outerWidth();
        $('.t3-header').css('width', $contentHeight); 
      });
    }
  });
})(jQuery);

//Fix bug tab typography
(function($){
  $(document).ready(function(){
    if($('.docs-section .nav.nav-tabs').length > 0){
      $('.docs-section .nav.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
            });
    }
  });
})(jQuery);


// Head Search
// --------------
(function($){
  $(document).ready(function(){
    if($('.logo').outerWidth() < $('#t3-header .container').outerWidth()) {
      var searchWidth = $('#t3-header .container').outerWidth() - $('.head-right').outerWidth() - $('.logo').outerWidth();
      $('.head-search-wrap').css('width',searchWidth);
    } else {
      var searchWidth = $('#t3-header .container').outerWidth() - $('.head-right').outerWidth();
      $('.head-search-wrap').css('width',searchWidth);
    }
    

    $(window).resize(function(){
      if($('.logo').outerWidth() < $('#t3-header .container').outerWidth()) {
        var searchWidth = $('#t3-header .container').outerWidth() - $('.head-right').outerWidth() - $('.logo').outerWidth();
        $('.head-search-wrap').css('width',searchWidth);
      } else {
        var searchWidth = $('#t3-header .container').outerWidth() - $('.head-right').outerWidth();
        $('.head-search-wrap').css('width',searchWidth);
      }
    });

    $('.btn-search').click(function() {
        $('.head-search').toggleClass('btn-open');
        $('.head-search-wrap').toggleClass('btn-open');
        $('.head-right').toggleClass('btn-open');
        
        if ($('.head-search-wrap').hasClass('btn-open')) {
          $('#mod-search-searchword').focus();
        }
    });

    $('.modal').each(function(i) {
        var modal = $(this);
        if (modal.hasClass('hide')) {
            modal.attr('role', 'dialog').removeClass('hide').removeAttr('style');
            modal.html('<div class="modal-dialog modal-lg">' +
                '<div class="modal-content">' + modal.html() + '</div>' +
                '</div>');

            var oldModal = modal;
            modal.on('shown.bs.modal', function(e) {
                oldModal.trigger('show');
            });
        }
    });
  });


})(jQuery);