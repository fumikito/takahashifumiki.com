<footer class="dark_bg shadow">
	
	<div id="footer-nav" class="margin sans clearfix">

		<div class="grid_4 first">
			<?php $admin = get_userdata(1); ?>
			<div class="inner">
				<h4 class="mono">
					<i class="icon-user"></i>
					About me
				</h4>
				<div class="admin-name sans">
					<?php echo get_avatar(1, 100); ?>
					<?php echo $admin->display_name; ?>
				</div>
				<blockquote class="clrB">
					<i class="first"></i>
					<?php echo wpautop($admin->description);?>
					<i class="last"></i>
				</blockquote>
				<p class="center">
					<a class="button mono" href="<?php echo home_url('/about/'); ?>">
						<i class="icon-question-sign"></i>Want to know more?
					</a>
				</p>
			</div><!-- //.inner -->
			
			<h4 class="mono second">
				<i class="icon-twitter"></i>
				Recent tweet
			</h4>
			<blockquote class="clearfix left">
				<?php if(($tweet = get_twitter_timeline(1))): ?>
					<?php foreach($tweet as $t): ?>
					<blockquote>
						<i class="first"></i>
						<p><?php echo tweet_linkify($t->text); ?></p>
						<i class="last"></i>
						<cite>
							<a href="https://twitter.com/takahashifumiki/status/<?php echo $t->id_str;?>" target="_blank">
								<?php echo date('M jS Y(D) H:i', strtotime($t->created_at)); ?>&nbsp;
							</a>
						</cite>
					</blockquote>
					<small>
					</small>
					<?php break; endforeach; ?>
				<?php else: ?>
					つぶやきを取得できませんでした。
				<?php endif; ?>
			</blockquote>
			<p class="center">
				<a href="https://twitter.com/takahashifumiki" class="button mono" target="_blank">
					<i class="icon-twitter"></i>
					Follow me on Twitter!
				</a>
			</p>
		</div>

		<div class="grid_4">
			
			<h4 class="mono next">
				<i class="icon-facebook"></i>
				My Facebook Page
			</h4>
			<div class="like-box-container">
				<div class="fb-like-box" data-href="http://www.facebook.com/takahashifumiki.page" data-width="292" data-height="420" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-border-color="#3F464D" data-header="false"></div>
			</div>
		</div>


		<div class="grid_4 last">
			
			<h4 class="mono next">
				<i class="icon-globe"></i>
				My Web sites
			</h4>
			<ol class="inner">
				<li><a class="hametuha one-line" target="_blank" href="http://hametuha.com/author/takahashi_fumiki/">破滅派 | 文芸誌</a></li>
				<li><a class="hametuha-inc one-line" target="_blank" href="http://hametuha.co.jp">株式会社破滅派</a></li>
				<li><a class="minicome one-line" target="_blank" href="http://minico.me">ミニコme! | ミニコミ誌販売ポータル</a></li>
			</ol>
			
			<h4 class="mono second">
				<i class="icon-search"></i>
				Find me at
			</h4>
			<ol class="inner no-text clearfix">
				<li><a target="_blank" class="facebook" href="https://www.facebook.com/TakahashiFumiki.Page">Facebook</a></li>
				<li><a target="_blank" class="twitter" href="https://twitter.com/#!/takahashifumiki">twitter</a></li>
				<li><a target="_blank" class="google" href="https://plus.google.com/u/0/108058172987021898722/posts">Google+</a></li>
				<li><a target="_blank" class="youtube" href="http://www.youtube.com/user/takahashifumiki">Youtube</a></li>
				<li><a target="_blank" class="github" href="https://github.com/fumikito">Github</a></li>
				<li><a target="_blank" class="foursquare" href="https://ja.foursquare.com/takahashifumiki">foursquare</a></li>
				<li><a target="_blank" class="instagram" href="http://listagr.am/n/takahashifumiki">Instagram</a></li>
			</ol>
			
			<h4 class="mono second">
				<i class="icon-envelope"></i>
				Contact
			</h4>
			<ol class="inner">
				<li class="contact clearfix">
					<i class="icon-warning-sign icon-large"></i>
					執筆・Web制作のお仕事については<a href="<?php echo home_url('/inquiry/', 'https'); ?>">お問い合わせフォーム</a>よりご連絡下さい。
					なるべく早くお返事します。
				</li>
				<li><a class="mail" href="<?php echo home_url('/inquiry/', 'https'); ?>">お問い合わせ</a></li>
				<li><a class="feed" href="<?php bloginfo('rss_url'); ?>">RSSフィード</a></li>
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
			My theme v<?php echo fumiki_theme_version(); ?> is DIYed :)
		</p>
		<p class="center">
			&copy; 2008-<?php echo date_i18n('Y'); ?> Takahashi Fumiki
		</p>
	</div><!-- .copy ends-->
	
</footer>
<!-- #footer ends -->

<div id="tip-container">
	<table>
		<tr>
			<th>
				<i class="icon-info-sign"></i>
			</th>
			<td class="content">
			</td>
		</tr>
		<tr class="close-button">
			<td colspan="2" class="right"><button>X</button></td>
		</tr>
	</table>
</div>
<?php wp_footer(); ?>
</body>
</html>