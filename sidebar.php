<div class="desc-box clearfix">
	<? if(is_singular('ebook') || is_post_type_archive('ebook')) dynamic_sidebar('電子書籍');  ?>


	<div class="box grid_2">
		<?php google_ads(4); ?>
	</div>
	<? dynamic_sidebar('通常サイドバー'); ?>
	<div class="box grid_2">
		<?
			$hatebu = array(
				'hot' => '注目',
				'eid' => '新着',
				'count' => '人気',
			);
			$key = array_rand($hatebu);
		?>
		<h3><i class="fa-bookmark"></i> はてぶで<?= $hatebu[$key]; ?></h3>
		<? $hatena = get_hatena_rss($key); ?>
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