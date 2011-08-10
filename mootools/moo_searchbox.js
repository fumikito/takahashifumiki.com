/**
 * @author f-takahashi
 */

/*検索ボックスの使用*/
 window.addEvent('domready',searchbox);

function searchbox(){
	var s = document.getElement('script').src.split('js');
	var app = s[0] + "web-app/?mode=gsearch&opt=site&q=";

	var box = $('google-input');

	box.addEvent('keydown',function(evt){
		if(evt.key == 'enter'){
			var query = encodeURIComponent(evt.target.value + " site:takahashifumiki.com");
			var req = new Request.JSON({
				url: app + query,
				method: 'get',
				link: 'cancel',
				onComplete: function(){
					var li = new Element('li');
					li.set('html','<p>読み込み中...</p>');
					li.inject($('result_list'));
				},
				onSuccess: function(reqJson,reqText){
					var wrapper = $('result_list');
					wrapper.empty();
					if(reqJson.responseData.results.length < 1){
						var li = new Element('li');
						li.set('text',"見つかりませんでした");
						li.inject(wrapper);
					}else{
						for(i = 0,l = reqJson.responseData.results.length; i < l; i++){
							var li = new Element('li');
							var header = new Element('a',{
								href: reqJson.responseData.results[i].unescapedUrl
							});
							header.set('html',reqJson.responseData.results[i].title);
							header.inject(li);
							var desc = new Element('p');
							desc.set('html',reqJson.responseData.results[i].content);
							desc.inject(li);
							if(i == l-1) li.toggleClass('last');
							li.inject(wrapper);
						}
					}
				},
				onFailure: function(xhr){
					var li = new Element('li');
					li.set('html','<p>エラーが発生しました。<br>' + xhr + '</p>');
					li.inject($('result_list'));
				}
			});
			req.send();
			$('result_box').empty();
			var ul = new Element('ul',{
				id:'result_list',
				styles: {
					opacity:0.9
				}
			});
			ul.inject($('result_box'),'bottom');
		};
	});
	box.addEvent('focus',function(evt){
		evt.target.value = "";
		document.getElement('#google-search-box span').fade('in');
	});

	box.addEvent('blur',function(evt){
		evt.target.value = "キーワードを入れてください";
		if($('result_list')) $('result_list').fade('out');
		document.getElement('#google-search-box span').fade('out');
	});
}


/*スムーススクロール*/
window.addEvent('domready',smoothScroll);

function smoothScroll(){
	var mySmoothScroll = new SmoothScroll();
}

/*トップへのアンカー*/
window.addEvent('domready',scrollToTop);

function scrollToTop(){
	if(!$chk($('toTop')))return false;
	var topAnchor = $('toTop');

	var fx = new Fx.Morph(topAnchor,{duration:'long',transition:Fx.Transitions.Sine.easeInOut,link:'cancel'});

	//取り敢えず、フェードインしながら開始位置に移動
	var rightTop = $('menu').getCoordinates().bottom;
	fx.start({
		'top':[rightTop],
		'opacity':[0,1]
	});

	//定期的に監視して、移動する式を実行
	var IntervalId = anchorScroller.periodical(3000,topAnchor,rightTop);

}

function anchorScroller(rightTop){
	//windowのスクロール量を取得
	var scrollHeight = window.getScroll().y;

	//アニメーション生成
	var fx = new  Fx.Morph(this,{duration:'long',transition:Fx.Transitions.Sine.easeInOut,link:'cancel'});

	if(rightTop >= scrollHeight){
		fx.start({
			top:rightTop
		});
	}else{
		fx.start({
			top:scrollHeight
		});
	}
}
