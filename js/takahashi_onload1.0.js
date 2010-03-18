/**
 * @author Takahashi Fumiki
 */

window.addEvent('domready',takahashi_init);

function takahashi_init(){
	//モードを取得
	var str = $('js_initializer').src;
	var mode = str.substr(str.lastIndexOf('?mode=') + 6,15);

	//ホームだったら
	if(mode == 'home') new Home();
	//通常シングルだったら
	else if(mode.match(/n_single/) || mode.match(/t_single/)) new Single();

	//全ページ共通アクション
	footer_colorize();
	searchboxUtil();
}

var Home = new Class({
	//縦書き用コントローラ
	tategaki: null,
	
	//コンストラクタ
	initialize: function(){
		//縦書きにする
		this.tategaki = new Tategakizer();
		new Fx.Tween(this.tategaki.make(document.getElement('.desc'),"。")).start('color','#4D4945');
		
		//目次の高さを揃える
		this.adjustHeight();
		
		document.getElement('.desc').toggleClass('toggle');
		//this.makeSlide();
	},

	//高さをそろえる
	adjustHeight: function(){
		var uls = $$('#column2 .conBox ul')
		var valMax = 0;
		uls.each(function(elt,index){
			var num = elt.getSize().y;
			if(num > valMax) valMax = num;
		});
		uls.each(function(elt,index){
			elt.setStyle('height',valMax);
		});
	},
	
	makeSlide: function(){
		var container = null, sources = null;
		var options = {
			'panelHeight': 35,
			'panelWidth': 70,
			'interval': 3000,
			'duration': 800,
			'zIndex': 9000,
			'onStart': function() {
				$("container").getElement("p.information").set("html", "now loading....");
			},
			'onPreload': function(images) {
				$("container").getElement("p.information").set("html", images.length.toString() + "loaded");
			},
			'onChange': function(image) {
				$("container").getElement("p.information").set("html", image.title + " : " + image.alt);
			}
		};
		var container	= $("gradually-container");
		var sources		= $("gradually-container").getElements("li img");
		new Gradually(container, sources, options);
	}
});

