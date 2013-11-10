<?php
/**
 * @package takahashifumiki
 */

/**
 * wp_headで出力する
 * @return void
 */
function _fumiki_head(){
	//Facebook用のメタ情報
	if(is_front_page() || is_singular()){
		$title = is_front_page() ? get_bloginfo('name') : wp_title('|', false, "right").get_bloginfo('name') ;
		$url = is_front_page() ?  trailingslashit(home_url('/', 'http')) : get_permalink();
		$image = get_template_directory_uri()."/styles/img/facebook-top.jpg";
		if(!is_front_page()){
			$images = get_children("post_parent=".get_the_ID()."&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1");
			if(!empty($images)){
				$image = wp_get_attachment_image_src(current($images)->ID, 'medium');
				$image = $image[0];
			}
		}
		$type = is_front_page() ? "website" : 'article';
		if(get_post_type() == 'ebook'){
			$type = 'book';
		}
		$desc = str_replace("\n", "", is_front_page() ? get_bloginfo('description') : get_the_excerpt());
		$dir = get_stylesheet_directory_uri();
		echo <<<EOS
<!-- Open Graph -->
<meta property="og:locale" content="ja_jp" />
<meta property="og:title" content="{$title}"/>
<meta property="og:url" content="{$url}" />
<meta property="og:image" content="{$image}" />
<meta property="og:description" content="{$desc}" />
<meta property="og:type" content="{$type}" />
<meta property="og:site_name" content="高橋文樹.com"/>
<meta property="fb:admins" content="1034317368" />
<!-- Twitter Card -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@takahashifumiki" />
<meta name="twitter:url" content="{$url}" />
<meta name="twitter:title" content="{$title}" />
<meta name="twitter:description" content="{$desc}" />
<meta name="twitter:image" content="{$image}" />
<meta name="description" content="{$desc}" />
EOS;
	}
	echo <<<EOS
<!-- ViewPort -->
<meta name="Viewport" content="width=device-width, initial-scale=1.0" />
<!-- Mobile Device -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="{$dir}/styles/img/home.png" />
<link rel="apple-touch-startup-image" href="{$dir}/styles/img/start-up.png" />
EOS;
}


add_action('wp_head', '_fumiki_head', 0);
//JetpackのOGPをオフにする
remove_action( 'wp_head' , 'jetpack_og_tags' );

/**
 * faviconなどを書き出す 
 */
function _fumiki_identity(){
	$dir = get_template_directory_uri();
	echo <<<EOS
<link rel="shortcut icon" href="{$dir}/styles/img/favicon.ico" />
<meta name="copyright" content="copyright 2008 takahashifumiki.com" />
EOS;
}
add_action('wp_head', '_fumiki_identity');



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
 * ログイン時間を記録する
 * @param string $login
 */
function _fumiki_last_login($login) {
    global $user_ID;
    $user = get_userdatabylogin($login);
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login','_fumiki_last_login');

/**
 * ウィジェットを登録する
 */
function _fumiki_register_widget(){
	get_template_part("widgets/facebook");	
	register_widget('Fumiki_Facebook_Like');
	get_template_part('widgets/ebook');
	register_widget('Fumiki_eBook');
	get_template_part('widgets/recent');
}
add_action('widgets_init', '_fumiki_register_widget');


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


