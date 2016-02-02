<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<title><?php
		wp_title( ' | ', true, 'right' );
		bloginfo( 'name' );
		if ( is_front_page() ) {
			echo ' | ' . get_bloginfo( 'description' );
		}
		?></title>
	<?php wp_head(); ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo( 'rss2_url' ); ?>" title="高橋文樹.com 最新の投稿"/>
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
</head>
<body <?php body_class( '' ); ?>>
<?php if ( 'page-facebook.php' !== get_page_template_slug() ) : ?>
<div id="fb-root"></div>
<?php endif; ?>
<script>(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=264573556888294";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<script>!function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
		if (!d.getElementById(id)) {
			js = d.createElement(s);
			js.id = id;
			js.src = p + '://platform.twitter.com/widgets.js';
			fjs.parentNode.insertBefore(js, fjs);
		}
	}(document, 'script', 'twitter-wjs');</script>
