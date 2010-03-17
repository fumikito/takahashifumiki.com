<?php
header("HTTP/1.0 404 Not Found");
get_header();
?>

<div id="error404">
<a rel="home" href="<?php bloginfo('url'); ?>" class="logo"><img alt="高橋文樹.com" src="<?php echo $fumiki->template; ?>/img/body_h1.gif"></a>
<div class="container">
<h1>
	<span>404: Page Not Found.</span><br />
	<small>お探しのページは見つかりませんでした。</small>
</h1>
<form action="<?php echo $fumiki->root; ?>" method="get" id="search" name="search">
	<div id="s_form">
		<input id="s" name="s" type="text" value="&raquo;入力してください" /><input id="submit" type="image" name="submit" alt="検索する" src="<?php echo $fumiki->template; ?>/img/body_btn_search.gif" value="検索する" />
	</div>
</form>
</div>
</div>
<?php get_footer(); ?>