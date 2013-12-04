<?
get_header('meta');
get_header('navi');
?>

<div id="content" class="margin clearfix">
	<div id="main">
		<? global $wp_query; 
		$counter = (max(1, intval($wp_query->get('paged'))) - 1) * $wp_query->get('posts_per_page');
		if(have_posts()): ?>
			<div class="archive clearfix">
				<? while(have_posts()): the_post(); $counter++;?>
					<? if(!is_smartphone() && $counter <= 15  && false !== array_search($counter, array(5, 10, 15))): ?>
						<div class="archive-box google">
							<div class="post-type post-type-pr">
								<span class="post-type-label"><i class="fa-pushpin"></i>PR</span>
							</div>
							<p>
							<? google_ads(6);?>
							</p>
						</div>
					<? endif; ?>
					<? fumiki_loop_container(($counter % 6 == 0) ? 'forth' : '', false, 2, $counter); ?>
				<? endwhile; ?>
			</div><!-- .entry ends-->
		<? else: ?>
			<!-- 404 Not Found -->
			<article class="entry">
				<h2>該当する投稿はありませんでした</h2>
				<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>
				<ul>
					<li><a href="#s">検索フォーム</a>から別の言葉で探す</li>
					<li><a href="#menu">ページ上部左上のメニュー</a>から探す</li>
					<li><a href="<?= home_url('/inquiry/', 'https') ?>">メールフォーム</a>から問い合わせる</li>
					<li><a href="#footer-nav">フッター</a>にあるTwitterなどのリンクから問い合わせる</li>
				</ul>
			</article>
			<!-- 404 Not Found -->
		<? endif; ?>
		
		<? if(is_smartphone()): ?>
			<p class="center"><? google_ads(4); ?></p>
		<? endif; ?>
			
		<? get_sidebar(); ?>
		
	</div>
	<!-- #main ends -->
	
</div>

<?
get_footer();