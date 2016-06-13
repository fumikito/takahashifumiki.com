/**
 * Description
 */

(function ($) {
  'use strict';

  $.material.init();

  jQuery(document).ready(function ($) {
    // クッキーをチェックして、ログインしてるか確認
    var $loggineBtn = $('#login-button');
    if (/fumikicustomer=1/.test(document.cookie)) {
      $('.account__logged-out').remove();
      $loggineBtn.attr('href', $loggineBtn.attr('data-href'));
    }

    // ブラーフィルターがないブラウザ
    if (/Firefox/.test(navigator.userAgent) || (/MSIE/.test(navigator.userAgent) && !(/MSIE (5|6|7|8|9)\.0/.test(navigator.userAgent)))) {
      $('body').addClass('non-filter-blur');
    }
    if (/MSIE 10/.test(navigator.userAgent)) {
      $('body').addClass('non-ms-filter');
    }

    // ネタバレ
    var netabareMsg = 'この部分はネタバレなどの「筆者が表示しない方が良いと判断した内容」を含みます。表示してよろしいですか？';

    $('.netabare, .netabare-inline').each(function (index, elt) {
      if ($(elt).hasClass('netabare')) {
        // ブロック要素の場合
        var button = $('<a class="netabare-opener button" href="#" data-index="' + (index + 1) + '"><i class="fa-folder-open"></i>ネタバレ表示</a>'),
            top    = $(elt). height() / 2 * -1;
        $(elt).after(button);
        button.click(function (e) {
          e.preventDefault();
          if (confirm(netabareMsg)) {
            $(elt).removeClass('netabare').removeClass('non-filter-blur');
            if ($(elt).effect) {
              $(elt).effect('highlight', {}, 1000);
            }
            try {
              ga('send', {
                hitType      : 'event',
                eventCategory: 'netabare',
                eventAction  : window.location.pathname,
                eventLabel   : $(this).attr('data-index'),
                eventValue   : 1
              });
            } catch (e) {
            }
            $(this).remove();
          }
        }).css({
          top: top + 'px'
        });
      } else if ($(elt).hasClass('netabare-inline')) {
        // ネタバレインライン
        $(elt).click(function (e) {
          if (confirm(netabareMsg)) {
            $(this).removeClass('netabare-inline').effect('highlight', {}, 1000).unbind('click');
            try {
              ga('send', {
                hitType      : 'event',
                eventCategory: 'netabare',
                eventAction  : window.location.pathname,
                eventLabel   : (index + 1),
                eventValue   : 1
              });
            } catch (e) {
            }
          }
        });
      }
    });


    // トップページ Masonry
    var $homeContainer = $('.front-widgets .row');
    if ( $homeContainer.length ) {
      $homeContainer.imagesLoaded(function(){
        $homeContainer.masonry({
          itemSelector: '.widget'
        });
      });
    }
  });
  
})(jQuery);


//ロードイベントでTwitterウィジェットを調整する
(function ($) {
  $.event.add(window, 'load', function () {
    //Twitterウィジェットの調整
    $('.twitter-tweet-rendered').each(function (index, elt) {
      $(elt).attr('style', '').removeClass('twitter-tweet-rendered').addClass('fumiki-twitter-rendered');
    });
  });
})(jQuery);
