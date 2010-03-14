<?php /*
Example template
Author: mitcho (Michael Yoshitaka Erlewine)
*/
?>
<div id="yarpp">
<h3>関連する投稿</h3>
<?php if ($related_query->have_posts()):?>
<ol>
	<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><small>関連度：<?php the_score(); ?></small></li>
	<?php endwhile; ?>
</ol>
<?php else: ?>
<div class="mincho">すいません、<br />ありません。</div>
<?php endif; ?>
</div><!--#related_post-->