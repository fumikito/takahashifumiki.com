<?php
/**
 * JSやCSSを読み込む
 */
function _fumiki_assets(){
	if(!is_admin()){
		//メインCSS
		wp_enqueue_style(
			'qtip',
			get_template_directory_uri().'/css/jquery.qtip.min.css',
			array(),
			'2.0'
		);
		wp_enqueue_style(
			'jquery-ui',
			get_template_directory_uri()."/css/custom-theme/jquery-ui-1.8.23.custom.css",
			array(),
			FUMIKI_VERSION
		);
		wp_enqueue_style(
			'fumiki-style',
			get_template_directory_uri()."/styles/stylesheets/core.css",
			array(),
			FUMIKI_VERSION,
			'screen'
		);
		//JS
		wp_enqueue_script(
			'qtip',
			get_template_directory_uri().'/js/jquery.qtip.min.js',
			array('jquery'),
			'2.0',
			true
		);
		wp_enqueue_script(
			'fumiki-core',
			get_template_directory_uri()."/js/onload.js",
			array('jquery', 'jquery-ui-dialog'),
			FUMIKI_VERSION,
			true
		);
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
	wp_dequeue_style('wp-tmkm-amazon');
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
	//スマートフォンならFancybox削除
	if(is_smartphone()){
		wp_deregister_script('instapress');
	}
}
add_action('wp_print_scripts', '_fumiki_dequeue_scripts', 10000);