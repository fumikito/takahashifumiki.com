<?php
/*
 * Template Name:Facebook
 */
the_post();
$facebook = fb_init();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:mixi="http://mixi-platform.com/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php wp_title("|", true, 'right'); bloginfo('name'); ?></title>
<meta name="author" content="Takahashi Fumiki" />
<meta name="copyright" content="copyright 2008- takahashifumiki.com" />
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="高橋文樹.com 最新の投稿" />
<link rel="pingback" href="<?php bloginfo('url'); ?>/xmlrpc.php" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php ssl_template_directory(); ?>/style.css?version=<?php echo FUMIKI_VERSION; ?>" />
</head>
<body <?php body_class(''); ?>>
	<div class="margin">
		<div class="meta">
			<?php if(fb_is_like_me()): ?>
			<p>いいねありがとうございます！</p>
			<?php else: ?>
			<p>上の<img onclick="alert('これじゃなくて、この上のやつです。');" src="<?php ssl_template_directory(); ?>/img/icon-facebook.png" alt="いいね！" width="76" height="26" />を押してもらえると大変嬉しいです。</p>
			<?php endif; ?>
			<h1 class="title mincho"><?php the_title(); ?></h1>
		</div>
		<div class="entry">
			<?php the_content();?>
		</div>
	</div>
	<script type="text/javascript" src="//connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript">
	//<![CDATA[
	if(self == top){
		window.location.href = "http://takahashifumiki.com";
	}
	FB.init({
		appId : '264573556888294',
		status : true,
		cookie : true,
		xfbml : true
	});
	window.fbAsyncInit = function() {
		FB.Canvas.setSize();
	}
	function sizeChangeCallback() {
		FB.Canvas.setSize();
	}
	//]]>
	</script>
</body>
</html>