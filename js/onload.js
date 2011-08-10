jQuery(document).ready(function($){
	//なかのひと
	if($('#nakanohito').length > 0){
		var tag = "<a href='http://nakanohito.jp/'>";
		tag += "<img src='http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=&version=js&refer="+escape(document.referrer)+"&url="+escape(document.URL)+"' border='0' width='96' height='96' />";
		tag += "</a>";
		$('#nakanohito').text(tag);
	}
	//スライドアニメーション
	$('#navi').css('height', 'auto');
	var navHeight = $('#navi').height();
	$('#navi').css('height', 0);
	$('#header .button').click(function(e){
		e.preventDefault();
		console.log(e, $(this).attr("class"), navHeight);
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
				console.log(elt, tip.offset());
				$(elt).blur(function(e){
					
				});
				$(elt).focus(function(e){
					
				});
				break;
			default:
				
				break;
		}
	});
});