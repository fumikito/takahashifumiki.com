<div class="desc-box clearfix">
	<? if(is_singular('ebook') || is_post_type_archive('ebook')) dynamic_sidebar('電子書籍');  ?>

	<? if(is_singular()): ?> 
	<?
	//関連投稿
	switch(get_post_type()):
		case 'post':
		case 'page':
			$obj = get_post_type_object(get_post_type());
	?>
	<div class="box grid_2">
		<h3><i class="icon-link"></i> 関連<?= $obj->labels->name; ?></h3>
		<? if(function_exists('related_posts')) related_posts(); ?>
	</div>
	<? break; endswitch; ?>
	<? endif; ?>
	<? dynamic_sidebar('通常サイドバー'); ?>
	<div class="box grid_2">
		<h3><i class="icon-bookmark"></i> はてぶで人気</h3>
		<? $hatena = get_hatena_rss(); ?>
		<ol class="post-list">
			<? $counter = 0; foreach($hatena->item as $item): $counter++;?>
			<li>
				<span class="score old"><?= number_format(get_hatena_count($item)); ?>B</span>
				<h4><a href="<?= $item->link; ?>"><?= str_replace(" | 高橋文樹.com", "", (string)$item->title); ?></a></h4>
				<span class="date mono"><?= mysql2date('Y.n.j', (string)  get_hatena_date($item)); ?></span>
			</li>
			<? if($counter >= 5){ break; } endforeach; ?>
		</ol>
	</div>
</div>