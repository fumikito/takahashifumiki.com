<?php
define('moo_dir',get_bloginfo('template_directory')."/mootools/");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="author" content="Valerio Proietti, mad4milk(translated by Takahashi Fumiki)" />
	<meta name="copyright" content="copyright 2006 www.mad4milk.net" />
	<meta name="description" content="mootools-超軽量のweb2.0 javascriptフレームワーク-のAPIドキュメントです。" />
	<meta name="keywords" content="mootools,moo.fx,javascript effects,javascript framework,ajax framework,moo.ajax" />
	<meta name="robots" content="all" />

	<!--

               ____        _                      __  __      __   __
   ___   __   / __'¥     _¥'¥      __   ___   __ /¥_¥/¥ ¥    /¥ ¥ / /  web 2.0 beta
  /¥  ¥_/ '¥ /¥ ¥Z¥ ¥   / __ ¥    /__¥ /¥  ¥_/ '¥¥/_/¥ ¥ ¥   ¥ ¥ ¥ /__
  ¥ ¥  __/¥ ¥¥ ¥  __ ¥ /¥ ¥Z¥ ¥  / ¥Z¥¥¥ ¥  __/¥ ¥  __¥ ¥ ¥___¥ ¥  _ '¥
   ¥ ¥_¥ ¥ ¥_¥¥ ¥_¥ ¥ ¥¥ ¥_____¥/¥____ ¥¥ ¥_¥ ¥ ¥_¥/¥ ¥¥ ¥____¥¥ ¥_¥ ¥_¥
    ¥/_/  ¥/_/ ¥/_/¥/_/ ¥/_____/¥/___/¥_¥¥/_/  ¥/_/¥ ¥_¥¥/____/ ¥/_/¥/_/
                                     ¥/_/           ¥/_/       be happy.

	-->

	<title><?php $fumiki->title(); ?></title>

	<!-- Shortcut Icons -->
	<link href="<?php echo moo_dir; ?>img/favicon.ico" rel="shortcut icon" type="image/x-icon" />

	<!-- StyleSheets -->
	<link href="<?php echo $fumiki->template; ?>/css/moo_style.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo $fumiki->template; ?>/css/moo_print.css" rel="stylesheet" type="text/css" media="print" />

	<!-- RSS -->
	<link rel="alternate" type="application/rss+xml" title="高橋文樹.com最新エントリー" href="<?php $fumiki->feed(); ?>"/>

</head>
<body>

<div id="header">

	<div class="container">
		<a href="http://ja.wordpress.org" id="mediatemple"><span>Template created by WordPress</span></a>

		<div id="logo">
			<h1><a href="<?php echo $fumiki->root; ?>/topics/web/mootools"><span>MooTools</span></a></h1>
			<h2><span>軽量のJavascriptフレームワーク</span></h2>
		</div><!--logo ends-->

		<ol id="navigation">
			<li class="first"><a href="<?php bloginfo('url'); ?>/topics/web/mootools">ホーム</a></li>
			<li><a href="<?php echo $fumiki->root; ?>/web/mootools/294">ダウンロード</a></li>
			<li><a href="<?php echo $fumiki->root; ?>/web/mootools/152">ドキュメント</a></li>
			<li><a href="<?php echo $fumiki->root; ?>/web/172">アバウト</a></li>
			<li><a href="http://demos.mootools.net">デモ</a></li>
		</ol><!--navigation ends-->

	</div><!--container ends-->

</div><!--header ends-->

<div id="google-search-box">
	<div class="container" id="google-search">
		<span>入力したらエンターを押してください。</span>
		<input id="google-input" type="text" value="キーワードを入れてください" />
		<div id="result_box"></div>
	</div>
</div><!--google-search-box ends-->


<div id="wrapper">

<div class="container">