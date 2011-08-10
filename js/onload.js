jQuery(document).ready(function($){
	//スライドアニメーション
	$('#nav').css('height', 'auto');
	var navHeight = $('#nav').height();
	$('#nav').css('height', 0);
	$('#header .button').click(function(e){
		e.preventDefault();
		console.log(e, $(this).attr("class"), navHeight);
		if($(this).hasClass('toggle')){
			$(this).removeClass('toggle');
			$('#nav').animate({
				height: 0
			});
		}else{
			$(this).addClass('toggle');
			$('#nav').animate({
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