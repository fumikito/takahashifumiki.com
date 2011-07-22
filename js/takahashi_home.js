/**
 * @author Takahashi Fumiki
 * @version 1.2
 */
var Home = new Class({
	//縦書き用コントローラ
	tategaki: null,
	//コンストラクタ
	initialize: function(){
		if(!Browser.Engine.trident){
			//縦書きにする
			this.tategaki = new Tategakizer();
			new Fx.Tween(this.tategaki.devide(document.getElement('.desc'),"。")).start('color','#4D4945');
			//グローバルナビと見出し
			$$('#column1 ol a,#column1 h2,#column2 h3').each(function(elt,index){
				this.tategaki.devide(elt,'');
			},this);
			//各記事のリンク
			$$('#column1 h3 a,#column2 h4 a').each(function(elt,index){
				this.tategaki.make(elt,15);
			},this);
			//カテゴリーへのリンク
			$$('a.cat_top').each(function(elt, index){
				this.tategaki.make(elt, 15);
			}, this);
		}
		
		//目次の高さを揃える
		this.adjustHeight();
		
		document.getElement('.desc').toggleClass('toggle');
		this.makeSlide();
		this.hideIndicator();
	},

	//高さをそろえる
	adjustHeight: function(){
		var valMax = 0;
		var timer = setInterval(function(){
			var uls = $$('#column2 .conBox');
			uls.each(function(elt,index){
				var num = elt.getSize().y;
				if(num > valMax) valMax = num;
			});
			if(valMax > 0){
				uls.each(function(elt,index){
					elt.setStyle('height',valMax);
				});
				clearInterval(timer);
			}
		}, 500);
	},
	
	makeSlide: function(){
		$('floom').floom($$('#floom img'),{
			slidesBase: "",
			sliceFxIn: {
				top: 20
			},
			axis: 'vertical'
		});
	},
	
	hideIndicator: function(){
		/*
		$("indicator").fade("out");
		setTimeout(function(){
			$("indicator").dispose();
		}, 500);
		*/
	}
});