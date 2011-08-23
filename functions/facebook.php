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

/**
 * 投稿内のコンテンツを表示する
 * @param string $content
 * @return string
 */
function _fb_sslize_assets($content){
	if(is_production()){
		$content = str_replace('http://takahashifumiki.com/wp-content/uploads', 'https://fumiki.sakura.ne.jp/main/wp-content/uploads', $content);
	}else{
		$content = str_replace('http://mac', 'https://mac', $content);
	}
	return $content;
}
add_filter('the_content', '_fb_sslize_assets');