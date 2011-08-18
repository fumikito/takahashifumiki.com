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
 * @return void
 */
function _fumiki_rewrite($wp_rewrite){
	$new_rewrite = array(
		'main/facebook' => 'index.php?pagename=facebook'
	);
	 $wp_rewrite->rules = array_merge($new_rewrite, $wp_rewrite->rules);
}
add_filter('generate_rewrite_rules', '_fumiki_rewrite');