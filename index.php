<?php get_header(); ?>
	<div class="container container-main">
		<div class="row">

			<div class="page-header">

				<p class="page-header-image">
					<img class="page-header-src" alt="<?php bloginfo( 'name' ); ?>"
					     src="<?= get_template_directory_uri(); ?>/assets/img/logo-front-page.png"
					     width="200" height="200"/>
				</p>

				<h1 class="page-header-text"><?php the_archive_title() ?></h1>

			</div>

			<article id="main" class="col-xs-12 col-md-9">

				<?php get_search_form(); ?>

				<?php get_template_part( 'templates/single', 'ad' ) ?>

				<?php if ( have_posts() ) : ?>

					<?php if ( function_exists( 'wp_pagenavi' ) ) {
						wp_pagenavi();
					} ?>

					<ol class="post-loop-list large">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/loop', 'large' ); ?>
						<?php endwhile; ?>
					</ol><!-- .entry ends-->

					<?php if ( function_exists( 'wp_pagenavi' ) ) {
						wp_pagenavi();
					} ?>


				<?php else : ?>
					<!-- 404 Not Found -->
					<div class="entry">

						<h2>該当する投稿はありませんでした</h2>

						<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>

						<ul>
							<li><a href="#sorter">検索フォーム</a>から別の言葉で探す</li>
							<li>ページ上部のメニューから探す</li>
							<li><a href="<?= home_url( '/inquiry/', 'https' ) ?>">メールフォーム</a>から問い合わせる</li>
							<li>フッターにあるTwitterやFacebookメッセージなどのリンクから問い合わせる</li>
						</ul>

					</div>
					<!-- 404 Not Found -->
				<?php endif; ?>

				<div class="mb">

				<p class="ad-title">SPONSORED LINK</p>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- 高橋文樹レスポンシブフッター上 -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-0087037684083564"
				     data-ad-slot="9343442847"
				     data-ad-format="auto"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
				</div>

				<?php get_template_part( 'templates/list', 'general' ) ?>
				
			</article>
			<!-- #main ends -->
			<aside class="col-xs-12 col-md-3 sidebar">
				<?php get_sidebar() ?>
			</aside>

		</div><!-- //.row -->

	</div><!-- container -->

<?php get_footer();
