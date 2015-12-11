<?php
$theme_dir = '/wp-content/themes/takahashifumiki/';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>メンテナンス中｜高橋文樹.com</title>
	<link rel="stylesheet" href="<?php echo $theme_dir; ?>styles/stylesheets/core.css" type="text/css"/>
	<meta name="Viewport" content="width=320"/>
	<?php if ( 'takahashifumiki.com' === $_SERVER['SERVER_NAME'] || '_' === $_SERVER['SERVER_NAME'] ) : ?>
		<!-- Google Analytics // -->
		<script type="text/javascript">
			//<![CDATA[
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-5329295-1']);
			_gaq.push(['_trackPageview']);

			(function () {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();
			//]]>
		</script>
		<!-- // Google Analytics -->
	<?php endif; ?>
</head>
<body>
<div id="error404">
	<div class="logo center">
		<a rel="home" href="http://takahashifumiki.com">
			<img src="<?= $theme_dir; ?>/img/header-logo-big.png" alt="高橋文樹.com" width="380" height="40"/>
		</a>

		<p class="description">小説家高橋文樹が自ら情報を発信するブログです。</p>
	</div>
	<?= $mamo_msg = $this->mamo_template_tag_message(); ?>
	<div id="copy-note" class="center">
		<p>
			&copy; 2008-<?= date( 'Y' ); ?> Takahashi Fumiki
		</p>
	</div><!-- .copy ends-->
</div>
<!-- .error404 ends -->
</body>
</html>