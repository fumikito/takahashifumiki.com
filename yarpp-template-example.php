<? if (have_posts()):?>
	<ol>
		<? while (have_posts()): the_post(); ?>
		<li>
			<a href="<? the_permalink(); ?>"><? the_title(); ?></a>
			<small class="date old"><? the_time('Y/m/d'); ?></small>
			<small class="score old"><? echo (get_the_score() * 10); ?>%</small>
		</li>
		<? endwhile; ?>
	</ol>
<? else: ?>
<p class="message warning">関連する投稿は見つかりませんでした。</p>
<? endif; ?>