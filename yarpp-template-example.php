<?php if (have_posts()):?>
	<ol>
		<?php while (have_posts()): the_post(); ?>
		<li class="clearfix">
			<div class="thumb">
				<a href="<?php the_permalink(); ?>"><?php fumiki_archive_photo("thumbnail"); ?></a>
			</div>
			<div class="score">
				関連度<br />
				<small class="old"><?php echo (get_the_score() * 10); ?>%</small>
			</div>
			<div class="detail">
				<span class="mono"><?php the_date('Y.m.d'); ?></span><br />
				<a class="more" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
				<p><?php echo mb_substr(get_the_excerpt(), 0, 60, 'utf-8'); ?>[...] </p>
			</div>
		</li>
		<?php endwhile; ?>
	</ol>
<?php else:?>
	<p class="message warning">
		関連する投稿はありませんでした。
	</p>
<?php endif; ?>