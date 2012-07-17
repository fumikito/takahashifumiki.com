<?php if (have_posts()):?>
	<ol>
		<?php while (have_posts()): the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<small class="date old"><?php the_time('Y/m/d'); ?></small>
			<small class="score old"><?php echo (get_the_score() * 10); ?>%</small>
		</li>
		<?php endwhile; ?>
	</ol>
<?php else: ?>
<p class="message warning">関連する投稿は見つかりませんでした。</p>
<?php endif; ?>