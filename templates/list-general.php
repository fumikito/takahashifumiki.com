<?php

$transient = get_transient( 'list_general' );

if ( false === $transient ) :
	ob_start();
?>
<div class="row">
	<div class="col-xs-12 col-sm-6 mb">
		<h2 class="related-title"><i class="fa fa-google"></i> アクセスランキング</h2>
		<?php
		$access = [
			'recent' => [ 'ここ3日', date_i18n( 'Y-m-d', strtotime( '3 days ago' ) ) ],
		    'month' => [ '今月', date_i18n( 'Y-m-d', strtotime( '1 month ago' ) ) ],
		    'all' => [ '全期間', '2008-08-01' ],
		];
		$end = date_i18n( 'Y-m-d' );
		?>
		<ul class="nav nav-info nav-tabs">
			<?php foreach ( $access as $key => list( $label ) ) : ?>
				<li role="presentation" class="<?= ( 'recent' == $key ) ? 'active' : '' ?>">
					<a href="#ga-<?= $key ?>" aria-controls="ga-<?= $key ?>" role="tab" data-toggle="tab">
						<?= esc_html( $label ) ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php foreach ( $access as $key => list( $label, $start ) ) : ?>
				<div role="tabpanel" class="tab-pane<?= 'recent' == $key ? ' active' : '' ?>" id="ga-<?= $key ?>">
					<ul class="post-loop-list">
						<?php foreach ( get_ga( $start, $end, 'ga:pageviews', [
							'max-results' => 5,
							'dimensions' => 'ga:pagePath,ga:pageTitle',
							'filters' => 'ga:pagePath=~^/(web|others|announcement|literature)/(.*/)?[0-9]+/',
							'sort' => '-ga:pageviews',
						] ) as $rank ) : ?>
							<li class="list-group-item post-loop-item point google">
								<a href="<?= home_url( $rank[0] ) ?>" class="post-loop-link clearfix">
									<div class="row-picture">
										<div class="post-loop-point">
											<?= number_format_i18n( $rank[2] ).'PV' ?>
										</div>
									</div>
									<div class="row-content post-loop-content">
										<h3 class="list-grou-item-heading post-loop-title">
											<?= esc_html( current( array_map( 'trim', explode( '|', $rank[1] ) ) ) ) ?>
										</h3>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 mb">
		<h2 class="related-title"><i class="fa fa-btc"></i> はてぶで人気</h2>
		<?php
		$hatebu = [
			'hot'   => '注目',
			'eid'   => '新着',
			'count' => '人気',
		];
		?>
		<ul class="nav nav-tabs nav-inverse">
			<?php foreach ( $hatebu as $key => $label ) : ?>
				<li role="presentation" class="<?= ( 'hot' == $key ) ? 'active' : '' ?>">
					<a href="#hatebu-<?= $key ?>" aria-controls="hatebu-<?= $key ?>" role="tab" data-toggle="tab">
						<?= esc_html( $label ) ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php foreach ( $hatebu as $key => $label ) : ?>
			<div role="tabpanel" class="tab-pane<?= 'hot' == $key ? ' active' : '' ?>" id="hatebu-<?= $key ?>">
				<ul class="post-loop-list hatena">
					<?php foreach ( get_hatena_rss( $key ) as $rss ) : ?>
						<li class="list-group-item post-loop-item point">
							<a href="<?= esc_url( $rss->get_permalink() ) ?>" class="post-loop-link clearfix">
								<div class="row-picture">
									<div class="post-loop-point">
										<?php
										$tag = $rss->get_item_tags( 'http://www.hatena.ne.jp/info/xmlns#', 'bookmarkcount' );
										echo number_format_i18n( $tag[0]['data'] ).'B'
										?>
									</div>
								</div>
								<div class="row-content post-loop-content">
									<h3 class="list-grou-item-heading post-loop-title">
										<?= esc_html( current( array_map( 'trim', explode( '|', $rss->get_title() ) ) ) ) ?>
									</h3>
									<div class="post-loop-meta">
										<span class="post-loop-meta-item">
											<i class="fa fa-calendar"></i>
											<?= $rss->get_date( get_option( 'date_format' ) ) ?>
										</span>
									</div>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php
	$transient = ob_get_contents();
	ob_end_clean();
	set_transient( 'list_general', $transient, 60 * 30 );
endif;
echo $transient;
