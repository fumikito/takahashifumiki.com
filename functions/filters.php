<?php
/**
 * @package takahashifumiki
 */


/**
 * MooToolsの場合だけテンプレート変更
 */
add_filter( 'template_include', function( $template ){
	if ( is_singular() && in_category(47) ) {
		$template = get_template_directory().'/mootools/moo.php';
	}
	return $template;
} );

/**
 * タイトルを変更する
 * @param string $title
 * @param string $sep
 * @param string $seplocation
 * @return string
 */
function _fumiki_meta_title($title, $sep = '|', $seplocation = 'right'){
	if(is_singular('ebook')){
		$title .= '電子書籍 '.$sep." ";
	}elseif(is_post_type_archive('ebook')){
		$title = '電子書籍一覧 '.$sep." ";
	}
	if(is_singular('events')){
		$title .= 'イベント '.$sep." ";
	}elseif(is_post_type_archive('events')){
		$title = 'イベント一覧 '.$sep." ";
	}
    global $wp_query;
    if( ($quote = $wp_query->get('quote')) ){
        if( 'all' == $quote ){
            $title = '好きな言葉 '.$sep." ";
        }else{
            $title .= '引用 '.$sep." ";
        }
    }
	return $title;
}
add_filter('wp_title', '_fumiki_meta_title');

/**
 * Nginx Cache ControllerのURLを変更
 *
 * @filter nginxchampuru_get_reverse_proxy_key
 * @param string $url
 * @return string
 */
add_filter('nginxchampuru_get_reverse_proxy_key', function($url){
    $mobile =  (int)wp_is_mobile();
    $url_key = preg_replace('/(https?:)\/\//u', '$1//'.$mobile.'.', $url);
    return md5($url_key);
});


/**
 * プロフィール編集画面にコンタクトフィールドを追加する
 * 
 * @param array $contactmethods
 * @return array
 * @author WP Beginners
 * @url http://www.wpbeginner.com/wp-tutorials/how-to-display-authors-twitter-and-facebook-on-the-profile-page/
 */
function _fumiki_profile_fields( $contactmethods ) {
	//いらないものを削除
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	//新しいものを追加
	$original_contactmethods = array(
		"twitter" => "Twitter"
	);
	foreach($original_contactmethods as $key => $val)
		$contactmethods[$key] = $val;
	return $contactmethods;
}
add_filter('user_contactmethods','_fumiki_profile_fields',11,1);

/**
 * bodyクラスを付加する
 *
 * @param array $classes
 * @return array
 */
add_filter('body_class', function($classes){
	if( is_page('facebook') ){
		$classes[] = 'facebook';
	}
	if ( 'ja' !== fumiki_current_language() ) {
		$classes[] = 'in-english-please';
	}
	return $classes;
});


/**
 * 自分のサイトにpingが飛ばないようにする
 *
 * @param array $links
 */
add_action( 'pre_ping', function( &$links ) {
	foreach ( $links as $index => $link ){
		if ( preg_match('/https?:\/\/takahashifumiki\.(com|info)/u', $link) ){
			unset($links[$index]);
		}
	}
});



/**
 * SSLのコンテンツが表示されているときにsrcなどを修正する
 *
 * @param string $content
 * @return string 
 */
function _fumiki_ssl_content($content){
	$upload_dir = wp_upload_dir();
	$upload_dir_url = $upload_dir['baseurl'];
	if(is_ssl()){
		$upload_dir_ssl_url = str_replace('http://', 'https://s.', $upload_dir_url);
		$content = str_replace($upload_dir_url, $upload_dir_ssl_url, $content);
	}else{
		$upload_dir_cdn_url = str_replace('http://', 'http://s.', $upload_dir_url);
		$content = str_replace($upload_dir_url, $upload_dir_cdn_url, $content);
	}
	return $content;
}
add_filter('the_content', '_fumiki_ssl_content');

/**
 * SSLページですべてのリンクがHTTPSになってしまうのを修正する
 *
 * @param string $url
 * @param string $path
 * @param string $orig_scheme
 * @return string
 */
function _fumiki_home_url($url, $path = '', $orig_scheme = 'http'){
	if(is_ssl() && !is_admin() && $orig_scheme != 'http' && strpos($path, 'wp-content') === false){
		$url = str_replace('https:', 'http:', $url);
	}
	return $url;
}
add_filter('home_url', '_fumiki_home_url', 10, 2);

/**
 * テーマディレクトリのURLをCDN対応にする
 *
 * @param string $url
 * @return string
 */
function _fumiki_static_url($url){
	if(!is_admin()){
		$url = preg_replace("/:\/\//", '://s.', $url);
	}
	return $url;
}
add_filter('template_directory_uri', '_fumiki_static_url');
add_filter('stylesheet_directory_uri', '_fumiki_static_url');

/**
 * wp_enqueue_scriptで読み込まれたJavascriptのSRC属性をCDN対応
 *
 * @param string $src
 * @return string
 */
function _fumiki_script_loader_src($src){
	$home_url = home_url();
	if( false !== strpos($src, $home_url) ){
		$src = preg_replace('/(https?) : \/\//', '$1://s.', $src);
	}
	return $src;
}
add_filter('script_loader_src', '_fumiki_script_loader_src');

