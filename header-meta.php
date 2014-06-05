<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <? language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <? language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <? language_attributes(); ?>>
<!--<![endif]--><head>
	<meta charset="<? bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><? wp_title(" | ", true, 'right'); bloginfo('name'); if(is_front_page()) echo " | ".get_bloginfo('description'); ?></title>
<? wp_head(); ?>
<link rel="alternate" type="application/rss+xml" href="<? bloginfo('rss2_url'); ?>" title="高橋文樹.com 最新の投稿" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<? bloginfo( 'pingback_url' ); ?>" />
</head>
<body <? body_class(''); ?>>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=264573556888294";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>