<?php
/**
 * @package takahashifumiki
 */




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
 * スマートフォンの場合、クラスを付加する
 * @param array $classes
 * @return arrary
 */
function _fumiki_smartphone($classes){
	if(is_smartphone()){
		$classes[] = 'smartphone';
	}
	if(is_page('facebook')){
		$classes[] = 'facebook';
	}
	return $classes;
}
add_filter('body_class', '_fumiki_smartphone');


/**
 * リライトルールを変更する
 * @param WP_Rewrite $wp_rewrite 
 * @deprecated 2.3.4
 * @return void
 */
function _fumiki_rewrite($wp_rewrite){
	if(is_production()){
		$new_rewrite = array(
			'main/facebook' => 'main/index.php?pagename=facebook'
		);
	}else{
		$new_rewrite = array(
			'main/facebook' => 'index.php?pagename=facebook'
		);
	}
	$wp_rewrite->rules = array_merge($new_rewrite, $wp_rewrite->rules);
}
//add_filter('generate_rewrite_rules', '_fumiki_rewrite');

/**
 * iframeが削除されないようにする
 * @param array $initArray
 * @return array 
 */
function _fumiki_tinymce($initArray) {
	if(!empty($initArray["extended_valid_elements"])){
		$initArray["extended_valid_elements"] .= ",";
	}
	$initArray[ 'extended_valid_elements' ] .= "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
	//選択できるブロック要素を変更
	$initArray['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,dt,dd,div,pre';
	//スタイリング用クラス
	$style_formats = array(
		array(
			'title' => 'サクセス',
			'block' => 'p',
			'classes' => 'message success'
		),
		array(
			'title' => '注意',
			'block' => 'p',
			'classes' => 'message warning'
		),
		array(
			'title' => '注意書き',
			'inline' => 'span',
			'classes' => 'alert'
		)
	);
	$initArray['style_formats'] = json_encode($style_formats);
	return $initArray;
}
add_filter('tiny_mce_before_init', '_fumiki_tinymce', 10000);

/**
 * SSLのコンテンツが表示されているときにsrcなどを修正する
 * @param string $content
 * @return string 
 */
function _fumiki_ssl_content($content){
	if(is_ssl()){
		$upload_dir = wp_upload_dir();
		$upload_dir_url = $upload_dir['baseurl'];
		$upload_dir_ssl_url = str_replace('http:', 'https:', $upload_dir_url);
		$content = str_replace($upload_dir_url, $upload_dir_ssl_url, $content);
	}
	return $content;
}
add_filter('the_content', '_fumiki_ssl_content');

/**
 * SSLページですべてのリンクがHTTPSになってしまうのを修正する
 * @param string $url
 * @param string $path
 * @param string $orig_scheme
 * @return string
 */
function _fumiki_home_url($url, $path = '', $orig_scheme = 'http'){
	if(is_ssl() && strpos($path, 'wp-content') === false){
		$url = str_replace('https:', 'http:', $url);
	}
	return $url;
}
add_filter('home_url', '_fumiki_home_url');

/**
 * SSLが指定されている場合はURLを返す
 * @param string $url
 * @return string
 */
function _fumiki_login_ssl($url){
	if(FORCE_SSL_LOGIN || FORCE_SSL_ADMIN){
		$url = str_replace('http:', 'https:', $url);
	}
	return $url;
}
add_filter('login_url', '_fumiki_login_ssl');
add_filter('register', '_fumiki_login_ssl');
add_filter('logout_url', '_fumiki_login_ssl');
add_filter('logout_redirect', '_fumiki_login_ssl');

/**
 * Theme My Loginが出力する管理画面へのURLをSSLにする
 * @param string $url
 * @param string $action
 * @param int|string $instance
 * @return string
 */
function _fumiki_admin_ssl($url, $action = 'login', $instance = ''){
	switch($action){
		case 'login':
		case 'register':
		case 'lostpassword':
		case 'retrievepassword':
		case 'resetpass':
		case 'rp':
			if(FORCE_SSL_LOGIN || FORCE_SSL_ADMIN){
				$url = str_replace('http:', 'https:', $url);
			}
			break;
		default:
			if(FORCE_SSL_ADMIN){
				$url = str_replace('http:', 'https:', $url);
			}
			break;
	}
	return $url;
}
add_filter('tml_action_url', '_fumiki_admin_ssl');

/**
 * Theme My LoginがSSLにリダイレクトしてくれないのをなんとかする
 * @param string $link
 * @param string $query
 * @return string
 */
function _fumiki_login_link($link, $query = ''){
	if(FORCE_SSL_LOGIN || FORCE_SSL_ADMIN){
		$link = str_replace('http:', 'https:', $link);
	}
	return $link;
}
add_filter('tml_page_link', '_fumiki_login_link');

/**
 * Disqusのスクリプトが関係ないところにも読み込まれるのを防止
 * @return void
 */
function _fumiki_remove_disqus(){
	if(is_ssl()){
		remove_action('wp_footer', 'dsq_output_footer_comment_js');
	}
}
add_action('wp_footer', '_fumiki_remove_disqus', 1);