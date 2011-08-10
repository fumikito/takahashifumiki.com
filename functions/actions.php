<?php
/**
 * @package takahashifumiki
 */

/**
 * wp_headで出力する
 * @return void
 */
function _fumiki_head(){
	
	?>
<meta property="fb:admins" content="1034317368" />
	<?php
}
add_action('wp_head', '_fumiki_head', 0);

/**
 * JSやCSSを読み込む
 */
function _fumiki_assets(){
	if(!is_admin()){
		//メインCSS
		wp_enqueue_style(
			'fumiki-style',
			get_bloginfo('template_directory')."/style.css",
			array(),
			FUMIKI_VERSION
		);
		//JS
		//wp_enqueue_script('mootools-core',"https://ajax.googleapis.com/ajax/libs/mootools/1.3.2/mootools-yui-compressed.js",array(),"1.3.2",ture);
		wp_enqueue_script(
			'fumiki-core',
			get_bloginfo('template_directory')."/js/onload.js",
			array('jquery'),
			FUMIKI_VERSION,
			true
		);
	}
}
add_action("wp_enqueue_scripts", "_fumiki_assets");

/**
 * メニューを登録する
 */
function _fumiki_menu(){
	register_nav_menus(array(
		'main-pages' => 'メインページ',
		'top-page' => 'トップページ'
	));
}
add_action("init", "_fumiki_menu");

/**
 * アドミンバーを消す
 */
function _fumiki_remove_adminbar(){
	show_admin_bar(false);
	wp_deregister_script( 'admin-bar' );
	wp_deregister_style( 'admin-bar' );
	add_filter('show_admin_bar', '__return_false');
	remove_action( 'wp_head', 'wp_admin_bar_header' );
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
	remove_action('wp_footer','wp_admin_bar_render',1000);
}
add_action('init', "_fumiki_remove_adminbar");

/**
 * ログイン時間を記録する
 * @param string $login
 */
function _fumiki_last_login($login) {
    global $user_ID;
    $user = get_userdatabylogin($login);
    update_usermeta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login','_fumiki_last_login');