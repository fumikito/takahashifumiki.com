<?
get_header('meta');
get_header('navi');
?>

<div id="content" class="margin clearfix">
	<div id="main">
		<? global $wp_query; 
		$counter = (max(1, intval($wp_query->get('paged'))) - 1) * $wp_query->get('posts_per_page');
		if(have_posts()): ?>
			<? if(function_exists('wp_pagenavi')) wp_pagenavi() ?>
			<ol class="post-list post-list-large">
				<? while(have_posts()): the_post(); $counter++;?>
					<? get_template_part('templates/loop', get_post_type()); ?>
				<? endwhile; ?>
			</ol><!-- .entry ends-->
			<? if(function_exists('wp_pagenavi')) wp_pagenavi() ?>
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
			

	</div>
	<!-- #main ends -->
	<div id="sidebar">
		<? get_sidebar(); ?>
	</div>
</div>

<?
get_footer();