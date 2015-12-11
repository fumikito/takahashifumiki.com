<?php get_header(); ?>

	<div class="margin search-block">
		<?php get_search_form(); ?>
	</div>

	<div id="content" class="margin clearfix">
		<div id="main">
			<?php if ( have_posts() ) : ?>

				<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi() ?>

				<ol class="post-list post-list-large">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'templates/loop', get_post_type() ); ?>
					<?php endwhile; ?>
				</ol><!-- .entry ends-->

				<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi() ?>


			<?php else : ?>
				<!-- 404 Not Found -->
				<article class="entry">
					<h2>該当する投稿はありませんでした</h2>

					<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>
					<ul>
						<li><a href="#sorter">検索フォーム</a>から別の言葉で探す</li>
						<li><a href="#menu">ページ上部左上のメニュー</a>から探す</li>
						<li><a href="<?= home_url( '/inquiry/', 'https' ) ?>">メールフォーム</a>から問い合わせる</li>
						<li><a href="#footer-nav">フッター</a>にあるTwitterなどのリンクから問い合わせる</li>
					</ul>
				</article>
				<!-- 404 Not Found -->
			<?php endif; ?>

			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- 高橋文樹スマートフォン上 -->
			<ins class="adsbygoogle"
			     style="display:block; margin-top: 20px;"
			     data-ad-client="ca-pub-0087037684083564"
			     data-ad-slot="9969902841"
			     data-ad-format="auto"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>



		</div>
		<!-- #main ends -->
	</div>
<?php get_template_part( 'templates/single', 'ebook' ); ?>

<?php
get_footer( 'hametuha' );
get_footer();