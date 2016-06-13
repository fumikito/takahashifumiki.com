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


/**
 * はてなブックマークの総数を取得する
 * @return int
 */
function hatena_total_bookmark_count() {
	$cache = get_transient( 'hatena_bookmark_total_count' );
	if ( false === $cache ) {
		require ABSPATH . WPINC . '/class-IXR.php';
		$client = new IXR_Client( 'http://b.hatena.ne.jp/xmlrpc' );
		$client->query( 'bookmark.getTotalCount', 'http://takahashifumiki.com/' );
		$cache = $client->getResponse();
		set_transient( 'hatena_bookmark_total_count', $cache, 60 * 60 * 24 );
	}

	return (int) $cache;
}


/**
 * はてなブックマークのXMLを返す
 *
 * @param string $sort 'count' 'eid', または 'hot'のいずれか
 * @return array
 */
function get_hatena_rss( $sort = 'count' ) {
	$hatena_transient_name = 'hatena_hotentry_' . $sort;
	$endpoint = 'http://b.hatena.ne.jp/entrylist?mode=rss&url=takahashifumiki.com&sort='.$sort;
	$feed = fetch_feed( $endpoint );
	if ( is_wp_error( $feed ) ) {
		return [];
	} else {
		if ( 'count' === $sort ) {
			$rank = [];
			for ( $i = 0, $l = $feed->get_item_quantity(); $i < $l; $i++ ) {
				$item = $feed->get_item($i);
				$rank[$i] = $item->get_item_tags( 'http://www.hatena.ne.jp/info/xmlns#', 'bookmarkcount' )[0]['data'];
			}
			arsort($rank);
			$items = [];
			foreach ( $rank as $index => $value ) {
				$items[] = $feed->get_item($index);
				if ( 5 <= count($items) ) {
					break;
				}
			}
			return $items;
		} else {
			return $feed->get_items( 0, 5 );
		}
	}
}

/**
 * ランキングを取得する
 *
 * @param string $start_date
 * @param string $end_date
 * @param string $metrics
 * @param array $params
 *
 * @return array
 */
function get_ga( $start_date, $end_date, $metrics, $params = [] ) {
	try{
		$google = Gianism\Service\Google::get_instance();
		if( ! $google || ! $google->ga_profile['view'] ) {
			throw new \Exception( 'Google Analytics is not connected.', 500 );
		}
		$result = $google->ga->data_ga->get('ga:'.$google->ga_profile['view'], $start_date, $end_date, $metrics, $params);
		if( $result && ( 0 < count($result->rows) ) ) {
			return $result->rows;
		}else{
			return [];
		}
	}  catch ( \Exception $e ){
		if ( WP_DEBUG ) {
			trigger_error( sprintf( '[GA Error:%s] %s', $e->getCode(), $e->getMessage() ) );
		}
		return [];
	}
}

/*
$hatebu = array(
	'hot'   => '注目',
	'eid'   => '新着',
	'count' => '人気',
);
$key    = array_rand( $hatebu );
$hatena = get_hatena_rss( $key );
if ( $hatena ) :
	?>
	<div class="box grid_2">
		<h3><i class="fa-bookmark"></i> はてぶで<?= $hatebu[ $key ]; ?></h3>
		<ol class="post-list">
			<?php $counter = 0;
			foreach ( $hatena->item as $item ) : $counter ++; ?>
				<li>
					<span class="score old"><?= number_format( get_hatena_count( $item ) ); ?>B</span>
					<h4>
						<a href="<?= $item->link; ?>"><?= str_replace( " | 高橋文樹.com", "", (string) $item->title ); ?></a>
					</h4>
					<span class="date mono"><?= mysql2date( 'Y.n.j', (string) get_hatena_date( $item ) ); ?></span>
				</li>
				<?php if ( $counter >= 5 ) {
					break;
				} endforeach; ?>
		</ol>
	</div>
<?php endif; ?>
*/