<?php

/**
 * 破滅派に投稿した最新のものを取得する
 *
 * @return array|mixed
 */
function hametuha_posts() {
	$posts = get_transient( 'hametu_posts' );
	if ( false === $posts ) {
		try {
			$url  = 'http://hametuha.com/author/takahashi_fumiki/feed/';
			$feed = wp_remote_get( $url, array(
				'timeout' => 5,
			) );
			if ( is_wp_error( $feed ) ) {
				throw new Exception( $feed->get_error_message() );
			}
			libxml_use_internal_errors( true );
			$xml = simplexml_load_string( $feed['body'], 'SimpleXMLElement', LIBXML_NOCDATA );
			if ( false === $xml ) {
				return [];
			} else {
				$posts = [];
				foreach ( $xml->channel->item as $item ) {
					$p           = [
						'title'     => (string) $item->title,
						'excerpt'   => (string) $item->description,
						'url'       => (string) $item->link .
						               '?utm_source=takahashifumiki.com&utm_medium=banner&utm_campaign=related',
						'post_date' => date_i18n( 'Y-m-d H:i:s', strtotime( $item->pubDate ) + 60 * 60 * 9 ),
						'category'  => (array) $item->category,
						'source'    => '破滅派',
					];
					$p['images'] = hametuha_grab_feed_image( $item );
					$posts[]     = $p;
				}
				// 保存する
				set_transient( 'hametu_posts', $posts, 60 * 60 * 2 );
			}
		} catch ( Exception $e ) {
			return array();
		}
	}

	return $posts;
}

/**
 * RSSから画像を引っこ抜く
 *
 * @param SimpleXMLElement $item
 *
 * @return array
 */
function hametuha_grab_feed_image( $item ) {
	$images = [];
	foreach ( $item->children( 'media', true )->group->content as $thumbnail ) {
		$data                             = $thumbnail->attributes();
		$attributes                       = $thumbnail->attributes();
		$images[ (string) $data['size'] ] = [
			(string) $data['url'],
			(string) $data['width'],
			(string) $data['height'],
		];
	}

	return $images;
}

/**
 * 投稿を取得する
 *
 * @return array|mixed
 */
function hametuha_kdp() {
	$posts = get_transient( 'hametuha_kdp' );
	if ( WP_DEBUG ) {
		$posts = false;
	}
	if ( false === $posts ) {
		try {
			$posts = array();
			$url   = 'http://hametuha.com/author/takahashi_fumiki/feed/?post_type=series&meta_filter=kdp';
			$feed  = wp_remote_get( $url, array(
				'timeout' => 5,
			) );
			if ( is_wp_error( $feed ) ) {
				throw new Exception( $feed->get_error_message() );
			}
			libxml_use_internal_errors( true );
			$xml = simplexml_load_string( $feed['body'], 'SimpleXMLElement', LIBXML_NOCDATA );
			if ( false !== $xml ) {
				foreach ( $xml->channel->item as $item ) {
					$thumbnials = $item->children( 'media', true )->thumbnail->attributes();

					$p = array(
						'title'     => (string) $item->title,
						'excerpt'   => (string) $item->description,
						'url'       => (string) $item->children( 'dc', true )->relation,
						'post_date' => date_i18n( 'Y-m-d H:i:s', strtotime( $item->pubDate ) + 60 * 60 * 9 ),
						'category'  => (string) $item->category,
						'image'     => str_replace( 'http://', 'https://', (string) $thumbnials['url'] ),
					);

					$p['images'] = hametuha_grab_feed_image( $item );
					$posts[]     = $p;
				}
				// 保存する
				set_transient( 'hametuha_kdp', $posts, 60 * 60 * 2 );
			}
		} catch ( Exception $e ) {
			return array();
		}
	}

	return $posts;
}
