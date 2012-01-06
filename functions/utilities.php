<?php
/**
 * @package takahashifumiki
 */

/**
 * Detect if the browser is Internet Explorer or not
 * @package WordPress
 * @param int $version (optional)
 * @return Boolean
 */
function is_IE($version = 0)
{
	$flg = false;
	global $is_winIE;
	if(!$is_winIE)
		return $flg;
	switch($version){
		case 6:
			if(preg_match("/compatible; MSIE 6\.0;/", $_SERVER["HTTP_USER_AGENT"]))
				$flg = true;
			break;
		case 7:
			if(preg_match("/compatible; MSIE 7\.0;/", $_SERVER["HTTP_USER_AGENT"]))
				$flg = true;
			break;
		case 8:
			if(preg_match("/MSIE 8\.0/", $_SERVER["HTTP_USER_AGENT"]))
				$flg = true;
			break;
		case 9:
			if(preg_match("/MSIE 9\.0/", $_SERVER["HTTP_USER_AGENT"]))
				$flg = true;
			break;
			break;
		default:
			$flg = true;
			break;
	}
	return $flg;
}

/**
 * スマートフォンの場合はtrue
 * @return boolean
 */
function is_smartphone(){
	$container = $_SERVER['HTTP_USER_AGENT'];
	$useragents = array (
		"iPhone",
		"iPod",
		"Mobile Safari", //Android,
		"Android.*?Mobile"
	);
	$iphone =  false;
	foreach ( $useragents as $useragent ) {
		if (preg_match("/{$useragent}/",$container)){
			$iphone = true;
		}
	}
	return $iphone;
}

/**
 * 最後にログインした時間を取得する
 * @param int $user_id 
 * @return string
 */
function get_last_login($user_id = false) {
	if(!$user_id){
		global $user_ID;
		$user_id = $user_ID;
	}
    $last_login = get_user_meta($user_id, 'last_login', true);
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $the_last_login = mysql2date($date_format, $last_login, false);
    return $the_last_login;
}

/**
 * 投稿の文字数を返す
 * @param object $post
 * @return int
 */
function fumiki_content_length($post = null){
	$content = _fumiki_get_post($post)->post_content;
	if(is_string($content)){
		return mb_strlen($content, 'utf-8');
	}else{
		return 0;
	}
}

/**
 * 本番サーバの場合はtrueを返す
 * @return boolean
 */
function is_production(){
	//NginxのリバースプロキシでSever Nameが変更してる
	return (boolean)($_SERVER['SERVER_NAME'] == 'takahashifumiki.com' || $_SERVER['SERVER_NAME'] == '_');
}

/**
 * 投稿を返す（メタ情報を取るときなどにメンドクサイので）
 * @global object $post
 * @param object $post
 * @return object
 */
function _fumiki_get_post($post = null){
	if(!$post){
		global $post;
	}
	return get_post($post);
}

/**
 * テンプレートディレクトまでのパスを返す
 * @param boolean $echo falseにすると値を返す。初期値はtrueでURLを出力。
 * @return mixed
 */
function ssl_template_directory($echo = true){
	if($_SERVER['SERVER_NAME'] == 'fumiki.sakura.ne.jp'){
		$url = preg_replace('/https?:\/\/takahashifumiki\.com/', 'https://fumiki.sakura.ne.jp/main', get_bloginfo('template_directory'));
	}else{
		$url = str_replace('http:', 'https:', get_bloginfo('template_directory'));
	}
	if($echo){
		echo $url;
	}else{
		return $url;
	}
}

/**
 * 指定したページが電子書籍関連ページか否かを返す
 * @global object $post
 * @param mixed $page
 * @return boolean
 */
function is_ebook_related_pages($page = null){
	if(is_page('ebooks')){
		//親ページの場合
		return true;
	}else{
		//子ページの場合
		$parent = get_page_by_path('ebooks');
		if(is_null($page)){
			global $post;
			$page = $post;
		}else{
			$page = get_page($page);
		}
		return ($page->post_parent == $parent->ID);
	}
}

/**
 * HTML5に対応したtype属性を出力する
 * @global boolean $is_IE
 * @param boolean $echo
 * @return string
 */
function attr_email($echo = true){
	global $is_IE;
	$type = $is_IE ? 'text' : 'email';
	if($echo){
		echo $type;
	}
	return $type;
}

/**
 * HTML5に対応したtype属性を返す
 * @global boolean $is_IE
 * @param boolean $echo
 * @return string
 */
function attr_search($echo = true){
	global $is_IE;
	$type = !is_smartphone() ? 'text' : 'search';
	if($echo){
		echo $type;
	}
	return $type;
}