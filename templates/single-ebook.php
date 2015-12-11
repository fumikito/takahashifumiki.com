<div class="kdp--single dark_bg">
	<h2 class="kdp__title">
		<i class="fa fa-amazon"></i><br />
		Amazonで発売中の電子書籍
	</h2>
	<?php
	$feed = hametuha_kdp();
	shuffle( $feed );
	$counter = 0;
	$rows    = [];
	foreach ( $feed as $f ) {
		$index = floor( $counter / 3 );
		if ( ! isset( $rows[ $index ] ) ) {
			$rows[ $index ] = [];
		}
		$rows[ $index ][] = $f;
		$counter ++;
	}
	$row_index = 0;
	foreach ( $rows as $items ) :
		$row_index++;
		?>
		<div class="kdp__row row <?php if ( 1 === $row_index ) { echo 'toggle'; }?>">
			<?php foreach ( $items as $item ) : ?>
				<div class="col-xs-3">
					<a class="feed__link" href="<?= $item['url']; ?>">
						<?php if ( 1 === $row_index ) : ?>
						<img
							src="<?= isset( $item['images']['medium'] ) ? $item['images']['medium'][0] : $item['image'] ?>"
							alt="<?= esc_attr( $item['title'] ); ?>"/>
						<?php else : ?>
						<div
								data-src="<?= isset( $item['images']['medium'] ) ? $item['images']['medium'][0] : $item['image'] ?>"
								data-alt="<?= esc_attr( $item['title'] ); ?>">
						</div>
						<?php endif; ?>
						<div class="feed__content">
							<h3 class="feed__title">
								<?= esc_html( $item['title'] ); ?>
								<small><?= esc_html( $item['category'] ) ?></small>
							</h3>

							<p class="feed__desc"><?= esc_html( $item['excerpt'] ) ?></p>

							<strong>
								<i class="fa fa-external-link"></i> Amazonで見る
							</strong>

						</div>
					</a>

				</div>
			<?php endforeach; ?>
		</div><!-- //.row -->
	<?php endforeach; ?>


	<p class="center kdp__more">
		<a class="button" target="_blank" rel="nofollow"
		   href="http://www.amazon.co.jp/gp/search?ie=UTF8&camp=247&creative=1211&index=aps&keywords=%E9%AB%98%E6%A9%8B%E6%96%87%E6%A8%B9&linkCode=ur2&tag=takahashifumiki-22"> Amazonで見る</a>
		<img
			src="http://ir-jp.amazon-adsystem.com/e/ir?t=hametuha-22&l=ur2&o=9" width="1" height="1" border="0" alt=""
			style="border:none !important; margin:0px !important;"/>
	</p>

</div><!-- //.kdp-single -->