var Single = new Class({
	theme_dir: '',

	//コンストラクタ
	initialize: function(){
		var str = $('js_initializer').src.split('js/takahashi_onload');
		this.theme_dir = str[0];
		//if(window.getSize().x > 1200) alert('でかい');
		if($$('.n_single')) window.addEvent('resize',this.windowAdjust);
		this.codeFormatter();
		var jpg = $$('.entry a[href$=jpg]');
		var jpeg = $$('.entry a[href$=jpeg]');
		var gif = $$('.entry a[href$=gif]');
		var png = $$('.entry a[href$=png]');
		var photos = jpg.concat(jpeg,gif,png);
		if (photos.length > 0) {
			this.make_slimBox(photos);
		}
		//this.hatena();
		//this.google();
		if($('fumiki_flash_container')) this.flash_embed();
		new SmoothScroll();
	},

	//センター寄せ
	windowAdjust: function(){
		var body = $$(".n_single #wrapper")[0];
		if(body){
			if(window.getSize().x > 1200 ){
				body.setStyles({
					width:'1200px',
					margin:'0 auto'
				});
			}else if(window.getSize().x < 900){
				body.setStyles({
					width:'900px',
					margin:'0 auto'
				});
			}else{
				body.setStyles({
					width:'auto',
					magrgin:'0 50px'
				});
			}
		}
		var footer = $('footer');
		if(footer.getParent().getSize().x > 1200){
			footer.setStyles({
				width:'1200px',
				margin:'0 auto'
			});
		}else if(footer.getParent().getSize().x < 900){
			footer.setStyles({
				width: '900px',
				margin: '0 auto'
			});
			footer.getParent().setStyle("width",'1000px');
		}else{
			footer.setStyles({
				width:'auto',
				margin: '0 auto'
			});
			footer.getParent().setStyle('width','auto');
		}
	},

	/**
	 * コードフォーマット
	 */
	codeFormatter: function(){
		var pres = $$('.entry pre[class=""]');
		pres.each(function(elt,index){
			if(elt.getProperty())var str = elt.get('text').replace(/</g,'&lt;');
			str = str.replace(/>/g,'&gt;');
			str = str.replace(/"(.*?)"/g,'<span class="quote">&quot;$1&quot;</span>');
			str = str.replace(/'(.*?)'/g,'<span class="quote">&lsquo;$1&rsquo;</span>');
			str = str.replace(/\/\/(.*)\n/g,'<span class="notation">//$1</span>\n');
			str = str.split("\n");
			var newTag = '<table cellpadding="0" cellspacing="0">';
			str.each(function(td,idx){
				if(idx % 2 == 1) newTag += '<tr class="even">';
				else newTag += '<tr>';
				newTag += '<th>' + (idx + 1) + '</th><td>' + td + '</tr></td>';
			});
			newTag += '</table>';
			var div = new Element('div');
			div.toggleClass('code-format');
			div.set('html',newTag);
			div.inject(elt,'before');
			elt.dispose();
		});
	},

	hatena: function(){
		var app = this.theme_dir + 'web-app/?mode=hatena';
		var req = new Request({
			url: app,
			method: 'get',
			link: 'cancel',
			onSuccess: function(txt,xml){
				var str = $(xml).getElements('item');
				for(i=0;i<5;i++){
					var tit = str[i].getElement('title').get('text');
					var href = str[i].getElement('link').get('text');
					var tags = '<li><a href="' + href + '">' + tit + '</a></li>';
				}
			},
			onFailure: function(xhr){

			}
		});
		req.send();
	},

	google: function(){
		var app = this.theme_dir + 'web-app/?mode=gblog';
		var req = new Request.JSON({
			url: app,
			method: 'get',
			link: 'cancel',
			onSuccess: function(reqJson,reqText){
				for(i=0;i<5;i++){
					//alert(reqJson.responseData.results[i].postUrl);
				}
			},
			onFailure: function(xhr){
			}
		});
		req.send();
	},

	/**
	 * スリムボックスのチェック
	 * @param {Object} elts
	 */
	make_slimBox: function(elts){
		//rel="shadowbox"を追加
		elts.each(function(elt,index){
			elt.rel = 'slimbox';
			if(elt.getElement('img')){
				elt.title = elt.getElement('img').alt;
			}
		});
		//CSS読み込み
		var css = new Asset.css(this.theme_dir + 'js/slimbox/slimbox.css');
		//Slimbox読み込み
		var sb = new Asset.javascript(this.theme_dir + 'js/slimbox/slimbox.js');
		sb.addEvent('load',this.slimBox_init);
	},

	/**
	 * スリムボックスの初期化
	 */
	slimBox_init: function(){
		$$('a[rel^=slimbox]').slimbox({loop:true});
	},

	/**
	 * フラッシュ埋め込みの後方互換
	 */
	flash_embed: function(){
		var cont = $('fumiki_flash_container');
		var params = cont.getElement('span').get('text');
		params = params.split('::');
		var option = {};
		option.container = cont;
		if(params[1]) option.width = params[1];
		if(params[2]) option.height = params[2];
		new Swiff(params[0],option);
	}
});



/*-------------------------------------
 * 共通アクション
 */

/**
 * リンクのホバーアクション
 * @return
 */
function footer_colorize(){
	$$('#footer li a').each(function(elt,index){
		var fx = new Fx.Morph(elt,{link:'cancel'});
		elt.addEvent('mouseenter',(function(){
			this.start({
				color:["#00A0E9"],
				backgroundColor:["#cee8f4"],
				paddingLeft:[10]
			});
		}).bindWithEvent(fx));
		elt.addEvent('mouseleave',(function(){
			this.start({
				color:["#cee8f4"],
				backgroundColor:["#00A0E9"],
				paddingLeft: [0]
			});
		}).bindWithEvent(fx));
	});
}


/**
 * 検索フォームの使い勝手を変える
 * @return
 */
function searchboxUtil (){
	var box = $("s");
	if(box){
		box.addEvents({
			'focus': function(e){
				e.target.value = "";
			},
			'blur': function(e){
				box.value = String.fromCharCode(8811) + "検索語句";
			}
		});
	}
}