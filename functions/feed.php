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

/**
 * リライトルールを登録
 */
add_filter( 'rewrite_rules_array', function( $rules ) {
	return array_merge( [
		'^instant-articles/?$' => 'index.php?feed=instant_article&post_type=post&posts_per_page=20&orderby=modified&order=desc',
		'^instant-articles/page/([0-9+])/?$' => 'index.php?feed=instant_article&post_type=post&posts_per_page=20&orderby=modified&order=desc&paged=$matches[1]',
	], $rules );
} );

/**
 * インスタントアーティクルを追加
 */
add_filter( 'feed_content_type', function( $content_type, $type ){
	if ( 'instant_article' == $type ) {
		$content_type = 'application/xml+rss';
	}
	return $content_type;
}, 10, 2 );

/**
 * フィードを出力
 */
add_action( 'do_feed_instant_article', function() {
	header('Content-Type: ' . feed_content_type('rss2') . '; charset=' . get_option('blog_charset'), true);
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
/**
 * Fires between the xml and rss tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php
	/**
	 * Fires at the end of the RSS root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_ns' );
	?>
>

<channel>
	<title><?php wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<sy:updatePeriod><?php
		$duration = 'hourly';

		/**
		 * Filter how often to update the RSS feed.
		 *
		 * @since 2.1.0
		 *
		 * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
		 *                         'yearly'. Default 'hourly'.
		 */
		echo apply_filters( 'rss_update_period', $duration );
	?></sy:updatePeriod>
	<sy:updateFrequency><?php
		$frequency = '1';

		/**
		 * Filter the RSS update frequency.
		 *
		 * @since 2.1.0
		 *
		 * @param string $frequency An integer passed as a string representing the frequency
		 *                          of RSS updates within the update period. Default '1'.
		 */
		echo apply_filters( 'rss_update_frequency', $frequency );
	?></sy:updateFrequency>
	<?php
	/**
	 * Fires at the end of the RSS2 Feed Header.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_head');

	// Filter for amazon link
	add_filter( 'wp_hamazon_amazon', function( $tag ) {
		$tag = preg_replace( '#<p class="tmkm-amazon-img">(.*?)</p>#u', '<figure>$1</figure>', $tag );
		return $tag;
	} );

	add_filter( 'the_content', function($content){
		$content = preg_replace( '#(<blockquote class="twitter-tweet" (data-)?width="[0-9]+">.*?</script></p>)#us', '<figure class="op-social"><iframe>$1</iframe></figure>', $content);
		return $content;
	} );

	while( have_posts()) : the_post();
	?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
	<?php if ( get_comments_number() || comments_open() ) : ?>
		<comments><?php comments_link_feed(); ?></comments>
	<?php endif; ?>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator>
		<author><![CDATA[<?php the_author() ?>]]></author>
		<?php the_category_rss('rss2') ?>

		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
		<?php
			ob_start();
			get_template_part( 'templates/instant-article' );
			$content = ob_get_contents();
			ob_end_clean();
		?>
		<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
	<?php if ( get_comments_number() || comments_open() ) : ?>
		<wfw:commentRss><?php echo esc_url( get_post_comments_feed_link(null, 'rss2') ); ?></wfw:commentRss>
		<slash:comments><?php echo get_comments_number(); ?></slash:comments>
	<?php endif; ?>
	<?php rss_enclosure(); ?>
	<?php
	/**
	 * Fires at the end of each RSS2 feed item.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_item' );
	?>
	</item>
	<?php endwhile; ?>
</channel>
</rss>
	<?php
} );
