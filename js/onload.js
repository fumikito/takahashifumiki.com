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
	if($.fancybox){
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
});