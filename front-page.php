<? get_header('meta'); ?>
<div id="content" class="margin clearfix">
	<? if(have_posts()): the_post(); ?>


	<div class="title_box">
		<h1 class="center">
			<img alt="<? bloginfo('name'); ?>" src="<?= get_template_directory_uri(); ?>/styles/img/logo-front-page.png" width="256" height="256" />
		</h1>
		<? if( ($image = fumiki_header_image()) ): ?>
			<img class="header-image" src="<? header_image() ?>" alt="<?= esc_attr($image->post_title) ?>" />
			<? if( !empty($image->post_excerpt) ): ?>
				<p class="photo-credit"><?= $image->post_excerpt;  ?></p>
			<? endif; ?>
		<? endif; ?>
	</div><!-- //.title_box -->



	<div class="desc-box desc-box-front clearfix">

		<div class="box grid_1 main-content no-border">
			<h2><? the_title(); ?></h2>
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
					<? bloginfo('description'); ?><br />
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
							<? $past = human_time_diff(strtotime('2008-4-18')); ?>
							2008.4.18（<?= $past; ?>前）
						</td>
					</tr>
					<tr>
						<th>最新</th>
						<td class="mono">
							<? $last_updated = fumiki_get_latest_updated(); ?>
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
							<? $length = fumiki_get_post_length(); ?>
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
						<td class="mono">WordPress <? global $wp_version; echo $wp_version; ?></td>
					</tr>
					</tbody>
				</table>
			</div><!-- //.about -->
		</div><!-- //.grid_2 -->

		<? dynamic_sidebar('トップページ') ?>

		<? dynamic_sidebar('通常サイドバー') ?>
		
	</div>
	
	<? endif; ?>
	</div><!-- //.desc-box -->
	

	
</div><!-- //#content -->

<?
get_footer('hametuha');
get_footer();
