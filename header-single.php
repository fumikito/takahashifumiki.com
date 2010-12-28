<div id="header" class="clearfix">
	<a id="logo" rel="home" href="<?php bloginfo("url"); ?>">
		<img src="<?php bloginfo('template_directory'); ?>/img/single_header_h1.gif" alt="<?php bloginfo("name"); ?>" width="196" height="61" />
	</a>
	<p class="desc old">
		<?php bloginfo('description'); ?>
	</p>
	<div id="breadcrumb">
		<?php if(function_exists('bcn_display')) bcn_display(); ?>
	</div>
	<a id="toTop"></a>
	
	<div id="navi">
		<ol class="mincho clearfix">
			<li>
				<a rel="home" href="<?php bloginfo('url'); ?>">
					ホーム<br />
					<span class="old">Home</span>
				</a>
			</li>
			<li<?php if(is_page("about")) echo ' class="current"'; ?>>
				<a href="<?php bloginfo('url'); ?>/about">
					あばうと<br />
					<span class="old">About</span>
				</a>
			</li>
			<li<?php if(is_page("ebooks") || "ebook" == get_post_type()) echo ' class="current"';?>>
				<a href="<?php bloginfo('url'); ?>/ebooks">
					電子書籍<br />
					<span class="old">eBooks</span>
				</a>
			</li>
			<li<?php if(in_category("告知") || is_category("告知")) echo ' class="current"';?>>
				<a href="<?php echo get_category_link(get_cat_ID('告知')); ?>">
					告知<br />
					<span class="old">Notice</span>
				</a>
			</li>
			<li<?php if(in_category("文芸活動") || is_category("文芸活動")) echo ' class="current"';?>>
				<a href="<?php echo get_category_link(get_cat_ID('文芸活動')); ?>">
					文芸活動<br />
					<span class="old">Literature</span>
				</a>
			</li>
			<li<?php if(in_category("Web制作") || is_category("Web制作")) echo ' class="current"';?>>
				<a href="<?php echo get_category_link(get_cat_ID('Web制作')); ?>">
					Web制作<br />
					<span class="old">Web Creation</span>
				</a>
			</li>
			<li<?php if(in_category("その他") || is_category("その他")) echo ' class="current"';?>>
				<a href="<?php echo get_category_link(get_cat_ID('その他')); ?>">
					その他<br />
					<span class="old">Others</span>
				</a>
			</li>
			<li<?php if(is_page("inquiry")) echo ' class="current"';?>>
				<a href="<?php bloginfo('url'); ?>/inquiry">
					お問い合わせ<br />
					<span class="old">Inquiry</span>
				</a>
			</li>
		</ol>
		
		<ul id="account" class="right sans">
		<?php
			// FIXME: 隙間ができるのを回避するため、一行で書いてます
			if(is_user_logged_in()):
		?>
			<li><a class="first green" href="<?php echo bloginfo("url"); ?>/book-shelf/">本棚</a></li><?php
			?><li><a class="blue" href="<?php echo bloginfo("url"); ?>/login/?action=profile">登録情報</a></li><?php
			?><li><a class="red" href="<?php echo wp_logout_url(get_bloginfo('url'));?>">ログアウト</a></li>
		<?php else: ?>
			<li><a class="first blue" href="<?php bloginfo("url"); ?>/login/?redirect_to=<?php echo rawurlencode($_SERVER['REQUEST_URI']); ?>">ログイン</a></li><?php
			?><li><a class="red" href="<?php bloginfo("url"); ?>/login/?action=register">新規登録</a></li>
		<?php endif; ?>
		</ul>
		<!-- #account ends -->
		
		<div id="message">
			<p class="right"><?php do_echo(); ?></p>
		</div>
		<!-- #message ends -->
		
	</div>
	<!-- #navi ends -->
</div>
<!-- #header ends-->
