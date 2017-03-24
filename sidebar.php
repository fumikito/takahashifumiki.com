
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

<?php dynamic_sidebar( '通常サイドバー' ); ?>

<?php get_template_part( 'templates/list', 'general' ) ?>

<div class="widget">
	<?php get_template_part( 'templates/search' ) ?>
</div>

<div class="widget">
	<div class="like-box-container">
		<div class="fb-page" data-href="https://www.facebook.com/takahashifumiki.Page"
			 data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
			 data-show-facepile="true" data-show-posts="true">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="https://www.facebook.com/takahashifumiki.Page"><a
							href="https://www.facebook.com/takahashifumiki.Page">高橋文樹</a></blockquote>
			</div>
		</div>
	</div>
</div>

<div class="widget text-center">
	<?php google_ads( 4 ); ?>
</div>


