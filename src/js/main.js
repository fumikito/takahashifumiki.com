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
          if (window.confirm(netabareMsg)) {
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
            } catch (err) {
            }
            $(this).remove();
          }
        }).css({
          top: top + 'px'
        });
      } else if ($(elt).hasClass('netabare-inline')) {
        // ネタバレインライン
        $(elt).click(function (e) {
          if (window.confirm(netabareMsg)) {
            $(this).removeClass('netabare-inline').effect('highlight', {}, 1000).unbind('click');
            try {
              ga('send', {
                hitType      : 'event',
                eventCategory: 'netabare',
                eventAction  : window.location.pathname,
                eventLabel   : (index + 1),
                eventValue   : 1
              });
            } catch (err) {
            }
          }
        });
      }
    });

    // トップページ Masonry
    $(document).on('masonry', '.front-widgets', function(){
      var $homeContainer = $(this).find('.row');
      if ($homeContainer.length) {
        $homeContainer.imagesLoaded(function () {
          $homeContainer.masonry({
            itemSelector: '.widget'
          });
        });
      }
    });
    var $front = $('.front-widgets');
    $front.trigger('masonry')
  });

  // Headroom
  $(".headroom").headroom();

  $('.front-image-toggle').click(function(e){
    e.preventDefault();
    $('#front-image-wrapper').toggleClass('toggle');
  });

  // Check UA and if english, show add title
  var browserLanguage = function() {
    var ua = window.navigator.userAgent.toLowerCase();
    try {
      // chrome
      if( ua.indexOf( 'chrome' ) != -1 ){
        return ( navigator.languages[0] || navigator.browserLanguage || navigator.language || navigator.userLanguage).substr(0,2);
      }
      // それ以外
      else{
        return ( navigator.browserLanguage || navigator.language || navigator.userLanguage).substr(0,2);
      }
    }
    catch( e ) {
      return undefined;
    }
  };
  if ( 'ja' !== browserLanguage() ) {
    $('body').addClass('may-prefer-english');
  }


})(jQuery);


//ロードイベントでTwitterウィジェットを調整する
(function ($) {
  "use strict";
  $.event.add(window, 'load', function () {
    //Twitterウィジェットの調整
    $('.twitter-tweet-rendered').each(function (index, elt) {
      $(elt).attr('style', '').removeClass('twitter-tweet-rendered').addClass('fumiki-twitter-rendered');
    });
  });
})(jQuery);


