<?php dynamic_sidebar( '通常サイドバー' ); ?>

<?php if ( $hametuha_posts = hametuha_posts() ) : ?>
	<div class="widget widget-hametuha">

		<h2 class="widget-title text-center">
			<img src="<?= get_stylesheet_directory_uri() ?>/styles/img/favicon/hametuha.png" alt="破滅派" width="150"
			     height="150"/>
		</h2>


		<p class="text-muted">
			破滅派は高橋文樹が主催するオンライン文芸誌です。小説やエッセーを掲載しています。
		</p>

		<ol class="hametuha-list">
			<?php $counter = 0;
			foreach ( $hametuha_posts as $link ) : $counter ++; ?>
				<li class="hametuha-list-item">
					<a class="hametuha-list-link" href="<?= esc_url( $link['url'] ) ?>">
						<h3 class="hametuha-list-title">
							<?= esc_html( $link['title'] ) ?>
							<?php if ( current_time( 'timestamp' ) - strtotime( $link['post_date'] ) < 60 * 60 * 24 * 7 ) : ?>
								<span class="label label-danger">New</span>
							<?php endif ?>
						</h3>
						<p class="hametuha-list-category">
							<span class="date">
								<i class="fa fa-calendar"></i>
								<?= mysql2date( 'Y年n月j日', $link['post_date'] ) ?>
							</span>
							<?php if ( isset( $link['source'] ) ) : ?>
								<span><i class="fa fa-globe"></i> <?= esc_html( $link['source'] ) ?></span>
							<?php endif; ?>
							<span class="tags"><i
									class="fa fa-tags"></i> <?= implode( ', ', $link['category'] ) ?></span>
						</p>
                        <?php if ( 1 === $counter ) : ?>
						<div class="hametuha-list-description">
							<?= wpautop( $link['excerpt'] ) ?>
						</div>
                        <?php endif; ?>
					</a>
				</li>
				<?php
				if ( $counter >= 5 ) {
					break;
				}
				?>
			<?php endforeach; ?>
		</ol>

		<p>
			<a class="btn btn-raised btn-default btn-block" href="https://hametuha.com/doujin/detail/takahashi_fumiki/">
				もっと見る <i class="fa fa-external-link"></i>
			</a>
		</p>

	</div><!-- //.hametuha-links -->
<?php endif; ?>

<div class="widget">
	<h2 class="widget-title">
		<i class="fa fa-amazon"></i> 高橋先生の電子書籍
	</h2>
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

</div><!-- //.kdp-single -->


<?php if ( $news = get_hamenew() ) : ?>
<div class="widget widget-hamenew">
	<h2 class="widget-title"><i class="fa fa-newspaper-o"></i> はめにゅー</h2>
	<ol class="news-list">
		<?php foreach ( $news as $new ) : ?>
			<li class="news-list-item">
				<a class="news-list-link clearfix" href="<?= esc_url( $new->get_permalink() ) ?>">
					<?php if ( $images = $new->get_enclosures() ) : ?>
					<div class="news-list-image">
						<?php $image = $images[ count( $images ) - 1 ]; ?>
						<img class="news-list-src img-circle" src="<?= esc_attr( $image->get_link() ) ?>" alt="<?= esc_attr( $image->get_title() ) ?>" />
					</div>
					<?php endif; ?>
					<div class="news-list-content">
						<h3 class="news-list-title">
							<?= esc_html( $new->get_title() ) ?>
						</h3>
						<div class="news-list-date">
							<i class="fa fa-clock-o"></i> <?= $new->get_date( 'Y/m/d H:i' ) ?>
						</div>
					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ol>
	<p>
		<a href="https://hametuha.com/news/" target="_blank" class="btn btn-raised btn-block btn-primary">もっと見る <i class="fa fa-external-link"></i></a>
	</p>
</div>
<?php endif ?>

<div class="widget text-center">
	<?php google_ads( 4 ); ?>
</div>


