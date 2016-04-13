<?php


/**
 * ログインしたらCookieをつける
 */
add_action( 'wp_login', function($login_name, $current_user){
	setcookie("fumikicustomer", 1, current_time('timestamp') + ( 3600 * 24 * 14 ), "/",  preg_replace('#https?://#', '', rtrim(home_url(), '/')));
}, 10, 2 );

add_action('wp_logout', function(){
	setcookie("fumikicustomer", 1, current_time('timestamp') - 10, "/",  preg_replace('#https?://#', '', rtrim(home_url(), '/')));
});

/**
 * Cache ヘッダーを追加する
 *
 * @filter nocache_headers
 *
 * @param array $headers
 *
 * @return array
 */
add_filter( 'nocache_headers', function ( $headers ) {
	$headers['X-Accel-Expires'] = 0;

	return $headers;
}, 1 );


/**
 * CloudFlare用ヘッダー
 *
 * @action template_redirect
 */
add_action( 'template_redirect', function () {
	// No cache headers.
	if ( is_page( 'about' ) ) {
		nocache_headers();
	} elseif ( is_singular( 'ebook' ) || ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) ) {
		nocache_headers();
	} elseif ( is_singular( 'post' ) ) {
		if ( lwp_has_files() || lwp_has_ticket() ) {
			nocache_headers();
		}
	}
	// Add CF tags.
	$tags = '';
	if ( is_front_page() ) {
		$tags = 'front';
	} elseif ( is_category() || is_tag() ) {
		$cat  = get_queried_object();
		$tags = $cat->taxonomy . '-' . $cat->slug;
	} elseif ( is_singular( 'post' ) || is_singular( 'page' ) ) {
		$tags = get_post_type() . '-' . get_the_ID();
	}
	if ( $tags ) {
		header( 'Cache-Tag: ' . $tags );
	}
} );

/**
 * CloudFlareのAPIにレスポンスを飛ばす
 *
 * @param string $endpoint
 * @param array $params
 * @param string $method
 *
 * @return array|mixed|object|WP_Error
 */
function make_cf_request( $endpoint, $params = [ ], $method = 'GET' ) {
	if ( ! defined( 'CF_MAIL' ) || ! defined( 'CF_TOKEN' ) || ! defined( 'CF_ZONE_ID' ) ) {
		return new WP_Error( 500, 'No Credentials set.' );
	}
	$endpoint = 'https://api.cloudflare.com/client/v4/' . $endpoint;
	$opts     = [
		CURLOPT_POST           => 'POST' === $method,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPHEADER     => [
			'X-Auth-Email: ' . CF_MAIL,
			'X-Auth-Key: ' . CF_TOKEN,
			'Content-Type: application/json',
		],
	];
	$method   = strtoupper( $method );
	switch ( $method ) {
		case 'GET':
			if ( $params ) {
				$endpoint .= '?';
				foreach ( $params as $key => $val ) {
					$endpoint .= $key . '&' . rawurldecode( $val );
				}
			}
			break;
		case 'POST':
			$opts[ CURLOPT_POST ]       = true;
			$opts[ CURLOPT_POSTFIELDS ] = json_encode( $params );
			break;
		case 'PUT':
		case 'DELETE':
			$opts[ CURLOPT_CUSTOMREQUEST ] = $method;
			$opts[ CURLOPT_POSTFIELDS ]    = json_encode( $params );
			break;
	}
	$ch = curl_init( $endpoint );
	curl_setopt_array( $ch, $opts );
	if ( WP_DEBUG ) {
		error_log( var_export( $opts, true ) );
	}

	$result = curl_exec( $ch );
	if ( ! $result ) {
		$error = new WP_Error( curl_errno( $ch ), curl_error( $ch ) );
		curl_close( $ch );

		return $error;
	} else {
		curl_close( $ch );
		$response = json_decode( $result );
		if ( is_null( $response ) ) {
			return new WP_Error( 500, 'Failed to parse JSON.' );
		} else {
			if ( WP_DEBUG ) {
				error_log( $result );
			}

			return $response;
		}
	}
}

/**
 * Purge Cache
 *
 * @param WP_Post $post
 *
 * @return array|mixed|object|WP_Error
 */
function purge_cf_cache( $post ) {
	$urls = [ home_url( '/', 'http' ) ];
	if ( 'post' == $post->post_type ) {
		$urls[] = get_permalink( $post );
		foreach ( array_merge( get_the_category( $post->ID ), get_the_tags( $post->ID ) ) as $term ) {
			$urls[] = get_term_link( $term, $term->taxonomy );
		}
	}

	$response = make_cf_request( '/zones/' . CF_ZONE_ID . '/purge_cache', [ 'files' => $urls ], 'DELETE' );

	if ( is_wp_error( $response ) ) {
		return $response;
	} else {
		return $response;
	}
}

/**
 * CloudFlareをパージする
 */
add_action( 'save_post', function ( $post_id, $post ) {
	if ( 'post' == $post->post_type && 'publish' == $post->post_status ) {
		purge_cf_cache( $post );
	}
}, 10, 2 );


add_action( 'transition_post_status', function ( $new_status, $old_status, $post ) {
	if ( 'publish' === $new_status && 'future' === $old_status ) {
		purge_cf_cache( $post );
	}
}, 10, 2 );
