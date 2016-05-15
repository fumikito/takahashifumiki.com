<?php
/**
 * @package takahashifumiki
 */


/**
 * wp_headで出力する
 * @return void
 */
function _fumiki_head(){
	echo <<<HTML
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
	google_ad_client: "ca-pub-0087037684083564",
	enable_page_level_ads: true
});
</script>
HTML;
	if( is_front_page() ){
		echo '<meta name="p:domain_verify" content="d41b6fbe34cc94d28d077985fdc1fe7a"/>';
	}
	//Facebook用のメタ情報
	if(is_front_page() || is_singular()){
		$title = is_front_page() ? get_bloginfo('name') : wp_title('|', false, "right").get_bloginfo('name') ;
		$url = is_front_page() ?  trailingslashit(home_url('/', 'http')) : get_permalink();
		$image = get_template_directory_uri()."/styles/img/favicon/faviconx512.png";
		if( !is_front_page() ){
            $image_id = false;
            if( has_post_thumbnail() ){
                $image_id = get_post_thumbnail_id();
            }else{
                $images = get_children("post_parent=".get_the_ID()."&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1");
                if(!empty($images)){
                    $image_id = current($images)->ID;
                }
            }
            if( $image_id ){
                $image = wp_get_attachment_image_src($image_id, 'large');
                $image = $image[0];
            }
		}
		$type = is_front_page() ? "website" : 'article';
		if(get_post_type() == 'ebook'){
			$type = 'book';
		}
        if( is_front_page() ){
            $desc = get_bloginfo('description');
        }else{
            global $post;
            $desc = $post->post_excerpt ?: wp_trim_words(strip_tags(strip_shortcodes($post->post_content)), 120, '...');
        }
		$desc = esc_attr(str_replace("\n", "",  $desc));
		$dir = get_stylesheet_directory_uri();
		echo <<<HTML
<!-- Open Graph -->
<meta property="og:locale" content="ja_jp" />
<meta property="og:title" content="{$title}"/>
<meta property="og:url" content="{$url}" />
<meta property="og:image" content="{$image}" />
<meta property="og:description" content="{$desc}" />
<meta property="og:type" content="{$type}" />
<meta property="og:site_name" content="高橋文樹.com"/>
<meta property="fb:admins" content="1034317368" />
<meta property="fb:pages" content="240120469352376" />
<!-- Twitter Card -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@takahashifumiki" />
<meta name="twitter:url" content="{$url}" />
<meta name="twitter:title" content="{$title}" />
<meta name="twitter:description" content="{$desc}" />
<meta name="twitter:image" content="{$image}" />
<meta name="description" content="{$desc}" />
HTML;
	}
	echo <<<EOS
<!-- copyright -->
<meta name="copyright" content="copyright 2008 takahashifumiki.com" />
EOS;
}
add_action('wp_head', '_fumiki_head', 0);

//JetpackのOGPをオフにする
remove_action( 'wp_head' , 'jetpack_og_tags' );


/**
 * メニューを登録する
 */
function _fumiki_menu(){
	register_nav_menus(array(
		'main-pages' => 'メインページ',
		'top-page' => 'トップページ'
	));
}
add_action("init", "_fumiki_menu");


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
 * 記事のシングルページでSSLだったらリダイレクト
 *
 * @action template_redirect
 */
add_action('template_redirect', function(){
    if( is_ssl() && ( is_singular('post') || is_front_page() ) ){
        $url = str_replace('https://', 'http://', get_permalink());
        wp_safe_redirect($url, 301);
        exit;
    }
});


/**
 * JetpackのOGPを消す
 *
 * @action wp_head
 */
add_action('wp_head', function(){
    remove_action('wp_head','jetpack_og_tags');
}, 1);
