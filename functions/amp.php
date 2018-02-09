<?php

add_action( 'amp_post_template_head', function () {

} );


add_action( 'amp_post_template_css', function ( $amp_template ) {
	// only CSS here please...
	$css = get_stylesheet_directory() . '/assets/css/amp.css';
	if ( file_exists( $css ) ) {
		echo trim( preg_replace( '#/\*(.*?)\*/#', '', file_get_contents( $css ) ) );
	}
} );

add_action( 'amp_post_template_data', function ( $data ) {
	//デフォルト読み込みのフォントMerriweatherを削除
	$data['font_urls'] = array(
		'FontAwesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
	);
	return $data;
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
