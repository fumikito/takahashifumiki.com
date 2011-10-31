<?php
/*
 * Facebookページ用の関数
 */

/**
 * Facebookページアプリを初期化
 * 
 * @return Facebook
 */
function fb_init(){
	//Facebookインスタンスを生成
	get_template_part('lib/fb/facebook');
	return new Facebook(array(
		'appId' => '264573556888294',
		'secret' => '6e0f8134a7bf3e0a5a2f67cacabf8004',
		'cookie' => true,
	));
}

/**
 * ユーザーがいいねを押しているかどうか
 * @global Facebook $facebook
 * @return boolean
 */
function fb_is_like_me(){
	global $facebook;
	if(!$facebook){
		return false;
	}
	$signed = $facebook -> getSignedRequest();
	return (boolean) $signed['page']['liked'];
}
