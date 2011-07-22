<?php
global $fumiki;
$fumiki->xml(); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:mixi="http://mixi-platform.com/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta property="fb:admins" content="1034317368" />
	<title><?php $fumiki->title(); ?></title>
	<meta name="author" content="Takahashi Fumiki" />
	<meta name="copyright" content="copyright 2008- takahashifumiki.com" />
	<meta name="description" content="<?php $fumiki->desc(); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php $fumiki->feed(); ?>" title="高橋文樹.com latest posts" />
	<link rel="pingback" href="<?php echo $fumiki->root; ?>/xmlrpc.php" />
	<link rel="shortcut icon" href="<?php echo $fumiki->template; ?>/img/favicon.ico" />
	<?php wp_head(); ?>
</head>
<body<?php $fumiki->body(); ?>>
