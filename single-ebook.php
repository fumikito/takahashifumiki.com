<?php

get_header('meta');
get_header('navi');
the_post();
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main" class="ebook">
		<?php $eye_catch = get_post_meta(get_the_ID(), 'eye-catch', true); if($eye_catch):?>
		<div class="eyecatch">
			<img src="<?php echo $eye_catch; ?>" alt="<?php the_title(); ?>" width="570" height="300" />
		</div>
		<?php endif; ?>
		<div class="entry clearfix">
			<?php the_content(); ?>
			<?php wp_link_pages(array(
				'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
				'after' => '</div>'
				
			)); ?>
		</div>
		<div class="entry clearfix">
			<h2>対応端末</h2>
			<?php $devices = lwp_get_devices(); ?>
			<div class="device-list clearfix">
				<?php foreach($devices as $d): ?>
					<div class="device<?php echo ($d["valid"]) ? ' valid' : ' invalid';?>">
						<small class="center sans"><?php echo $d["valid"] ? "確認済" : "未確認"; ?></small>
						<img src="<?php bloginfo('template_directory'); ?>/img/ebook-devices/<?php echo $d["slug"]; ?>.png" alt="<?php echo $d["name"]; ?>" width="48" height="48"/>
						<span class="sans center"><?php echo $d["name"]; ?></span>
					</div>
					<!-- .device ends -->
				<?php endforeach; ?>
				<p class="clrB sans">
					ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
					端末追加のご要望については<a href="<?php bloginfo('url'); ?>/inquiry">お問い合わせ</a>よりご連絡ください。
				</p>
			</div>
			<h2 id="download-list">ダウンロード</h2>
			<?	get_template_part('templates/table-downloadables'); ?>
			
			<? get_template_part('template/single-share'); ?>
			
		</div>
		
		<?php comments_template(); ?>
		
		<? get_sidebar(); ?>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar('ebook'); ?>
</div>

<?php
get_footer();