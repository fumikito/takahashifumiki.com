<?php
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
			wp_enqueue_script(
				'fancybox',
				get_template_directory_uri()."/styles/js/jquery.fancybox-ck.js",
				array('jquery', 'jquery-ui-mouse'),
				'2.1.3',
				true
			);
			wp_enqueue_style(
				'fancybox',
				get_template_directory_uri()."/styles/stylesheets/fancybox.css",
				array(),
				'2.1.3'
			);
		}
		//JS
		wp_enqueue_script(
			'fumiki-core',
			get_template_directory_uri()."/styles/js/onload-ck.js",
			array('jquery', 'jquery-ui-dialog'),
			fumiki_theme_version(),
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
}
add_action('wp_print_scripts', '_fumiki_dequeue_scripts', 10000);