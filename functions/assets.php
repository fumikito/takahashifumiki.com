<?php

// カスタムヘッダーを有効化
add_theme_support('custom-header', array(
	'width' => 1280,
	'height' => 640,
	'uploads' => true,
));

// アイキャッチを有効化
add_theme_support('post-thumbnails');


/**
 * トップページの画像ウィジェットを取得する
 *
 * @return bool|null|WP_Post
 */
function fumiki_header_image(){
	$option = get_option('theme_mods_takahashifumiki', false);
	if(isset($option['header_image_data']) && is_object($option['header_image_data'])){
		$attachment_id = intval($option['header_image_data']->attachment_id);
		if($attachment_id && ($attachment = get_post($attachment_id))){
			return $attachment;
		}
	}
	return false;
}


/**
 * JSやCSSを読み込む
 * @global WP_Styles $wp_styles
 */
function _fumiki_assets(){
	global $wp_styles;
	if(!is_admin()){
		wp_enqueue_style(
			'jquery-ui',
			get_template_directory_uri()."/libs/custom-theme/jquery-ui-1.8.23.custom.css",
			array(),
			fumiki_theme_version()
		); 
		//Font Awesome
		wp_enqueue_style(
			'font-awesome',
			get_template_directory_uri()."/libs/font-awesome/css/font-awesome.css",
			array(),
			fumiki_theme_version(),
			'screen'
		);
		wp_enqueue_style(
			'font-awesome-ie7',
			get_template_directory_uri()."/libs/font-awesome/css/font-awesome-ie7.css",
			array(),
			fumiki_theme_version(),
			'screen'
		);
		$wp_styles->add_data('font-awesome-ie7', 'conditional', 'lt IE 8');


		// TypeSquare
		wp_enqueue_script('type-square', '//typesquare.com/accessor/script/typesquare.js?115ai03FLeQ%3D', array(), null, false);

		// font plus
		//wp_enqueue_script('font-plus', '//webfont.fontplus.jp/accessor/script/fontplus.js?v71w5NbEhVk%3D&box=8pL3Swmt0xo%3D&aa=1', array(), null, false);

		//メインCSS
		wp_enqueue_style(
			'fumiki-style',
			get_template_directory_uri()."/styles/stylesheets/core.css",
			array(),
			fumiki_theme_version(),
			'screen'
		);
		//fancybox
		if(!is_smartphone()){
			$src = WP_DEBUG ? 'fancybox' : 'fancybox.pack';
			wp_enqueue_script(
				'fancybox',
				get_template_directory_uri()."/libs/fancybox/jquery.{$src}.js",
				array('jquery', 'jquery-ui-mouse'),
				'2.1.5',
				true
			);
			wp_enqueue_style(
				'fancybox',
				get_template_directory_uri()."/libs/fancybox/jquery.fancybox.css",
				array(),
				'2.1.5'
			);
		}
		// メインのJS
		if(defined('WP_DEBUG') && WP_DEBUG){
			foreach(array(
				'/includes/ga.js' => 'fumiki-ga',
				'/onload.js' => 'fumiki-core'
			) as $src => $handle){
				wp_enqueue_script(
					$handle,
					get_template_directory_uri().'/styles/js'.$src,
					array('jquery-ui-dialog', 'jquery-masonry'),
					fumiki_theme_version(),
					true
				);
			}
		}else{
			// 上のものをすべて結合したものを読み込み
			wp_enqueue_script(
				'fumiki-core',
				get_template_directory_uri()."/styles/js/onload.min.js",
				array('jquery-masonry', 'jquery-ui-dialog'),
				fumiki_theme_version(),
				true
			);
		}
		//Ajaxの変数を確認
		$endpoint = admin_url('admin-ajax.php');
		if(!is_ssl()){
			$endpoint = str_replace('https://', 'http://', $endpoint);
		}
		wp_localize_script('fumiki-core', 'FumikiAjax', array(
			'endpoint' => $endpoint,
			'nonce' => wp_create_nonce('fumiki_ajax')
		));
		////tmkm-amazonのCSSを打ち消し
		remove_action("wp_head", "add_tmkmamazon_stylesheet");
	}
}
add_action("wp_enqueue_scripts", "_fumiki_assets");


/**
 * CSSを削除する
 * @return void
 */
