<div class="related">
	<h2 class="related-links"><i class="fa fa-book"></i> Amazonで発売中の電子書籍</h2>
	<ol class="feed feed--ebook clearfix">
		<?php
		$feed = hametuha_kdp();
		shuffle($feed);
		$counter = 0;
		foreach ( $feed as $ebook ):
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
</div><!-- //.related -->
