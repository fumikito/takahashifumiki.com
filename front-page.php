<?php get_header(); ?>
<div id="content" class="margin clearfix">
	<?php if(have_posts()) :  the_post(); ?>


	<div class="title_box">
		<h1 class="center">
			<img alt="<?php bloginfo('name'); ?>" src="<?= get_template_directory_uri(); ?>/styles/img/logo-front-page.png" width="256" height="256" />
		</h1>
		<?php if( ($image = fumiki_header_image()) ) :  ?>
			<img class="header-image" src="<?php header_image() ?>" alt="<?= esc_attr($image->post_title) ?>" />
			<?php if( !empty($image->post_excerpt) ) :  ?>
				<p class="photo-credit"><?= $image->post_excerpt;  ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div><!-- //.title_box -->



	<div class="desc-box desc-box-front clearfix">

		<div class="box grid_1 main-content no-border">
			<h2><?php the_title(); ?></h2>
			<div class="desc">
				<?= the_content(); ?>
			</div>
		</div><!-- //.main-content -->

		<div class="box grid_2 no_shadow">
			<div class="about">
				<h2>
					<i class="fa-flag"></i>About me
				</h2>
				<p>
					<?php bloginfo('description'); ?><br />
					管理者については<a href="<?= home_url('/about/', 'http');?>">高橋文樹について</a>をご覧下さい。
				</p>
				<table>
					<caption>
						<i class="fa-signal"></i>統計情報
					</caption>
					<tbody>
					<tr>
						<th>開始日</th>
						<td class="mono">
							<?php $past = human_time_diff(strtotime('2008-4-18')); ?>
							2008.4.18（<?= $past; ?>前）
						</td>
					</tr>
					<tr>
						<th>最新</th>
						<td class="mono">
							<?php $last_updated = fumiki_get_latest_updated(); ?>
							<?= mysql2date('Y.n.j', $last_updated); ?>
							（<?= human_time_diff(strtotime($last_updated)); ?>前）
						</td>
					</tr>
					<tr>
						<th>投稿数</th>
						<td class="mono"><?
							$post_counts = fumiki_get_post_count();
							echo number_format($post_counts);
							$past_days = ( current_time('timestamp') - strtotime('2008-4-18') ) / 60 / 60 / 24;
							printf(" (月%s本)", round($post_counts / $past_days * 30));
							?></td>
					</tr>
					<tr>
						<th>総文字</th>
						<td class="mono">
							<?php $length = fumiki_get_post_length(); ?>
							<?= number_format($length)." (".number_format($length / $post_counts)."/1post)"; ?>
						</td>
					</tr>

					<tr>
						<th>はてブ</th>
						<td class="mono">
							<?= number_format(hatena_total_bookmark_count()); ?>
						</td>
					</tr>
					<tr>
						<th>CMS</th>
						<td class="mono">WordPress <?php global $wp_version; echo $wp_version; ?></td>
					</tr>
					</tbody>
				</table>
			</div><!-- //.about -->
		</div><!-- //.grid_2 -->

		<?php dynamic_sidebar( 'トップページ' ) ?>

		<?php
		$query = new WP_Query(array(
			'post_type' => 'post',
			'posts_per_page' => 8,
			'post_status' => 'publish',
		));
		if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();
		?>
		<div id="post-<?php the_ID(); ?>" class="box widget widget--front grid_2 widget--post">
			<a href="<?php the_permalink() ?>">
				<?php if( has_post_thumbnail() ) :  ?>
				<div class="widget__thumbnail" style="background-image: url('<?= current(wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium')) ?>')"></div>
				<?php endif; ?>
				<h2><?php the_title(); ?></h2>
				<div class="widget__meta">
					<i class="fa fa-folder"></i> <?= implode(' ', array_map(function($term){
						return esc_html($term->name);
					}, get_the_category())) ?>
					<i class="fa fa-calendar"></i> <?php the_time('Y.m.d') ?>
				</div>
				<div class="widget__content">
					<?php the_excerpt() ?>
				</div>
			</a>
		</div>
		<?php endwhile; wp_reset_postdata(); endif; ?>
		<?php
		$feed = hametuha_kdp();
		shuffle($feed);
		$counter = 0;
		foreach ( $feed as $ebook ) :
			?>
			<div class="box feed widget widget--front grid_2 widget--ebook">
				<a class="feed__link" href="<?= $ebook['url']; ?>">

					<img src="<?= $ebook['image'] ?>" alt="<?= esc_attr($ebook['title']); ?>" height="449" />

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
			</div>
		<?php endforeach; ?>


		<?php dynamic_sidebar( '通常サイドバー' ) ?>
		
	</div>
	
	<?php endif; ?>
	</div><!-- //.desc-box -->
	

	
</div><!-- //#content -->

<?
get_footer('hametuha');
get_footer();
