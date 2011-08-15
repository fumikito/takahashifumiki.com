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
		"Mobile Safari" //Android
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
	return ($_SERVER['SERVER_NAME'] == 'takahashifumiki.com');
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