/**
 * CSSのURLを書き換える
 *
 * @param string $tag
 * @return string
 */
add_filter('style_loader_tag', function ($tag, $handle){
	switch( $handle ){
		case 'dashicons':
		case 'font-awesome':
			// フォントファイルは同一ドメインでないとダメ
			$tag = preg_replace('/(https?:\/\/)s\.takahashifumiki/u', '$1takahashifumiki', $tag);
			break;
		default:
			$home_url = home_url('/', is_ssl() ? 'https' : 'http');
			// 同一ドメインの静的リソースはstaticドメインより配信
			$tag = preg_replace('/(https?) : \/\/takahashifumiki/u', '$1://s.takahashifumiki', $tag);
			break;
	}
	return $tag;
}, 10, 2);

/**
 * wp_attachment imageのSRCを置換
 *
 * @param array $atts
 * @return array
 */
function _fumiki_attachment_image_atts($atts){
	if(!is_admin()){
		$atts['src'] = preg_replace("/(https?) : \/\//", '$1://s.', $atts['src']);
	}
	return $atts;
}
add_filter('wp_get_attachment_image_attributes', '_fumiki_attachment_image_atts');

/**
 * get_atachment_urlのURLを変更
 *
 * @param string $url
 * @return string
 */
function _fmiki_attachment_url($url){
	if(!is_admin()){
		$url = preg_replace("/(https?) : \/\//", '$1://s.', $url);
	}
	return $url;
}
//add_filter('wp_get_attachment_url', '_fmiki_attachment_url');

/**
 * Image Widgetが出す画像をコントロール
 *
 * @param string $url
 * @param array $args
 * @param array $instance
 * @return string
 */
function _fumiki_image_widget_url($url, $args, $instance){
	if(false !== strpos($url, 'wp-content')){
		$url = preg_replace("/:\/\//", '://s.', $url);
		if(is_ssl()){
			$url = str_replace('http://', 'https://', $url);
		}else{
			$url = str_replace('https://', 'http://', $url);
		}
	}
	return $url;
}
add_filter('image_widget_image_url', '_fumiki_image_widget_url', 10, 3);

/**
 * リダイレクトループにならないようにする
 */
add_action('template_redirect', function(){
	remove_action('template_redirect', 'redirect_canonical');
}, 1);

/**
 * AjaxのURLを現在のスキームにあわせる
 *
 * @param string $url
 * @param string $path
 * @return string
 */
function _fumiki_ajax_url($url, $path = ''){
	if(false !== strpos($path, 'admin-ajax')){
		if(is_ssl()){
			$url = str_replace('http://', 'https://', $url);
		}else{
			$url = str_replace('https://', 'http://', $url);
		}
	}
	return $url;
}
add_filter('admin_url', '_fumiki_ajax_url', 10, 2);


global $normal_sidebar_counter;
$normal_sidebar_counter = 0;

global $ebook_sidebar_counter;
$ebook_sidebar_counter = 0;

/**
 * サイドバーのウィジェットを
 *
 * @global int $normal_sidebar_counter
 * @param array $params 
 * @return array
 */
function _fumiki_sidebar_container($params){
	global $normal_sidebar_counter, $ebook_sidebar_counter;
	if($params[0]['name'] == '電子書籍'){
		$ebook_sidebar_counter++;
		if($ebook_sidebar_counter % 3 == 1){
			$params[0]['before_widget'] = preg_replace("/class=\"([^\"]+)\"/", 'class="$1 clrL"', $params[0]['before_widget']);
		}
		if($ebook_sidebar_counter % 3 == 0){
			$params[0]['before_widget'] = preg_replace("/class=\"([^\"]+)\"/", 'class="$1 last"', $params[0]['before_widget']);
		}
	}
	return $params;
}
add_filter('dynamic_sidebar_params', '_fumiki_sidebar_container');


/**
 * 電子書籍の立ち読みを表示する
 *
 * @param string $content
 * @return string
 */
function _fumiki_read_more($content){
	if(is_singular('ebook')){
		$contents = preg_split("/.*?<span id=\"more-[0-9]+\"><\/span>.*?\n/", $content);
		if(count($contents) > 1){
			$content = $contents[0];
			$title = get_the_title();
			$content .= <<<EOS
<div class="ebook-more clearfix"><div id="ebook-more-content" class="ebook-more-body mincho">{$contents[1]}</div><div class="ebook-more-cover"></div><p class="ebook-read-more center"><a title="{$title} 立ち読み" class="button sans" href="#ebook-more-content">立ち読み</a></p></div>
EOS;
			
		}
	}
	return $content;
}
add_filter('the_content', '_fumiki_read_more');

/**
 * LWPフォームのヘッダーを変更
 *
 * @param string $title
 * @return string 
 */
function _fumiki_lwp_form_title($title){
	return '<img src="'.get_stylesheet_directory_uri().'/styles/img/header-logo-big.png" width="380" height="40" alt="'.esc_attr($title).'" />'.
		   '<span>'.get_bloginfo('description').'</span>';
}
add_filter('lwp_form_title', '_fumiki_lwp_form_title');