<?php
/**
 * @package takahashifumiki
 */

/**
 * wp_headで出力する
 * @return void
 */
add_action('wp_head', function(){
	echo <<<HTML
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
	google_ad_client: "ca-pub-0087037684083564",
	enable_page_level_ads: true
});
</script>
HTML;
	//Facebook用のメタ情報
	if ( is_front_page() || is_singular() ) {
		if ( is_front_page() ) {
			$title = get_bloginfo( 'name' );
		} elseif ( is_singular( 'podcast' ) ) {
			$title = wp_title( ' | ', false, 'right' );
		} else {
			$title = wp_title( ' | ', false, 'right' ) . get_bloginfo( 'name' );
		}
		$url   = is_front_page() ? trailingslashit( home_url( '/' ) ) : get_permalink();
		$image = get_template_directory_uri() . '/styles/img/favicon/faviconx512.png';
		if ( ! is_front_page() ) {
			$image_id = false;
			if ( has_post_thumbnail() ) {
				$image_id = get_post_thumbnail_id();
			} else {
				$images = get_children( 'post_parent=' . get_the_ID() . '&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1' );
				if ( ! empty( $images ) ) {
					$image_id = current( $images )->ID;
				}
			}
			if ( $image_id ) {
				$image = wp_get_attachment_image_src( $image_id, 'large' );
				$image = $image[0];
			}
			// If podcast, change url
			if ( is_singular( 'podcast' ) ) {
				$series = get_the_terms( get_queried_object_id(), 'series' );
				if ( ! is_wp_error( $series ) && $series ) {
					foreach ( $series as $s ) {
						$term_meta = get_term_meta( $s->term_id, 'eyecatch_id', true );
						if ( ! $term_meta ) {
							continue;
						}
						$img_url = wp_get_attachment_image_url( $term_meta, 'full' );
						if ( $img_url ) {
							$image = $img_url;
							break;
						}
					}
				}
			}
		}
		$type = is_front_page() ? 'website' : 'article';
		if ( is_front_page() ) {
			$desc = get_bloginfo( 'description' );
		} else {
			global $post;
			$desc = $post->post_excerpt ?: wp_trim_words( strip_tags( strip_shortcodes( $post->post_content ) ), 120, '...' );
		}
		$desc = esc_attr( str_replace( "\n", '',  $desc ) );
		$dir = get_stylesheet_directory_uri();
		$properties = [
			'name'     => [
				[ 'description', $desc ],
				[ 'copyright', 'copyright 2008 takahashifumiki.com' ],
				[ 'twitter:card', 'summary' ],
				[ 'twitter:site', '@takahashifumiki' ],
				[ 'twitter:url', $url ],
				[ 'twitter:title', $title ],
				[ 'twitter:description', $desc ],
				[ 'twitter:image', $image ],
			],
			'property' => [
				[ 'og:locale', 'ja_JP' ],
				[ 'og:title', $title ],
				[ 'og:url', $url ],
				[ 'og:image', $image ],
				[ 'og:description', $desc ],
				[ 'og:type', $type ],
				[ 'og:site_name', get_bloginfo( 'name' ) ],
				[ 'fb:admins', '1034317368' ],
				[ 'fb:pages', '240120469352376' ],
			    [ 'fb:app_id', '264573556888294' ],
			    [ 'fb:profile_id', '240120469352376' ],
				[ 'article:author', 'https://www.facebook.com/TakahashiFumiki.Page/' ],
			    [ 'article:publisher', '240120469352376' ],
			],
		];
		if ( ! is_front_page() ) {
			$terms = [];
			if ( $categories = get_the_category( get_queried_object_id() ) ) {
				$terms += $categories;
				foreach ( $categories as $term ) {
					$properties['property'][] = [ 'article:section', $term->name ];
				}
			}
			if ( $tags = get_the_tags( get_queried_object_id() ) ) {
				$terms += $tags;
				foreach ( $tags as $term ) {
					$properties['property'][] = [ 'article:tag', $term->name ];
				}
			}
			if ( $terms ) {
				$properties['name'][] = [ 'keywords', implode( ',', array_map( function( $term ) {
					return $term->name;
				}, $terms ) ) ];
			}
			$properties['property'][] = [ 'article:published_time', mysql2date( DateTime::ATOM, get_queried_object()->post_date ) ];
			$properties['property'][] = [ 'article:modified_time', mysql2date( DateTime::ATOM, get_queried_object()->post_modified ) ];
			// Add related
			if ( function_exists( 'yarpp_get_related' ) ) {
				foreach ( yarpp_get_related( [], get_queried_object_id() ) as $post ) {
					$properties['property'][] = [ 'og:see_olso', get_permalink( $post ) ];
				}
			}
		} else {
			$properties['name'][] = [ 'p:domain_verify', 'd41b6fbe34cc94d28d077985fdc1fe7a' ];
		}
		foreach ( $properties as $property => $vals ) {
			foreach ( $vals as list( $key, $val ) ) {
				printf( '<meta %s="%s" content="%s" />'."\n", $property, esc_attr( $key ), esc_attr( $val ) );
			}
		}
	}
}, 0);

//JetpackのOGPをオフにする
remove_action( 'wp_head' , 'jetpack_og_tags' );




/**
 * ログイン時間を記録する
 * @param string $login
 * @param \WP_User $user
 */
function _fumiki_last_login($login, \WP_user $user) {
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login','_fumiki_last_login', 10, 2);

/**
 * ウィジェットを登録する
 */
function _fumiki_register_widget(){
	get_template_part("widgets/facebook");	
	register_widget('Fumiki_Facebook_Like');
	get_template_part('widgets/ebook');
	register_widget('Fumiki_eBook');
	get_template_part('widgets/recent');
}
add_action('widgets_init', '_fumiki_register_widget');


/**
 * flashプラグインの後方互換
 *
 * @param array $attr
 * @param string $content
 * @return string
 */
function flash_converter($atts, $content = null){
        $arr = shortcode_atts(array(
                0 => null,
                'w' => null,
                'h' => null
        ),$atts);
        $str = '<div id="fumiki_flash_container">'.
                   '<span style="display:none">';
        $str .= $arr[0];
        if(!is_null($arr['w'])) $str .= '::'.$arr['w'];
        if(!is_null($arr['h'])) $str .= '::'.$arr['h'];
        $str .= '</span>'.
                           '<noscript>'.
                           '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
        if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
        if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
        $str .= '>'.
                '<param name="movie" value="'.$arr[0].'" />'.
                        '<!--[if !IE]>-->'.
                        '<object type="application/x-shockwave-flash" data="'.$arr[0].'"';
        if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
        if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
        $str .= '>'.
                '<!--<![endif]-->'.
                        '<!--[if !IE]>-->'.
                        '</object>'.
                        '<!--<![endif]-->'.
                        '</object>'.
                        '</noscript>'.
                        '</div>';
        return $str;
}
add_shortcode('flash','flash_converter');

/**
 * JetpackのOGPを消す
 *
 * @action wp_head
 */
add_action('wp_head', function(){
    remove_action('wp_head','jetpack_og_tags');
}, 1);
