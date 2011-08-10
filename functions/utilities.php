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