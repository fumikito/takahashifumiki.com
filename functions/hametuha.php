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
				return array();
			} else {
				$posts = array();
				foreach ( $xml->channel->item as $item ) {
					$posts[] = array(
						'title'     => (string) $item->title,
						'excerpt'   => (string) $item->description,
						'url'       => (string) $item->link .
									   '?utm_source=takahashifumiki.com&utm_medium=banner&utm_campaign=related',
						'post_date' => date_i18n( 'Y-m-d H:i:s', strtotime( $item->pubDate ) + 60 * 60 * 9 ),
						'category'  => (array) $item->category,
						'source'    => '破滅派',
					);
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
 * 投稿を取得する
 *
 * @return array|mixed
 */
function hametuha_kdp() {
	$posts = get_transient( 'hametuha_kdp' );
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
					$posts[]    = array(
						'title'     => (string) $item->title,
						'excerpt'   => (string) $item->description,
						'url'       => (string) $item->children( 'dc', true )->relation,
						'post_date' => date_i18n( 'Y-m-d H:i:s', strtotime( $item->pubDate ) + 60 * 60 * 9 ),
						'category'  => (string) $item->category,
						'image'     => str_replace( 'http://', 'https://', $thumbnials['url'] ),
					);
				}
				// 保存する
//				set_transient( 'hametuha_kdp', $posts, 60 * 60 * 2 );
			}
		} catch ( Exception $e ) {
			return array();
		}
	}

	return $posts;
}
