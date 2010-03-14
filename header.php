<?php $fumiki->xml(); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php $fumiki->title(); ?></title>
<meta name="author" content="Takahashi Fumiki" />
<meta name="copyright" content="copyright 2008- takahashifumiki.com" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="description" content="<?php $fumiki->desc(); ?>" />	<link rel="alternate" type="application/rss+xml" href="<?php $fumiki->feed(); ?>" title="高橋文樹.com latest posts" />
<link rel="pingback" href="<?php echo $fumiki->root; ?>/xmlrpc.php" />
<link rel="shortcut icon" href="<?php echo $fumiki->template; ?>/img/favicon.ico" />
<?php  $fumiki->canonical(); ?>
<?php
	if(is_singular()) wp_enqueue_script('comment-reply');
	//ob_start();
	wp_head();
	//$fumiki_headclean = ob_get_contents();
	//ob_end_clean();
	//$fumiki->clean($fumiki_headclean);
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fumiki->template; ?>/style1.1.css" />
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fumiki->template; ?>/css/ie.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $fumiki->template; ?>/css/ie6.css" />
<![endif]-->
</head>
<body<?php $fumiki->body(); ?>>