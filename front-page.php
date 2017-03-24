<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<div class="front-welcome">
		<div class="container">
			<div class="front-welcome-desc">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

	<div class="front-info">
		<div class="container">
			<div class="row">
				<div class="front-info-posts col-xs-12 col-sm-4">
					<h2 class="front-info-title"><i class="fa fa-file"></i> 最新の記事</h2>
					<ul class="post-loop-list">
						<?php
						$query = new WP_Query( [
							'post_type'      => 'post',
							'posts_per_page' => 5,
							'post_status'    => 'publish',
						] );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								get_template_part( 'templates/loop' );
							}
						}
						wp_reset_postdata(); ?>
					</ul>
					<a class="btn btn-raised btn-primary btn-block" href="<?= get_post_type_archive_link( 'post' ) ?>">もっと見る</a>
				</div><!-- //.posts -->
				<div class="front-info-category col-xs-12 col-sm-4 hidden-xs">
					<h2 class="front-info-title"><i class="fa fa-folder"></i> カテゴリー</h2>
					<ul class="nav nav-pills nav-stacked">
						<?php foreach ( get_categories( [ 'parent' => 0 ] ) as $cat ) : ?>
							<li>
								<a href="<?= get_category_link( $cat ) ?>"><?php printf( '%s(%s)', esc_html( $cat->name ), number_format_i18n( $cat->count ) ) ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<hr/>
					<h2 class="front-info-title"><i class="fa fa-tags"></i> タグ</h2>
					<?php wp_tag_cloud() ?>
				</div><!-- // category -->
				<div class="front-info-about col-xs-12 col-sm-4">
					<h2 class="front-info-title">
						<i class="fa fa-flag"></i> About Me
					</h2>
					<p>
						<?php bloginfo( 'description' ); ?><br/>
						管理者については<a href="<?= home_url( '/about/' ); ?>">高橋文樹について</a>をご覧下さい。
					</p>

					<?php get_template_part( 'templates/search' ) ?>

					<table class="front-info-table">
						<caption>
							<i class="fa fa-signal"></i> 統計情報
						</caption>
						<tbody>
						<tr>
							<th>開始日</th>
							<td class="mono">
								<?php $past = human_time_diff( strtotime( '2008-4-18' ) ); ?>
								2008年4月18日（<?= $past; ?>前）
							</td>
						</tr>
						<tr>
							<th>最新</th>
							<td class="mono">
								<?php $last_updated = fumiki_get_latest_updated(); ?>
								<?= mysql2date( 'Y年n月j日', $last_updated ); ?>
								（<?= human_time_diff( strtotime( $last_updated ) ); ?>前）
							</td>
						</tr>
						<tr>
							<th>投稿数</th>
							<td class="mono"><?php
								$post_counts = fumiki_get_post_count(['post']);
								echo number_format( $post_counts );
								$past_days = ( current_time( 'timestamp' ) - strtotime( '2008-4-18' ) ) / 60 / 60 / 24;
								printf( " (月%s本)", round( $post_counts / $past_days * 30 ) );
								?></td>
						</tr>
						<tr>
							<th>総文字</th>
							<td class="mono">
								<?php $length = fumiki_get_post_length(); ?>
								<?= number_format( $length ) . " (" . number_format( $length / $post_counts ) . "/1post)"; ?>
							</td>
						</tr>

						<tr>
							<th>はてブ</th>
							<td class="mono">
								<?= number_format( hatena_total_bookmark_count() ); ?>
							</td>
						</tr>
						<tr>
							<th>CMS</th>
							<td class="mono">WordPress <?php global $wp_version;
								echo $wp_version; ?></td>
						</tr>
						</tbody>
					</table>

				</div><!-- //.about -->
			</div>
		</div>
	</div>

	<div class="front-widgets">
		<?php get_template_part( 'templates/front' ) ?>
	</div><!-- .front-widgets -->

<?php endif; ?>


<?php get_footer();