function _fumiki_dequeue_styles(){
	//wp-pagenaviのCSSを打ち消し
	wp_dequeue_style("wp-pagenavi");
//	wp_dequeue_style('wp-tmkm-amazon');
	//問い合わせページでなければ削除
	if(!is_page('inquiry')){
		wp_dequeue_style('contact-form-7');
	}
	//ログインページでなければ削除
	if(!is_page('login')){
		wp_dequeue_style('theme-my-login');
	}
	//電子書籍ページでなければfancybox削除
	if(is_smartphone()){
		wp_dequeue_style('fancybox');
	}
	//LWP FORMはいらない
	wp_dequeue_style('lwp-form');
}
add_action('wp_print_styles', '_fumiki_dequeue_styles', 10000);


/**
 * Javascriptを削除する
 * @return void
 */
function _fumiki_dequeue_scripts(){
	//問い合わせページでなければ削除
	if(!is_page('inquiry')){
		wp_dequeue_script('contact-form-7');
	}
}
add_action('wp_print_scripts', '_fumiki_dequeue_scripts', 10000);

// なかのひとを出力
add_action('wp_footer', function(){
	if( !WP_DEBUG ){
		$login_id = is_user_logged_in() ? get_current_user_id() : '0';
		echo <<<EOS
<script type='text/javascript'>
<!--
(function() {
	var login = '{$login_id}',
		fpf = true,
		fpn = '__ulfpc';

// DO NOT ALTER BELOW THIS LINE
	var id = 6008410, h = '62fc';
	var rand = rand || Math.floor(Math.random() * 9000000) + 1000000;
	if('http:'==document.location.protocol){var params={id:id,lt:3,h:h,url:document.URL,ref:document.referrer,lg:login,rand:rand,bw:(window.innerWidth?window.innerWidth:(document.documentElement && document.documentElement.clientWidth!=0?document.documentElement.clientWidth:(document.body?document.body.clientWidth:0 ))),bh:(window.innerHeight?window.innerHeight:(document.documentElement && document.documentElement.clientHeight!=0?document.documentElement.clientHeight:(document.body?document.body.clientHeight:0 ))),dpr:(window.devicePixelRatio!=undefined?window.devicePixelRatio:0),sw:screen.width,sh:screen.height,dpr:(window.devicePixelRatio!=undefined?window.devicePixelRatio:0),sb:document.title,guid:'ON'};if(fpf){params.fp=getuid(fpn);}params.eflg=1;var a=document.createElement('a');var lg=document.createElement('img');lg.setAttribute('id','_ullogimgltr');lg.setAttribute('width',1);lg.setAttribute('height',1);lg.setAttribute('alt','');var src='http://le.nakanohito.jp/le/1/?';for(var key in params ) src=src.concat(key+'='+encodeURIComponent(params[key] )+'&');lg.src=src.slice(0,-1);a.setAttribute('href','http://smartphone.userlocal.jp/');a.setAttribute('target','_blank');a.appendChild(lg);var s=document.getElementsByTagName('body')[0];s.appendChild(a);}
	function getuid(key){var arr=[],date=new Date(),exp=new Date();exp.setFullYear(exp.getFullYear()+7);if(document.cookie){arr=document.cookie.split(";");for(var i=0; i<arr.length; i++ ){var str=arr[i].replace(/^\s+|\s+$/g,"");var len=str.indexOf('=');if(str.substring(0,len)==key)return unescape(str.slice(len+1));}}var r=randobet(4);var m=date.getMonth()+1,d=date.getDate(),h=date.getHours(),i=date.getMinutes(),s=date.getSeconds();var num=String(date.getFullYear())+(String(m).length==1?'0':'' )+String(m)+(String(d).length==1?'0':'' )+String(d)+(String(h).length==1?'0':'' )+String(h)+(String(i).length==1?'0':'' )+String(i)+(String(s).length==1?'0':'' )+String(s)+String(r);document.cookie=key+'='+num+'_f; expires='+(new Date(exp).toUTCString())+'; domain='+location.hostname;return num+'_f';}
	function randobet(n){var a='123456789'.split(''),s='';for(var i=0;i<n;i++) s+=a[Math.floor(Math.random() * a.length)];return s;};
})();
//-->
</script>
<noscript>
	<a href='http://smartphone.userlocal.jp/' target='_blank'><img src='http://le.nakanohito.jp/le/1/?id=6008410&h=62fc&lt=3&guid=ON&eflg=1' alt='スマートフォン解析' height='1' width='1' border='0' /></a>
</noscript>
EOS;
	}
}, 100001);

// メディアクエリを読み込む
add_action('wp_head', function(){
	$url = get_template_directory_uri().'/libs/css3-mediaqueries.js';
	echo <<<EOS
<!--[if lt IE 9]>
<script src="{$url}"></script>
<![endif]-->
EOS;
}, 11);
