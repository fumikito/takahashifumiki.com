<div id="yarpp" class="related clearfix">

	<div class="grid_4">
		<?
		switch(get_post_type()):
			case 'post':
			case 'page':
			case 'events':
				$obj = get_post_type_object(get_post_type());
		?>
				<h3>関連する<?= $obj->labels->name; ?></h3>
				<? if(function_exists('related_posts')) related_posts(); ?>
		<? break; endswitch; ?>
	</div>

	<div class="grid_4">
		<h3>新着エントリー</h3>
		<ol>
		<?
			$query = new WP_Query('post_type=post&posts_per_page=5&post_status=publish');
			if($query->have_posts()): while($query->have_posts()): $query->the_post(); 
		?>
			<li>
				<a href="<? the_permalink(); ?>"><? the_title(); ?></a>
				<small class="date old"><? the_time('Y/m/d'); ?></small>
				<small class="score old"><?= human_time_diff(strtotime($post->post_date)); ?></small>
			</li>
		<? endwhile; endif; wp_reset_query(); ?>
		</ol>
	</div>
	
	<div class="grid_4">
		<h3>今週の人気エントリー</h3>
		<? if(function_exists('WPPP_show_popular_posts')){
			WPPP_show_popular_posts( "list_tag=ol&title=&number=7&exclude=1142&days=7&cachename=wppp_weekly_posts&format=<a href=\"%post_permalink%\" title=\"%post_title_attribute%\">%post_title%</a><small class=\"date old\">%post_time%</small><small class=\"score old\">%post_views%PV</small>");
		}?>
	</div>
	
	<div class="grid_4">
		<h3>はてな人気エントリー</h3>
		<? $hatena = get_hatena_rss(); ?>
		<ol>
			<? $counter = 0; foreach($hatena->item as $item): $counter++;?>
			<li>
				<a href="<?= $item->link; ?>"><?= str_replace(" | 高橋文樹.com", "", (string)$item->title); ?></a>
				<small class="date old"><?= mysql2date('Y/m/d', (string)  get_hatena_date($item)); ?></small>
				<small class="score old"><?= number_format(get_hatena_count($item)); ?>B</small>
			</li>
			<? if($counter >= 5){ break; } endforeach; ?>
		</ol>
	</div>
	
	
</div><!--#related_post-->