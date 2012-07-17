<div id="yarpp" class="related clearfix">

	<div class="grid_4">
		<?php
		switch(get_post_type()){
			case 'post':
			case 'page':
				$obj = get_post_type_object(get_post_type());
		?>
				<h3>関連する<?php echo $obj->labels->name; ?></h3>
				<?php if(function_exists('related_posts')) related_posts(); ?>
		<?php
			break;
		} ?>
	</div>

	<div class="grid_4">
		<h3>新着エントリー</h3>
		<ol>
		<?php
			$query = new WP_Query('post_type=post&posts_per_page=5&post_status=publish');
			if($query->have_posts()): while($query->have_posts()): $query->the_post(); 
		?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<small class="date old"><?php the_time('Y/m/d'); ?></small>
				<small class="score old"><?php echo human_time_diff(strtotime($post->post_date)); ?></small>
			</li>
		<?php endwhile; endif; wp_reset_query(); ?>
		</ol>
	</div>
	
	<div class="grid_4">
		<h3>今週の人気エントリー</h3>
		<?php if(function_exists('WPPP_show_popular_posts')){
			WPPP_show_popular_posts( "list_tag=ol&title=&number=7&exclude=1142&days=7&cachename=wppp_weekly_posts&format=<a href=\"%post_permalink%\" title=\"%post_title_attribute%\">%post_title%</a><small class=\"date old\">%post_time%</small><small class=\"score old\">%post_views%PV</small>");
		}?>
	</div>
	
	<div class="grid_4">
		<h3>はてな人気エントリー</h3>
		<?php $hatena = get_hatena_rss(); ?>
		<ol>
			<?php $counter = 0; foreach($hatena->item as $item): $counter++;?>
			<li>
				<a href="<?php echo $item->link; ?>"><?php echo str_replace(" | 高橋文樹.com", "", (string)$item->title); ?></a>
				<small class="date old"><?php echo mysql2date('Y/m/d', (string)  get_hatena_date($item)); ?></small>
				<small class="score old"><?php echo number_format(get_hatena_count($item)); ?>B</small>
			</li>
			<?php if($counter >= 5){ break; } endforeach; ?>
		</ol>
	</div>
	
	
</div><!--#related_post-->