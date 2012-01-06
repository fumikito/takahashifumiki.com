<?php
$theme_dir = "/wp-content/themes/takahashifumiki/";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>メンテナンス中｜高橋文樹.com</title>
    <link rel="stylesheet" href="<?php echo $theme_dir; ?>style.css" type="text/css" />
    <?php if($_SERVER["SERVER_NAME"] == "takahashifumiki.com" || $_SERVER['SERVER_NAME'] == '_'): ?>
    <!-- Google Analytics // -->
	<script type="text/javascript">
	//<![CDATA[
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-5329295-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	//]]>
	</script>
	<!-- // Google Analytics -->
	<?php endif; ?>
</head>
<body>
	<div id="header" class="margin dark_bg">
		<div id="logo">
			<a rel="home" href="http://takahashifumiki.com">
				<img src="<?php echo $theme_dir; ?>/img/header-logo.png" alt="高橋文樹.com" width="380" height="40" />
			</a>
			<p class="shadow">小説家高橋文樹が自ら情報を発信するブログです。</p>
		</div>
	</div>

	<div id="error404">
		<div class="container">
			<h1>
				<span>503: Service Unavailable</span>
				<br />
			    <small>
					<?php 
					$mamo_msg = $this->mamo_template_tag_message();
					?>
					<?php echo preg_replace('/<h1.*h1>/', '', $mamo_msg); ?>
			    </small>
			</h1>
		</div>
		<!-- .container ends -->
	</div>
	<!-- .error404 ends -->
	
	<div id="footer" class="dark_bg shadow">
		<div id="copy-note" class="margin mono clearfix divider">
			<p>
				&copy; 2008-<?php echo date('Y'); ?> Takahashi Fumiki
			</p>
			<p class="poweredby">
				Proudly powered by <a href="http://wordpress.org">WordPress</a>.
			</p>
		</div><!-- .copy ends-->
	</div>
</body>
</html>