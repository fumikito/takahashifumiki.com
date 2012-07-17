<div id="footer" class="dark_bg shadow">
	
	<div id="footer-nav" class="margin sans clearfix">
		<div class="grid_4">
			<?php $admin = get_userdata(1); ?>
			<div class="inner">
				<h4 class="mono second">About me</h4>
				<?php echo get_avatar(1, 48); ?>
				<div class="admin-name">
				<?php echo $admin->display_name; ?>
				</div>
				<blockquote class="clrB">
					<i class="first"></i>
					<?php echo wpautop($admin->description);?>
					<i class="last"></i>
				</blockquote>
				<p class="center">
					<a class="button mono" href="<?php echo home_url('/about/'); ?>">Want to know more?</a>
				</p>
			</div>
			<h4 class="mono second">Recent tweet</h4>
			<blockquote class="clearfix left">
				<i class="tweet"></i>
				<?php if(($tweet = get_twitter_timeline(1))): ?>
					<?php foreach($tweet as $t): ?>
						<p class="tweet"><?php echo tweet_linkify($t->text); ?></p>
						<small>
							<a href="https://twitter.com/takahashifumiki/status/<?php echo $t->id_str;?>" target="_blank">
								<?php echo date('M jS Y(D) H:i', strtotime($t->created_at)); ?>&nbsp;
							</a>
						</small>
					<?php endforeach; ?>
				<?php else: ?>
					つぶやきを取得できませんでした。
				<?php endif; ?>
			</blockquote>
			<p class="center">
				<a href="https://twitter.com/takahashifumiki" class="button mono" target="_blank">Follow me on Twitter!</a>
			</p>
		</div>
		
		<div class="grid_4">
			<?php dynamic_sidebar('フッター右端'); ?>
		</div>
		
		<div class="grid_4">
			<h4 class="mono second">Find me at</h4>
			<ol class="inner no-text clearfix">
				<li><a target="_blank" class="facebook" href="https://www.facebook.com/TakahashiFumiki.Page">Facebook</a></li>
				<li><a target="_blank" class="twitter" href="https://twitter.com/#!/takahashifumiki">twitter</a></li>
				<li><a target="_blank" class="google" href="https://plus.google.com/u/0/108058172987021898722/posts">Google+</a></li>
				<li><a target="_blank" class="youtube" href="http://www.youtube.com/user/takahashifumiki">Youtube</a></li>
				<li><a target="_blank" class="github" href="https://github.com/fumikito">Github</a></li>
				<li><a target="_blank" class="foursquare" href="https://ja.foursquare.com/takahashifumiki">foursquare</a></li>
				<li><a target="_blank" class="instagram" href="http://listagr.am/n/takahashifumiki">Instagram</a></li>
				<li><a target="_blank" class="linkedin" href="http://www.linkedin.com/pub/<?php echo rawurlencode('文樹-高橋'); ?>/41/5b4/a54">Linkedin</a></li>
			</ol>
			<h4 class="mono second next">My Web sites</h4>
			<ol class="inner">
				<li><a class="hametuha" href="http://hametuha.com/author/takahashi_fumiki/">破滅派 | 文芸誌</a></li>
				<li><a class="hametuha" target="_blank" href="http://hametuha.co.jp">株式会社破滅派</a></li>
			</ol>
		</div>
		
		<div class="grid_4">
			<h4 class="mono second">Contact me with</h4>
			<ol class="inner">
				<li><a class="mail" href="<?php echo home_url('/inquiry/', 'https'); ?>/inquiry/">お問い合わせ</a></li>
				<li><a class="feed" href="<?php bloginfo('rss_url'); ?>">RSSフィード</a></li>
				<li class="contact">執筆・Web制作のお仕事については<a href="<?php echo home_url('/inquiry/', 'https'); ?>">お問い合わせフォーム</a>よりご連絡下さい。</li>
			</ol>
			<?php fumiki_nakanohito(); ?>
		</div>
		
	</div>
	<!-- #footer-nav ends -->
	
	<div id="copy-note" class="margin mono clearfix divider">
		<p>
			Proudly powered by <a href="http://wordpress.org">WordPress</a>.
		</p>
		<p class="poweredby">
			Theme is DIYed :)
		</p>
		<p class="center">
			&copy; 2008-<?php echo date('Y'); ?> Takahashi Fumiki
		</p>
	</div><!-- .copy ends-->
</div>
<!-- #footer ends -->
<?php wp_footer(); ?>
</body>
</html>