/**
 * @author Takahashi Fumiki
 * @version 1.2
 */

window.addEvent("domready", function(event){
	var single = new Single();
});


var Single = new Class({
	theme_dir: '',

	/**
	 * コンストラクタ
	 */
	initialize: function(){
		//テンプレートディレクトリを取得
		var str;
		$$("script").each(function(elt, index){
			if(elt.src.match(/takahashi_single\.js/)){
				str = elt.src.split("js/takahashi_single");
				return false;
			}
		});
		this.theme_dir = str[0];
		
		//Windowのリサイズイベントを取得
		var body = document.getElement('body');
		if(body.hasClass('n_single') && body.hasClass('post'))
			window.addEvent('resize',this.windowAdjust);
		//FIXME: コードフォーマッターを適用
		this.codeFormatter();
		
		//Multiboxの対象を探す
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
		
		this.linkFormat();
		
		//Flashが埋め込まれていたら埋め込み
		if($('fumiki_flash_container'))
			this.flash_embed();
		
		//スムーススクロール初期化
		new SmoothScroll();
		
		//セールタイマーを実行
		if($('sale-timer'))
			this.sale_timer();
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
				width:'1160px',
				padding: '0 20px 0',
				margin:'0 auto'
			});
		}else if(footer.getParent().getSize().x < 900){
			footer.setStyles({
				width: '860px',
				padding: '10px 20px 0',
				margin: '0 auto'
			});
			footer.getParent().setStyle("width",'900px');
		}else{
			footer.setStyles({
				width:'auto',
				padding:'10px 20px 0',
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
	 * MultiBoxの初期化
	 * @param {Object} elts
	 */
	make_slimBox: function(elts){
		//rel="shadowbox"を追加
		elts.each(function(elt,index){
			elt.addClass('multibox');
			if(elt.getElement('img')){
				elt.title = elt.getElement('img').alt;
			}
		});
		var multibox = new MultiBox("multibox",{
		  useOverlay: true
		});
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
	},
	
	/**
	 *  リンクを装飾する
	 */
	linkFormat: function(){
		$$('.entry>p>a').each(function(elt, index){
			if(!elt.getElement("img")){
				var ext = elt.href.match(/\.[a-z]+$/);
				//拡張子別にクラスを設定
				if(ext)
					switch(ext[0]){
						case ".zip":
						case ".gzip":
							elt.addClass("zip");
							break;
						case ".pdf":
							elt.addClass("pdf");
							break;
						case ".epub":
							elt.addClass("epub");
							break;
					}
				//外部か否か
				if(elt.href && !elt.href.match(/^#/) && !elt.href.match(/^http:\/\/takahashifumiki\.com/))
					elt.addClass("external");
			}
		});
	},
	
	/*
	 * タイマーのカウントダウン
	 */
	sale_timer: function(){
		var container = $('sale-timer');
		var limit = container.getElement('input').value;
		var countDown = function(hour, minuit, second){
			var diff = limit.toInt() - Math.floor(new Date().getTime() / 1000);
			if(diff > 0){
				//残り時間があれば表示を更新
				var left_hour = (diff > 3600 * 100) ? Math.floor(diff / 3600) : ("0" + Math.floor(diff / 3600)).slice(-2);
				hour.set('text', left_hour);
				minuit.set('text', ("0" + Math.floor(diff % 3600 / 60)).slice(-2));
				second.set('text', ('0' + diff % 60).slice(-2) );
			}else{
				//なければセールを終了
				$clear(intervalID);
				//表示を0にする
				hour.set('text', "00");
				minuit.set('text', "00");
				second.set('text', "00");
				//ページをリフレッシュ
				window.location.reload();
			}
		};
		var intervalID = countDown.periodical(1000, limit, container.getElements('span'));
	}
});