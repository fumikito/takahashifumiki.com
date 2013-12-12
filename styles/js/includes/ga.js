/**! 
 * 
 * Google Analytics 関係のスクリプト
 * 
 * 
 */

jQuery(window).load(function(){
    // 全体の読み込みにかかった時間を出力
    try{
        ga('send', {
            hitType: 'event',
            eventCategory: 'documentLoaded',
            eventAction: GAM.pageAction,
            eventLabel: GAM.pageLabel,
            eventValue: GAM.getTime(),
            nonInteraction: true
        });
    }catch (e){}
});




jQuery(document).ready(function($){

    // DOMREADYにかかった時間を出力
    try{
        ga('send', {
            hitType: 'event',
            eventCategory: 'domReady',
            eventAction: GAM.pageAction,
            eventLabel: GAM.pageLabel,
            eventValue: GAM.getTime(),
            nonInteraction: true
        });
    }catch(e){}

	// 初期値を登録しておく
	var targets = ['#contents-last'],
		occurred = [],
		offsets = [],
		pad = 50,
		startTime = new Date(),
		methods = {
			/**
			 * ウィンドウを開いてからの経過時間を返す
			 * @returns {Number|@exp;Math@call;round}
			 */
			getDuration: function(){
				var current = new Date();
				return Math.round((current.getTime() - startTime.getTime()) / 100 ) / 10;
			}
		};
	for(i = 0, l = targets.length; i < l; i++){
		occurred.push(false);
		if($(targets[i]).length){
			offsets.push($(targets[i]).offset().top + $(targets[i]).height() + pad);
		}
	}
	
	
	
	// スクロールイベントに反応して
	// 要素出現イベントをトリガー
	$(window).bind("scroll", function() {
		var scrollPosition = $(window).height() + $(window).scrollTop();
		for(i = 0, l = targets.length; i < l; i++){
			if(occurred[i]){
				continue;
			}else if(scrollPosition > offsets[i] && $(targets[i]).length){
				occurred[i] = true;
				$(targets[i]).trigger('displayed', {
					position: scrollPosition,
					passed: methods.getDuration()
				});
			}
		}
	});
	
	
	
	// 読了イベントを計測
	$('#contents-last').bind('displayed', function(e, vars){
		try{
			ga('send', {
				hitType: 'event',
				eventCategory: 'read',
				eventAction: document.location.pathname,
				eventLabel: document.title,
				eventValue: vars.passed
			});
		}catch(e){}
	});
	
	
	
	// アウトバウンドリンクを計測
	$('a[href^=http]').click(function(e){
		if( !( /^(#|https?:\/\/(s\.)?takahashifumiki\.(com|local|info))/.test($(this).attr('href')) ) ){
			try{
				var url = $(this).attr('href'),
					target = ($(this).attr('target') && $(this).attr('target').length)
						? $(this).attr('target')
						: false;
				ga('send', {
					hitType: 'event',
					eventCategory: 'outbound',
					eventAction: url.split('/')[2],
					eventLabel: url,
					eventValue: methods.getDuration(),
					hitCallback: function(){
						window.location.href = url;
					}
				});
				e.preventDefault();
			}catch(e){}
		}
	});
	
	// ダウンロードを計測
	$('a.button-download').click(function(e){
		try{
			var url = $(this).attr('href'),
				fileId;
			if(url.match(/lwp_file=([0-9]+)/)){
				fileId = RegExp.$1;
			}else{
				fileId = 0;
			}
			ga('send', {
				hitType: 'event',
				eventCategory: 'download',
				eventAction: document.title,
				eventLabel: fileId,
				eventValue: 1,
				hitCallback: function(){
					window.location.href = url;
				}
			});
			e.preventDefault();
		}catch(e){}
	});
	
	// いいねを集計
    var fbTimer = setInterval(function(){
        if(window.FB && window.FB.Event){
            clearInterval(fbTimer);
            try{
                FB.Event.subscribe('edge.create', function(url) {
                    ga('send', {
                        hitType: 'social',
                        socialNetwork: 'facebook',
                        socialAction: 'like',
                        socialTarget: url
                    });
                });
            }catch(e){ }
        }
    }, 100);

	// tweetを集計
    var twTimer = setInterval(function(){
        if(window.twttr && window.twttr.events){
            clearInterval(twTimer);
            twttr.events.bind('tweet', function (e) {
                try{
                    ga('send', {
                        hitType:'social',
                        socialNetwork: 'twitter',
                        socialAction: 'tweet',
                        socialTarget: document.location.pathname
                    });
                }catch (e){}
            });
        }
    }, 100);
});
