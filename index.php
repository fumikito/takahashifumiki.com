<?
get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main">
		<? get_search_form(); ?>
		<div class="archive clearfix">
			<? $counter = 0;if(have_posts()): while(have_posts()): the_post(); $counter++;?>
				
				<? if(!is_smartphone() && false !== array_search($counter, array(7, 13, 19))): ?>
					<p class="center google clrB"><? google_ads(2);?></p>
				<? endif; ?>
					
				<? fumiki_loop_container(($counter % 6 == 0) ? 'forth' : ''); ?>
				<? if(!is_smartphone() && $counter % 6 == 0): ?>
					<div class="clrB"></div>
				<? endif; ?>
			<? endwhile; else: ?>
			<!-- ▼投稿無し -->
			<div class="entry">
				<h2>該当する投稿はありませんでした</h2>
				<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>
				<ul>
					<li>ページ最上部にある<a href="#s">検索フォーム</a>から別の言葉で探す</li>
					<li><a href="#menu">ページ上部左上のメニュー</a>から探す</li>
					<li><a href="<?= home_url('/inquiry/', 'https') ?>">メールフォーム</a>から問い合わせる</li>
					<li><a href="#footer-nav">フッター</a>にあるTwitterなどのリンクから問い合わせる</li>
				</ul>
			<!-- ▲投稿無し -->
			</div>
			<? endif; ?>
		</div><!-- .entry ends-->

		<div id="page_finish" class="mono clrB">
			<? if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<!-- #page_finish -->
		
		<? get_sidebar(); ?>
		
	</div>
	<!-- #main ends -->
	
</div>

<?
get_footer();