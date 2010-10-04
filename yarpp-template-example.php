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
<?php
	$cats = get_the_category();
	$cat = current($cats);
	query_posts("showposts=5&cat={$cat->term_id}");
	if(have_posts()):
?>
<ol>
<?php while(have_posts()): the_post(); ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;wp_reset_query();?>
</ol>
<?php endif; ?>
<?php endif; ?>
</div><!--#related_post-->