<footer class="footer">

	<div id="footer-nav" class="container">

		<div class="row">

			<!-- About -->
			<div class="col-xs-12 col-md-4">
				<div class="footer-content">

					<?php $admin = get_userdata( 1 ); ?>
					<h3 class="footer-title">
						<i class="fa fa-user"></i>
						作者について
					</h3>

					<div class="admin-name">
						<img src="<?= get_template_directory_uri() ?>/assets/img/brand/messenger_code.png" alt="高橋文樹" class="footer-profile img-responsive" />
						<?= wpautop( sprintf( '<strong>%s: </strong>%s', $admin->display_name, $admin->description ) ); ?>

						<p class="center">
							<a class="btn btn-default btn-block btn-raised" href="<?php echo home_url( '/about/' ); ?>">
								詳しく <i class="fa fa-chevron-right"></i>
							</a>
						</p>
					</div>
				</div><!-- //.footer-content -->

				<div class="footer-content">
				<h3 class="footer-title">
					<i class="fa fa-envelope"></i>
					お問い合わせ
				</h3>
				<p class="footer-contact">
					執筆・Web制作のお仕事については<a href="<?php echo home_url( '/inquiry/', 'https' ); ?>">お問い合わせフォーム</a>よりご連絡下さい。
					なるべく早くお返事します。
					Facebookページのメッセージでもお返事致します。プロフィール画像をスキャンしてください。
				</p>
				</div>
			</div><!-- //.grid_4 -->


			<div class="col-xs-12 col-md-4">

				<div class="footer-content">

					<h3 class="footer-title">
						<i class="fa fa-globe"></i>
						関連のあるサイト
					</h3>
					<ol class="nav nav-pills nav-stacked">
						<?php foreach ( [
							'破滅派 | オンライン文芸誌' => 'https://hametuha.com/doujin/detail/takahashi_fumiki/',
						    '株式会社破滅派' => 'https://hametuha.co.jp/',
						    'Amazon著者ページ' => 'http://www.amazon.co.jp/%E9%AB%98%E6%A9%8B-%E6%96%87%E6%A8%B9/e/B004LU3VVK',
						] as $label => $url ) : ?>
						<li>
							<a target="_blank" href="<?= $url ?>">
								<?= esc_html( $label ) ?>
							</a>
						</li>
						<?php endforeach; ?>
					</ol>
				</div>

				<div class="footer-content">

				<h3 class="footer-title">
					<i class="fa fa-search"></i>
					SNSなど
				</h3>
				<div class="row footer-social">
					<?php foreach ( [
						'facebook' => 'https://www.facebook.com/TakahashiFumiki.Page',
						'twitter' => 'https://twitter.com/#!/takahashifumiki',
						'google-plus' => 'https://plus.google.com/108058172987021898722?rel=author',
						'youtube-play' => 'https://www.youtube.com/user/takahashifumiki',
						'github' => 'https://github.com/fumikito',
						'foursquare' => 'https://ja.foursquare.com/takahashifumiki',
						'instagram' => 'http://listagr.am/n/takahashifumiki',
						'linkedin' => 'http://www.linkedin.com/pub/'. rawurlencode( '文樹-高橋' ) .'/41/5b4/a54',

					] as $brand => $url ) : ?>
					<div class="col-xs-3 text-center footer-social-btn">
						<a class="btn btn-default btn-fab" href="<?= $url ?>" target="_blank"><i class="fa fa-<?= $brand ?>"></i></a>
					</div>
					<?php endforeach; ?>
				</div>
				</div>

				<div class="footer-content hidden-xs hidden-sm">
					<h3 class="footer-title">
						<i class="fa fa-twitter"></i>
						最近のつぶやき
					</h3>
						<?php if ( ( $tweet = get_twitter_timeline( 1 ) ) && is_array( $tweet ) ) : ?>
							<?php foreach ( $tweet as $t ) : ?>
								<blockquote class="footer-tweet">
									<p><?php echo tweet_linkify( $t->text ); ?></p>
									<p class="text-right">
										<cite>
											<a href="https://twitter.com/takahashifumiki/status/<?php echo $t->id_str; ?>"
											   target="_blank">
												<?php echo date( 'M jS Y(D) H:i', strtotime( $t->created_at ) ); ?>
												&nbsp;
											</a>
										</cite>
									</p>
								</blockquote>
								<?php break; endforeach; ?>
						<?php else : ?>
							つぶやきを取得できませんでした。
						<?php endif; ?>
				</div>

			</div><!-- //.grid_4 -->


			<div class="col-xs-12 col-md-4">

				<div class="footer-content">

				<h3 class="footer-title">
					<i class="fa fa-info-circle"></i> お読みください
				</h3>

				<?php wp_nav_menu( [
					'location' => 'main-pages',
					'container' => 'nav',
				    'container_class' => 'footer-menu',
				] ) ?>

				</div>

			</div>

		</div><!-- //.row -->

	</div>
	<!-- #footer-nav ends -->

	<hr />

	<div class="footer-copy container">

		<p class="footer-copy-text text-center">
			&copy; 2008 Takahashi Fumiki
		</p>

		<p class="footer-poweredby text-center">
			Proudly powered by <a href="http://wordpress.org">WordPress</a>.
			My theme Ver. <?php echo fumiki_theme_version(); ?> is DIYed :)
		</p>

	</div><!-- .copy ends-->

	<!-- フィルター用SVG -->
	<svg xmlns="http://www.w3.org/2000/svg" style="height: 0;">
		<filter id="blurFilter">
			<feGaussianBlur stdDeviation="7"/>
		</filter>
	</svg>
</footer>
<!-- #footer ends -->

<?php wp_footer(); ?>
</body>
</html>
