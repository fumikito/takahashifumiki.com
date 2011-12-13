<div class="margin header">
	
	
	<?php if(function_exists('bcn_display') && !is_smartphone()): ?>
		<div class="breadcrumb">
			<?php bcn_display(); ?>
		</div>
	<?php endif; ?>
	
	<?php $title = fumiki_title(); ?>
	<h1 class="title mincho<?php if(mb_strlen($title, 'utf-8') <= 20) echo ' center'; ?>">
		<?php echo $title; ?>
	</h1>
	
	<?php if((is_archive() && !is_post_type_archive('ebook')) || is_search()):?>
		<span class="post-counts"><strong class="old"><?php echo number_format($wp_query->found_posts); ?></strong>件</span>
	<?php endif; ?>
		
	<?php if(is_singular() && !is_page_template('page-account.php')): ?>
	<ul class="title-meta">
			
		<li class="inline-block date">
			公開日: <?php the_time(get_option('date_format')); ?>
			<small>（最終更新: <?php the_modified_date(); ?>）</small>
		</li>

		<li class="inline-block length">
			<?php $length = fumiki_content_length(); ?>
			所要時間: <span class="mono"><?php echo floor($length / 400); ?> Min.</span>
			<small class="mono">(<?php echo number_format($length); ?> letters)</small>
		</li>
			
		<?php if(!is_singular('page')): ?>
			<li class="inline-block feedback">フィードバック: <span class="mono"><?php echo comments_number('0', "1", '%'); ?></span></li><br />
		<?php endif;?>

		<?php if(is_singular('post')): ?>
			<li class="inline-block category">カテゴリー: <?php the_category(','); ?></li>
			<li class="inline-block tag"><?php the_tags('タグ: '); ?></li>
		<?php endif; ?>
			
		<?php edit_post_link('編集する', '<li class="inline-block count">', '</li>'); ?>
	</ul>
	<?php endif ?>
		
</div>