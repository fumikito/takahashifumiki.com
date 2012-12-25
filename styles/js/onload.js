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
		$('.entry a[rel=fancyboxGroup]').fancybox({
			 prevEffect		: 'none',
			nextEffect		: 'none',
			closeBtn		: false,
			helpers:  {
				thumbs : {
					width: 50,
					height: 50
				},
				buttons	: {}
			}
		});
		
		//Ebook reading
		w = 700;
		h = $(window).height() - 100;
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
	//Masonry
	var homeColumn, indexColumn;
	function getColumn(){
		var winWidth = $('.margin').width();
		if(winWidth == 1280){
			homeColumn = 4;
			indexColumn = 5;
		}else if(winWidth == 960){
			homeColumn = 3;
			indexColumn = 4;
		}else if(winWidth == 760){
			homeColumn = 2;
			indexColumn = 3;
		}else if(winWidth < 760){
			homeColumn = 1;
			indexColumn = 1;
		}
	}
	getColumn();
	$(window).resize(getColumn);
	if(homeColumn > 1 && $('.desc-box').length > 0){
		$('.desc-box').imagesLoaded(function(){
			$(this).masonry({
				itemSelector: '.box',
				columnWidth: function(containerWidth){
					return containerWidth / homeColumn;
				}
			});
		});
	}
	if($('div.archive').length > 0 && indexColumn > 0){
		$('div.archive').imagesLoaded(function(){
			if(indexColumn > 1){
				$(this).masonry({
					itemSelector: '.archive-box',
					columnWidth: function(containerWidth){
						return containerWidth / indexColumn;
					}
				});
			}
		});
	}
	//スクロール
	function setToTop(){
		var offset;
		if($('.margin').width() < 760){
			//スマートフォン
			offset = window.innerHeight - 50;
		}else{
			//それ以外
			offset = $(window).height() - 100;
		}
		$('#to-top').css('top', offset);
	}
	setToTop();
	$(window).resize(setToTop);
	$('#to-top a').click(function(e){
		e.preventDefault();
		if ( $('html').scrollTop() > 0 ) {
			var targetBody = $('html');
		} else if ( $('body').scrollTop() > 0 ) {
			var targetBody = $('body');
		}
		targetBody.animate({
			scrollTop: 0
		}, 'fast');
	});
	$(window).scroll(function(){
		if($(this).scrollTop() <= 28 + $('#navi').height()){
			if($('#to-top').css('display') != 'none'){
				$('#to-top').fadeOut();
			}
		}else{
			if($('#to-top').css('display') == 'none'){
				$('#to-top').fadeIn();
			}
		}
	});
	if($('body').hasClass('smartphone')){
		//1px スクロール
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 100);
		var smartPhoneReadContainer = null;
		//電子書籍立ち読み
		$('.ebook-read-more a').click(function(e){
			e.preventDefault();
			alert('yea');
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
	//Tooltip
	//TODO: タッチでバイスで挙動を変えるべき
	function toggleTip(e){
		if($(this).hasClass('tip-toggle')){
			$(this).removeClass('tip-toggle');
			$('#tip-container').fadeOut('fast');
		}else{
			var str = '';
			if($(this).attr('title')){
				str = $(this).attr('title').toString();
			}else if($(this).attr('cite')){
				str = $(this).attr('cite').toString();
			}else if($(this).attr('alt')){
				str = $(this).attr('alt').toString();
			}else{
				str = $(this).text().toString();
			}
			if(!str){
				return false;
			}
			$('#tip-container td').text(str);
			var offset = $(this).width() / 2,
				position = $(this).offset(),
				heightBP = ($(window).height() / 2) + $(window).scrollTop(),
				widthBP = $(window).width() / 2,
				left = position.left + (position.left > widthBP ?  -1 * ($('#tip-container').width() + offset) : offset),
				top = position.top + (position.top > heightBP ? -1 * ($('#tip-container').height() + offset) : offset);
			$('#tip-container').css({
				left: left,
				top: top
			}).fadeIn('fast');
			$(this).addClass('tip-toggle');
			return true;
		}
	}
	if(document.ontouchstart !== undefined){
		//タッチイベントがあれば、タッチでバイス
		$('.tip, abbr, acronym, q').click(toggleTip);
	}else{
		//違ったらホバー
		$('.tip, abbr, acronym, q').hover(toggleTip);
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

//ロードイベントでTwitterウィジェットを調整する
(function($){
	$.event.add(window, 'load', function(){
		//Twitterウィジェットの調整
		$('.twitter-tweet-rendered').each(function(index, elt){
			$(elt).attr('style', '').removeClass('twitter-tweet-rendered').addClass('fumiki-twitter-rendered');
		});
	});
})(jQuery);