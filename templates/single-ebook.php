<div class="related">
	<h2 class="related-links"><i class="fa fa-book"></i> Amazonで発売中の電子書籍</h2>
	<ol class="feed feed--ebook clearfix">
		<?php
		$feed = hametuha_kdp();
		shuffle($feed);
		$counter = 0;
		foreach ( $feed as $ebook ) :
			?>
			<li class="feed__item">
				<a class="feed__link" href="<?= $ebook['url']; ?>">

					<img src="<?= $ebook['image'] ?>" alt="<?= esc_attr($ebook['title']); ?>" />

					<div class="feed__content">
						<h3 class="feed__title">
							<?= esc_html($ebook['title']); ?>
							<small><?= esc_html($ebook['category']) ?></small>
						</h3>

						<p class="feed__desc"><?= esc_html( $ebook['excerpt'] ) ?></p>

						<strong>
							<i class="fa fa-external-link"></i> Amazonで見る
						</strong>

					</div>
				</a>
			</li>
		<?php endforeach; ?>
	</ol>


	<a target="_blank" rel="nofollow" href="http://www.amazon.co.jp/gp/search?ie=UTF8&camp=247&creative=1211&index=aps&keywords=%E9%AB%98%E6%A9%8B%E6%96%87%E6%A8%B9&linkCode=ur2&tag=takahashifumiki-22">高橋文樹の本</a><img src="http://ir-jp.amazon-adsystem.com/e/ir?t=hametuha-22&l=ur2&o=9" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />

</div><!-- //.related -->
