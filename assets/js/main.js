!function(e){"use strict";e.material.init(),jQuery(document).ready(function(e){var t=new Date;e('input[name="MMERGE4"]').val([("0"+t.getDate()).slice(-2),("0"+(t.getMonth()+1)).slice(-2),t.getFullYear()].join("/"));var a=e("#login-button");/fumikicustomer=1/.test(document.cookie)&&(e(".account__logged-out").remove(),a.attr("href",a.attr("data-href"))),(/Firefox/.test(navigator.userAgent)||/MSIE/.test(navigator.userAgent)&&!/MSIE (5|6|7|8|9)\.0/.test(navigator.userAgent))&&e("body").addClass("non-filter-blur"),/MSIE 10/.test(navigator.userAgent)&&e("body").addClass("non-ms-filter");var n="この部分はネタバレなどの「筆者が表示しない方が良いと判断した内容」を含みます。表示してよろしいですか？";e(".netabare, .netabare-inline").each(function(t,a){if(e(a).hasClass("netabare")){var r=e('<a class="netabare-opener button" href="#" data-index="'+(t+1)+'"><i class="fa-folder-open"></i>ネタバレ表示</a>'),i=e(a).height()/2*-1;e(a).after(r),r.click(function(t){if(t.preventDefault(),window.confirm(n)){e(a).removeClass("netabare").removeClass("non-filter-blur"),e(a).effect&&e(a).effect("highlight",{},1e3);try{ga("send",{hitType:"event",eventCategory:"netabare",eventAction:window.location.pathname,eventLabel:e(this).attr("data-index"),eventValue:1})}catch(r){}e(this).remove()}}).css({top:i+"px"})}else e(a).hasClass("netabare-inline")&&e(a).click(function(a){if(window.confirm(n)){e(this).removeClass("netabare-inline").effect("highlight",{},1e3).unbind("click");try{ga("send",{hitType:"event",eventCategory:"netabare",eventAction:window.location.pathname,eventLabel:t+1,eventValue:1})}catch(r){}}})}),e(document).on("masonry",".front-widgets",function(){var t=e(this).find(".row");t.length&&t.imagesLoaded(function(){t.masonry({itemSelector:".widget"})})});var r=e(".front-widgets");r.trigger("masonry")}),e(".headroom").headroom(),e(".front-image-toggle").click(function(t){t.preventDefault(),e("#front-image-wrapper").toggleClass("toggle")});var t=function(){var e=window.navigator.userAgent.toLowerCase();try{return e.indexOf("chrome")!=-1?(navigator.languages[0]||navigator.browserLanguage||navigator.language||navigator.userLanguage).substr(0,2):(navigator.browserLanguage||navigator.language||navigator.userLanguage).substr(0,2)}catch(t){return}};"ja"!==t()&&e("body").addClass("may-prefer-english")}(jQuery),function(e){"use strict";e.event.add(window,"load",function(){e(".twitter-tweet-rendered").each(function(t,a){e(a).attr("style","").removeClass("twitter-tweet-rendered").addClass("fumiki-twitter-rendered")})})}(jQuery);
//# sourceMappingURL=map/main.js.map
