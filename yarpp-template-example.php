<? if (have_posts()):?>
	<ol class="post-list">
		<? while (have_posts()): the_post(); ?>
		<? get_template_part('templates/loop', get_post_type()); ?>
		<? endwhile; ?>
	</ol>
<? else: ?>
<p class="message warning">関連する投稿は見つかりませんでした。</p>
<? endif; ?>