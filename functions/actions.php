<?php
/**
 * @package takahashifumiki
 */

/**
 * wp_headで出力する
 * @return void
 */
function _fumiki_head(){
	global $wpdb;
	//Facebook用のメタ情報
	if(is_front_page() || is_singular()){
		$title = is_singular() ? wp_title('|', false, "right").get_bloginfo('name') : get_bloginfo('name');
		$url = is_singular() ? get_permalink() : get_bloginfo('url');
		$image = get_bloginfo('template_directory')."/img/facebook-top.jpg";
		if(is_singular()){
			$images = get_children("post_parent=".get_the_ID()."&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1");
			if(!empty($images)){
				$image = wp_get_attachment_image_src(current($images)->ID, 'medium');
				$image = $image[0];
			}
		}
		$type = is_singular() ? 'article' : "website";
		if(get_post_type() == 'ebook'){
			$type = 'book';
		}
		$desc = is_singular() ? get_the_excerpt() : get_bloginfo('description');
		$desc = str_replace("\n", "", $desc);
		echo <<<EOS
<meta property="og:title" content="{$title}"/>
<meta property="og:url" content="{$url}" />
<meta property="og:image" content="{$image}" />
<meta property="og:description" content="{$desc}" />
<meta name="description" content="{$desc}" />
<meta property="og:type" content="{$type}" />
<meta property="og:site_name" content="高橋文樹.com"/>
<meta property="og:locale" content="ja_JP" />
<meta property="fb:admins" content="1034317368" />
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'ja'}
</script>
EOS;
	}
	if(is_smartphone()){
		$dir = get_bloginfo('template_directory');
		echo <<<EOS
<meta name="Viewport" content="width=640" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="{$dir}/img/home.png" />
<link rel="apple-touch-startup-image" href="{$dir}/img/start-up.png" />
EOS;
	}
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
	if(!is_admin()){
		show_admin_bar(false);
		wp_deregister_script( 'admin-bar' );
		wp_deregister_style( 'admin-bar' );
		add_filter('show_admin_bar', '__return_false');
		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
		remove_action('wp_footer','wp_admin_bar_render',1000);
	}
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

/**
 * ウィジェットを登録する
 */
function _fumiki_register_widget(){
	register_widget('Fumiki_Facebook_Like');
}
add_action('widgets_init', '_fumiki_register_widget');
get_template_part("widgets/facebook");


/**
 * flashプラグインの後方互換
 * @return str
 */
function flash_converter($atts,$content = null){
        $arr = shortcode_atts(array(
                0 => null,
                'w' => null,
                'h' => null
        ),$atts);
        $str = '<div id="fumiki_flash_container">'.
                   '<span style="display:none">';
        $str .= $arr[0];
        if(!is_null($arr['w'])) $str .= '::'.$arr['w'];
        if(!is_null($arr['h'])) $str .= '::'.$arr['h'];
        $str .= '</span>'.
                           '<noscript>'.
                           '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
        if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
        if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
        $str .= '>'.
                '<param name="movie" value="'.$arr[0].'" />'.
                        '<!--[if !IE]>-->'.
                        '<object type="application/x-shockwave-flash" data="'.$arr[0].'"';
        if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
        if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
        $str .= '>'.
                '<!--<![endif]-->'.
                        '<!--[if !IE]>-->'.
                        '</object>'.
                        '<!--<![endif]-->'.
                        '</object>'.
                        '</noscript>'.
                        '</div>';
        return $str;
}
add_shortcode('flash','flash_converter');


/**
 * Ustreamのステータスを返す
 * @return void
 */
function _fumiki_ustream_status(){
	if(wp_verify_nonce($_REQUEST['nonce'], 'fumiki_ajax')){
		$res = is_on_air() ? 1 : 0;
		header('Content-Type: application/json');
		echo json_encode(array('status' => $res));
		die();
	}
}
add_action('wp_ajax_ustream_status', '_fumiki_ustream_status');
add_action('wp_ajax_nopriv_ustream_status', '_fumiki_ustream_status');