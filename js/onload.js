jQuery(document).ready(function($){
	//なかのひと
	if($('#nakanohito').length > 0){
		var tag = "<a href='http://nakanohito.jp/'>";
		tag += "<img src='http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=&version=js&refer="+escape(document.referrer)+"&url="+escape(document.URL)+"' border='0' width='96' height='96' />";
		tag += "</a>";
		$('#nakanohito').html(tag);
	}
	//Fancybox
	if($.fancybox && !$('body').hasClass('smartphone')){
		$('.entry a').each(function(index, elt){
			if(elt.href.match(/(jpe?g|gif|png)$/i)){
				elt.rel = 'fancyboxGroup';
				if($(elt).next('wp-caption-text').length > 0){
					elt.title = $(elt).next('wp-caption-text').text();
				}else if($(elt).find('img').length > 0){
					elt.title = $(elt).find('img').attr('alt');
				}
			}
		});
		$('.entry a[rel=fancyboxGroup]').fancybox();
		
		//Ebook reading
		w = 700;
		h = $(window).height() - 80;
		title = true;
		$('.ebook-read-more a').fancybox({
			autoDimensions: false,
			centerOnScroll: true,
			height: h,
			width: w,
			titleShow: title,
			titlePosition: 'inside'
		});
	}
	
	if($('body').hasClass('smartphone')){
		//1px スクロール
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 100);
		var smartPhoneReadContainer = null;
		//画像の修正
		$('.entry .wp-caption').each(function(index, elt){
			$(elt).css('width', 300);
		});
		//iframeの修正
		$('.entry iframe, .entry object').each(function(index, elt){
			var curWidth = $(elt).width();
			if(curWidth > 300){
				var height = $(elt).height() / $(elt).width() * 300;
				$(elt).height(height);
				$(elt).width(300);
				$(elt).find('embed').each(function(i, e){
					$(e).width(300);
					$(e).height(height);
				});
			}
		});
		//電子書籍立ち読み
		$('.ebook-read-more a').click(function(e){
			e.preventDefault();
			//サイズ情報を作成
			var t,b,w,h,pad;
			w = $(window).width();
			h = window.innerHeight ? window.innerHeight : $(window).height();
			t = $(window).scrollTop();
			pad = 40;
			//コンテナ作成
			if(smartPhoneReadContainer == null){
				smartPhoneReadContainer = $(document.createElement('div')).addClass('ebook-more-modal').css({
					top: b + t,
					left: 0,
					width: w,
					height: h - pad,
					paddingTop:pad,
					display:'none'
				});
				//タイトルヘッダー作成
				var title = $(document.createElement('div')).addClass('ebook-more-title sans').text($(this).attr('title'));
				//閉じるボタン作成
				var closeBtn = $(document.createElement('a')).addClass('button').addClass('ebook-more-close').text('×').attr('href', "#");
				//追加
				smartPhoneReadContainer.append(title).append(closeBtn).appendTo($('body'));
				//クリックイベント添付
				closeBtn.click(function(event){
					event.preventDefault();
					smartPhoneReadContainer.css('display','none');
					$('#ebook-more-content').css({
						height: 'auto'
					}).prependTo($('.ebook-more'));
				});
			}
			//スライドイン
			smartPhoneReadContainer.css('top', t).fadeIn();
			//コンテンツを移動
			$('#ebook-more-content').css({
				height: h - pad - 20
			}).prependTo(smartPhoneReadContainer);
		});
		//本棚
		var bookShelf = $('#book-shelf .lwp-table');
		if(bookShelf.length > 0){
			var modalBox = $('<div class="entry"></div>');
			modalBox.dialog({
				autoOpen: false,
				title: '決済情報詳細',
				modal: true,
				position: ['center', 'center'],
				width: 300,
				maxHeight: window.innerHeight - 56,
				resizable: false
			});
			bookShelf.find('tbody tr').click(function(e){
				var html = '<table><tbody>';
				for(i = 0, l =$(this).find('td').length; i < l; i++){
					html += '<tr><th>' + $(this).parents('table').find('thead th:eq(' + i + ')').text() + '</th><td>'+
						    $(this).find('td:eq(' + i + ')').html() + '</td></tr>';
				}
				html += '</tbody></table>';
				modalBox.html(html);
				modalBox.dialog('open');
			});
		}
	}
	//Adminbarの開閉
	if($('body').hasClass('smartphone') || navigator.userAgent.match(/iPad/)){
		$('#navi,#content,#footer,.header').bind('touchend', function(e){
			$('li.menupop').removeClass('hover');
		});
	}
	//Tooltip
	$('.share .prev a, .share .next a').qtip({
		content: {
			text: function(api){
				return $(this).text();
			}
		},
		style: {
			classes: 'ui-tooltip-dark ui-tooltip-shadow ui-tooltip-rounded'
		}
	});
	//ホームの調整
	if($('body.home').length > 0){
		$('.recent-posts-top li:eq(0)').addClass('current');
		var enterNext = function(){
			var cur = $('.recent-posts-top .current');
			var next = cur.next('li');
			if(next.length < 1){
				next = $('.recent-posts-top li:eq(0)');
			}
			setTimeout(function(){
				cur.removeClass('current');
				next.addClass('current');
				cur.fadeOut('normal', function(){
					next.fadeIn('normal', function(){
						enterNext();
					});
				});
			}, 5000);
		};
		enterNext();
	}
	
	//Get Ustream Status
	//リクエストを発行する関数を定義
	var setUstreamStatus = function(){
		$.post(
			FumikiAjax.endpoint,
			{
				action: 'ustream_status',
				nonce: FumikiAjax.nonce
			},
			function(data){
				if(data.status == 1){
					if($('#ustream-badge').length < 1){
						$('body').append('<a id="ustream-badge" href="http://ustre.am/oqqL">Ustream 一人バーベキュー配信中</a>');
						var topBadgeShouldBe = function(){
							return ($(window).scrollTop() + ($(window).height() - 225) / 2);
						};
						$('#ustream-badge').css({
							top: topBadgeShouldBe() + "px"
						}).fadeIn('slow');
						setInterval(function(){
							$('#ustream-badge').fadeTo(1000, 0.4, function(){
								$('#ustream-badge').fadeTo(1000, 1);
							});
						}, 3000);
						//バッジの追従
						var scrolleTimer = null;
						var scrolleBadge = function(e){
							//これまでのタイマーを初期化してリセット
							clearTimeout(scrolleTimer);
							scrolleTimer = setTimeout(function(){
								$('#ustream-badge').animate({
									top: topBadgeShouldBe() + "px"
								}, {
									duration: 'slow'
								});
								clearTimeout(scrolleTimer);
							}, 1000);
						};
						//スクロールイベント
						$(window).scroll(scrolleBadge);
						//リサイズイベント
						$(window).resize(scrolleBadge);
						//バッジのマウスオーバー
						$('#ustream-badge').hover(
							function(e){
								$('#ustream-badge').animate({
									width: '320px'
								},{
									duration: 'fast'
								});
							},
							function(e){
								$('#ustream-badge').animate({
									width: "40px"
								},{
									duration: 'fast'
								});
							}	
						);
					}
				}else{
					if($('#ustream-badge').length > 0){
						$('#ustream-badge').remove();
					}
				}
			}
		);
	};
	
	//初回実行
	setUstreamStatus();
	//タイマー
	setInterval(setUstreamStatus, 120000);
});

//ロードイベント
(function($){
	$.event.add(window, 'load', function(){
		//Twitterウィジェットの調整
		$('.twitter-tweet-rendered').each(function(index, elt){
			$(elt).css('margin', '7px auto !important');
			if($('body').hasClass('smartphone')){
				$(elt).css('width', 'auto !important');
			}
		});
	});
})(jQuery);