<?php

add_action( 'amp_post_template_head', function () {

} );

/**
 * AMPに要素を追加する
 */
add_action( 'amp_post_template_footer', function () {
	?>
<footer class="amp-footer-content">
	<p>&copy; 2008 Takahashi Fumiki</p>
</footer>
	<?php
} );

add_action( 'amp_post_template_css', function ( $amp_template ) {
	// only CSS here please...
	$url = get_stylesheet_directory_uri().'/styles/img/favicon/faviconx120.png';
	echo <<<CSS
nav.amp-wp-title-bar {
	padding: 12px 0;
	background: #fff;
}
nav.amp-wp-title-bar a {
	background: transparent url( '{$url}' ) center 10px no-repeat;
	background-size: 40px 40px;
	display: block;
	height: 20px;
	padding-top: 45px;
	width: 100%;
	margin: 0 auto 10px;
	color: #666;
	text-align: center;
	
}
.amp-wp-content{
	color: #222;
}
.tmkm-amazon-view{
	border-top: 3px double #ddd;
	border-bottom: 3px double #ddd;
	margin: 10px 0;
	padding: 10px;
	font-size :0.85em;
}
.tmkm-amazon-img amp-img{
	margin: 0 auto;
}
.tmkm-amazon-view p{
	margin: 0.25em 0;
}
.amp-footer-content{
	text-align: center;
	font-size: 12px;
	color: #fff;
	background: #252E34;
	padding: 20px;
}
body{
font-family: "游ゴシック体", "Yu Gothic", YuGothic, sans-serif;
padding-bottom: 0;
}
.amp-ad-container{
margin: 10px -16px;
text-align: center;
}
CSS;
} );


/**
 * 画像を追加する
 */
add_action( 'pre_amp_render_post', function () {
	add_filter( 'the_content', function ( $content ) {
		// 広告追加
		$ad = <<<HTML
<div class="amp-ad-container">
<amp-ad
 	type="adsense"
 	data-ad-client="ca-pub-0087037684083564"
 	data-ad-slot="9343442847"
 	width="320"
 	height="100">
</amp-ad>
</div>
HTML;
		$content = $ad.$content;
		// サムネイル追加
		if ( has_post_thumbnail() ) {
			// Just add the raw <img /> tag; our sanitizer will take care of it later.
			$image   = sprintf( '<p class="featured-image">%s</p>', get_the_post_thumbnail() );
			$content = $image . $content;
		}
		// 記事の後の広告
		$content .= <<<HTML
<div class="amp-ad-container">
<amp-ad
 	type="adsense"
 	data-ad-client="ca-pub-0087037684083564"
 	data-ad-slot="9969902841"
 	width="300"
 	height="250">
</amp-ad>
</div>
HTML;


		return $content;
	} );
} );

/**
 * ロゴ追加
 */
add_filter( 'amp_post_template_metadata', function ( $data ){
	$data['publisher']['logo'] = [
		'@type' => 'ImageObject',
		'url' => get_stylesheet_directory_uri().'/styles/img/favicon/amp-logo.png',
		'height' => 60,
		'width' => 600,
	];
	return $data;
} );

/**
 * Google analyticsを追加
 */
add_filter( 'amp_post_template_analytics', function ( $analytics ) {
	if ( ! is_array( $analytics ) ) {
		$analytics = [];
	}

	// https://developers.google.com/analytics/devguides/collection/amp-analytics/
	$analytics['googleanalytics'] = [
		'type'        => 'googleanalytics',
		'attributes'  => [
			// 'data-credentials' => 'include',
		],
		'config_data' => [
			'vars'     => [
				'account' => "UA-5329295-4",
			],
			'triggers' => [
				'trackPageview' => [
					'on'      => 'visible',
					'request' => 'pageview',
				],
			],
		],
	];

	return $analytics;
} );
