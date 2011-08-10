<div class="margin header">
	<div class="breadcrumb">
		<?php bcn_display(); ?>
	</div>
	
	<?php $title = fumiki_title(); ?>
	<div class="title mincho<?php if(mb_strlen($title, 'utf-8') <= 20) echo ' center'; ?>">
		<?php echo htmlspecialchars($title, ENT_QUOTES, 'utf-8'); ?>
	</div>
	
	
	<ul class="title-meta">
		<?php if(is_singular()): ?>
			<li class="inline-block date">
				公開日: <?php the_date(); ?>
				<small>（最終更新: <?php the_modified_date(); ?>）</small>
			</li>
			<li class="inline-block length">
				<?php $length = fumiki_content_length(); ?>
				所要時間: <span class="mono"><?php echo floor($length / 400); ?> Min.</span>
				<small class="mono">(<?php echo number_format($length); ?> letters)</small>
			</li>
			<?php if(is_single()): ?>
			<li class="inline-block feedback">フィードバック: <span class="mono"><?php echo comments_number('0', "1", '%'); ?></span></li><br />
			<li class="inline-block category">カテゴリー: <?php the_category(','); ?></li>
			<li class="inline-block tag"><?php the_tags('タグ: '); ?></li>
			<?php endif;?>
		<?php elseif(is_archive()):?>
			<Li class="inline-block count"><?php echo number_format($wp_query->found_posts); ?>件の記事が見つかりました</li>
		<?php endif; ?>
	</ul>
</div>