<div id="footer" class="dark_bg shadow">
	<div id="footer-post" class="margin sans clearfix">
		<div class="grid_4">
			<h4 class="mono">Recent Entries</h4>
			<ul class="sans">
				<?php $recent = new WP_Query("posts_per_page=5"); if($recent->have_posts()) while($recent->have_posts ()): $recent->the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?><br /><small><?php the_date(); ?></small>
					</a>
				</li>
				<?php endwhile;?>
			</ul>
		</div>
		
		<div class="grid_4">
			<h4 class="mono">Hatena Hot Entries</h4>
			<?php fumiki_hotentry(); ?>
		</div>
		
		<div class="grid_4">
			<h4 class="mono">Hatena Popular</h4>
			<?php fumiki_hotentry("", "count", false); ?>
		</div>
		
		<div class="grid_4">
			<?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar('フッター右端');  ?>
		</div>
	</div>
	
	<div id="footer-nav" class="margin sans clearfix divider">
		<div class="grid_4">
			<?php $admin = get_userdata(1); ?>
			<div class="inner">
				<h4 class="mono">About me</h4>
				<?php echo get_avatar(1, 48); ?>
				<div class="admin-name">
				<?php echo $admin->display_name; ?>
				</div>
				<div class="profile clrB">
				<?php echo wpautop($admin->description);?>
				</div>
			</div>
			<h4 class="mono second">Find me at</h4>
			<ol class="inner no-text clearfix">
				<li><a class="facebook" href="http://www.facebook.com/takahashifumiki">Facebook</a></li>
				<li><a class="twitter" href="https://twitter.com/#!/takahashifumiki">twitter</a></li>
				<li><a class="google" href="https://plus.google.com/114216546098171717764/posts">Google+</a></li>
				<li><a class="youtube" href="http://www.youtube.com/user/takahashifumiki">Youtube</a></li>
				<li><a class="github" href="https://github.com/fumikito">Github</a></li>
			</ol>
			<h4 class="mono second">Contact me with</h4>
			<ol class="inner">
				<li><a class="mail" href="<?php bloginfo('url'); ?>/inquiery/">お問い合わせ</a></li>
				<li><a class="feed" href="<?php bloginfo('rss_url'); ?>">RSSフィード</a></li>
			</ol>
		</div>
		
		<div class="grid_4">
			<h4 class="mono">Follow me @ twitter</h4>
			<?php fumiki_twitter(); ?>
			<a href="http://twitter.com/takahashifumiki" class="twitter-follow-button" data-button="grey" data-text-color="#FFFFFF" data-link-color="#00AEFF" data-show-count="false" data-lang="ja">Follow @takahashifumiki</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
		</div>

		<div class="grid_4">
			<h4 class="mono">Main Pages</h4>
			<?php wp_nav_menu( array( 'theme_location' => 'main-pages','container_class' => 'main-page')); ?>
			<h4 class="mono second">Monthly Archive</h4>
			<select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
				<option value="">月別投稿の一覧</option> 
				<?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?>
			</select>
		</div>

		<div class="grid_4">
			<h4 class="mono">Categories</h4>
			<ul>
			<?php wp_list_cats("show_count=0&depth=2&hierarchical=1&exclude=47"); ?>
			</ul>
		</div>
	</div>
	<!-- #footer-nav ends -->
	
	<div id="copy-note" class="margin mono clearfix divider">
		<p>
			&copy; 2008-<?php echo date('Y'); ?> Takahashi Fumiki
		</p>
		<p class="poweredby">
			Proudly powered by <a href="http://wordpress.org">WordPress</a>.
		</p>
		
	</div><!-- .copy ends-->
	
</div>
<!-- #footer ends -->

<?php wp_footer(); ?>
</body>
</html>