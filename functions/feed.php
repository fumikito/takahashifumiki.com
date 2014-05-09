<?php

/**
 * メインのフィードに投稿タイプを追加する
 * @param array $qv
 * @return array
 */
function _fumiki_feed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'ebook', 'events');
	return $qv;
}
add_filter('request', '_fumiki_feed_request');


/**
 * RSS2.0にメディアを追加する
 */
function _fumiki_feed_ns(){
	echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}
add_action('rss2_ns', '_fumiki_feed_ns');

/**
 * サムネイルを抜粋に含める
 * @param string $content
 * @return string
 */
function _fumiki_post_thumbnail_feeds_excerpt($content) {
	switch(get_post_type()){
		case 'ebook':
			$eyecatch = ebook_cover_src();
			if(!empty($eyecatch) && preg_match('/^https?:\/\//', $eyecatch)){
				$content = sprintf('<div><img src="%s" alt="%s" /></div>', $eyecatch, get_the_title()). $content;
			}
			break;
		case 'post':
			$photo = fumiki_archive_photo('large', null, false, false);
			if(!empty($photo)){
				$content = sprintf('<div>%s</div>', $photo). $content;
			}
			break;
	}
	return $content;
}
add_filter('the_excerpt_rss', '_fumiki_post_thumbnail_feeds_excerpt');


/**
 * アイキャッチを本文に含める（電子書籍のみ）
 * @param string $content
 * @return string
 */
function _fumiki_post_thumbnail_feeds_content($content) {
	switch(get_post_type()){
		case 'ebook':
			$eyecatch = ebook_cover_src();
			if( !empty($eyecatch) && preg_match('/^https?:\/\//', $eyecatch) ){
				$content = sprintf('<div><img src="%s" alt="%s" /></div>', $eyecatch, get_the_title()). $content;
			}
			break;
	}
	return $content;
}
add_filter('the_content_feed', '_fumiki_post_thumbnail_feeds_content');

/**
 * サムネイルをメディアタグに書き出す
 */
function _fumiki_feed_media(){
	$src = false;
	switch(get_post_type()){
		case 'ebook':
			$src = ebook_cover_src();
			break;
		case 'post':
			$photo = fumiki_archive_photo('large', null, false, false);
			if(!empty($photo)){
				$src = preg_replace('/^.*src="([^"]+)".*$/', "$1", $photo);
			}
			break;
	}
	if($src){
		$title = get_the_title_rss();
		echo <<<EOS
		<media:thumbnail url="{$src}" />
			<media:content url="{$src}" medium="image">
				<media:title type="html">{$title}</media:title>
			</media:content>

EOS;
	}
}
add_action('rss2_item', '_fumiki_feed_media');

/**
 * フィードのタイトルをカスタマイズする
 * @param string $title
 * @return string
 */
function _fumiki_feed_title($title){
	switch(get_post_type()){
		case 'events':
		case 'ebook':
			return sprintf("［%s］ ", get_post_type_object(get_post_type())->labels->name).$title;
			break;
		default:
			return $title;
			break;
	}
}
add_filter('the_title_rss', '_fumiki_feed_title');

// コメント用フィードを削除する
remove_action('wp_head', 'feed_links_extra', 3);


/**
 * Feedlyの購読者数を取得する
 *
 * @param bool $format trueにすると整形して出力
 * @return int|mixed|string
 */
function fumiki_feed_count($format = true){

	$subscribers = get_transient('feedly_subscribers');

	if( false === $subscribers ){
		// RSS feed のURLをエンコード
		$feed_url = rawurlencode( get_bloginfo('rss2_url') );
		// 購読情報をJsonで取得して購読者数だけ頂く
		$response = wp_remote_get("http://cloud.feedly.com/v3/feeds/feed%2F{$feed_url}", array(
			'timeout' => 3,
		));
		$subscribers = -1;
		if( !is_wp_error($response) && !empty($response['body']) && ($json = json_decode($response['body'])) ){
			$subscribers = (int) $json->subscribers;
		}
		set_transient('feedly_subscribers', $subscribers, 3600);
	}
	if($format){
		if( 0 > $subscribers){
			$subscribers = 'NAN';
		}else{
			$subscribers = number_format($subscribers);
		}
	}

	return $subscribers;
}
