jQuery(document).ready(function($){
	//なかのひと
	if($('#nakanohito').length > 0){
		var tag = "<a href='http://nakanohito.jp/'>";
		tag += "<img src='http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=&version=js&refer="+escape(document.referrer)+"&url="+escape(document.URL)+"' border='0' width='96' height='96' />";
		tag += "</a>";
		$('#nakanohito').html(tag);
	}
	//スライドアニメーション
	$('#navi').css('height', 'auto');
	var navHeight = $('#navi').height();
	$('#navi').css('height', 0);
	$('#header .button').click(function(e){
		e.preventDefault();
		if($(this).hasClass('toggle')){
			$(this).removeClass('toggle');
			$('#navi').animate({
				height: 0
			});
		}else{
			$(this).addClass('toggle');
			$('#navi').animate({
				height: navHeight
			});
		}
	});
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
		$('.ebook-read-more a').click(function(e){
			e.preventDefault();
			//サイズ情報を作成
			var t,b,w,h,pad;
			w = $(window).width();
			h = window.innerHeight ? window.innerHeight : $(window).height();
			t = $(window).scrollTop();
			b = h + t;
			pad = 40;
			//コンテナ作成
			var container = $(document.createElement('div'));
			container.addClass('ebook-more-modal').css({
				top: b,
				left: 0,
				width: w,
				height: h - pad,
				paddingTop:pad
			});
			//コンテンツをコピー
			var content = $('#ebook-more-content').clone(false).attr('id', '').css({
				height: h - pad - 20
			});
			//タイトルヘッダー作成
			var title = $(document.createElement('div')).addClass('ebook-more-title sans');
			title.text($(this).attr('title'));
			//閉じるボタン作成
			var closeBtn = $(document.createElement('a'));
			closeBtn.addClass('button').addClass('ebook-more-close').text('×').attr('href', "#");
			//追加してスライドイン
			container.append(content).append(title).append(closeBtn).appendTo($('body')).animate({
				top: t
			}, 300, 'linear', function(e){
				closeBtn.click(function(e){
					e.preventDefault();
					container.remove();
				});
			});
		});
	}
	
	//Tooltip
	var originalTip = document.createElement('div');
	$(originalTip).addClass('tooltip');
	$('.tooltip').each(function(index, elt){
		var getTip = function(element){
			var alt = element.alt;
			if(alt == undefined || alt == ''){
				alt = element.title;
			}
			var t = $(originalTip).clone();
			t.text(alt);
			t.css({
				position: 'absolute',
				display: 'none'
			});
			return t;
		}
		switch(elt.nodeName.toLowerCase()){
			case 'input':
				var tip = getTip(elt);
				tip.css({
					top: $(elt).scrollTop() * $(elt).height() + 10,
					left: $(elt).scrollLeft()
				});
				$('body').append(tip);
				$(elt).blur(function(e){
					
				});
				$(elt).focus(function(e){
					
				});
				break;
			default:
				
				break;
		}
	});
	//ホームの調整
	if($('.sidebar-home').length > 0){
		$('.sidebar-home .widget').each(function(index, elt){
			if(index % 3 == 0){
				$(elt).addClass('clrL');
			}
		});
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