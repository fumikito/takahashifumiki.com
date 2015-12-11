<?
/**
 * ループ内で使用
 */
?>
<li class="clearfix loop loop-post">
	<?php fumiki_archive_photo("thumbnail"); ?>

	<?php if( $score = get_the_score() ) :  ?>
    	<span class="score mono"><?= round($score * 10); ?>%</span>
	<?php endif; ?>

	<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

	<span class="date mono">
		<i class="fa-calendar"></i> <?php printf('%s（%s前）', get_the_date('Y.n.j'), human_time_diff(strtotime($post->post_date))); ?><br />
		<span class="sans"><i class="fa-folder-open"></i> カテゴリー：<?php the_category(', '); ?></span>
	</span>
	<p class="desc"><?= fumiki_trim(get_the_excerpt(), 120); ?></p>
</li>