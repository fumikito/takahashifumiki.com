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
						<img src="<?= get_template_directory_uri() ?>/assets/img/brand/messenger_code.png" alt="高橋文樹"
							 class="footer-profile img-responsive"/>
						<?= wpautop( sprintf( '<strong>%s: </strong>%s', $admin->display_name, $admin->description ) ); ?>

						<p class="center">
							<a class="btn btn-default btn-block btn-raised" href="<?php echo home_url( '/about/' ); ?>">
								詳しく <i class="fa fa-chevron-right"></i>
							</a>
						</p>
					</div>
				</div><!-- //.footer-content -->
			</div><!-- //.grid_4 -->


			<div class="col-xs-12 col-md-4">


				<div class="footer-content">

					<h3 class="footer-title">
						<i class="fa fa-search"></i>
						SNSなど
					</h3>
					<div class="row footer-social">
						<?php foreach (
							[
								'facebook'     => 'https://www.facebook.com/TakahashiFumiki.Page',
								'twitter'      => 'https://twitter.com/#!/takahashifumiki',
								'youtube-play' => 'https://www.youtube.com/user/takahashifumiki',
								'github'       => 'https://github.com/fumikito',
								'instagram'    => 'http://listagr.am/n/takahashifumiki',
								'google-plus'  => 'https://plus.google.com/108058172987021898722?rel=author',
								'linkedin'     => 'http://www.linkedin.com/pub/' . rawurlencode( '文樹-高橋' ) . '/41/5b4/a54',
								'pinterest'    => 'https://www.pinterest.jp/fumikit/',

							] as $brand => $url
						) : ?>
							<div class="col-xs-3 text-center footer-social-btn">
								<a class="btn btn-default btn-fab" href="<?= $url ?>" target="_blank"><i
											class="fa fa-<?= $brand ?>"></i></a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

                <div class="footer-content">

                    <h3 class="footer-title">
                        <i class="fa fa-link"></i>
                        関連リンク
                    </h3>
                    <ol class="nav nav-pills nav-stacked">
						<?php foreach (
							[
								'破滅派 | オンライン文芸誌' => 'https://hametuha.com/doujin/detail/takahashi_fumiki/',
								'株式会社破滅派'            => 'https://hametuha.co.jp/',
								'ミニコミ誌販売サイト'      => 'https://minico.me',
								'Amazon著者ページ'          => 'https://www.amazon.co.jp/高橋-文樹/e/B004LU3VVK',
								'WordPressニュース'         => 'https://capitalp.jp',
							] as $label => $url
						) : ?>
                            <li>
                                <a target="_blank" href="<?= $url ?>">
									<?= esc_html( $label ) ?>
                                </a>
                            </li>
						<?php endforeach; ?>
                    </ol>
                </div>
			</div><!-- //.grid_4 -->


			<div class="col-xs-12 col-md-4">

				<div class="footer-content">

					<h3 class="footer-title">
						<i class="fa fa-amazon"></i> 高橋文樹先生の電子書籍
					</h3>

					<?php
					$feed = hametuha_kdp();
					shuffle( $feed );
					?>
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
							<?php for ( $i = 0, $l = count( $feed ); $i < $l; $i++ ) : ?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>" class="<?= $i ? '' : 'active' ?>"></li>
							<?php endfor ?>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
							<?php $counter = 0; foreach ( $feed as $item ) : ?>
                                <a class="item<?= $counter ? '' : ' active' ?>" href="<?= esc_url( $item['url'] ) ?>">
                                    <img src="<?= isset( $item['images']['medium'] ) ? $item['images']['medium'][0] : $item['image'] ?>"
                                         alt="<?= esc_attr( $item['title'] ); ?>">
                                    <div class="carousel-caption">
										<?= esc_attr( $item['title'] ); ?>
                                    </div>
                                </a>
								<?php $counter++; endforeach; ?>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>


                    <p>
                        <a class="btn btn-block btn-raised btn-link" target="_blank" rel="nofollow"
                           href="http://www.amazon.co.jp/gp/search?ie=UTF8&camp=247&creative=1211&index=aps&keywords=%E9%AB%98%E6%A9%8B%E6%96%87%E6%A8%B9&linkCode=ur2&tag=takahashifumiki-22">
                            <i class="fa fa-amazon"></i> Amazonで見る
                        </a>
                        <img
                                src="https://ir-jp.amazon-adsystem.com/e/ir?t=hametuha-22&l=ur2&o=9" width="1" height="1" border="0" alt=""
                                style="border:none !important; margin:0px !important;"/>
                    </p>

				</div>

			</div>

		</div><!-- //.row -->

	</div>
	<!-- #footer-nav ends -->

	<hr/>

	<div class="footer-copy container">

		<p class="footer-copy-text text-center">
			&copy; 2008 Takahashi Fumiki
		</p>

		<p class="footer-poweredby text-center">
			Proudly powered by <a href="http://wordpress.org">WordPress</a>.
			My theme Ver. <?php echo fumiki_theme_version(); ?> is fully DIYed :)
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
