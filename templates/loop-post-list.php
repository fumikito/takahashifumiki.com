<?
/**
 * ループ内で使用
 */
?>
<li class="clearfix">
	<? fumiki_archive_photo("thumbnail"); ?>
	<? $score = get_the_score(); if($score): ?>
	<span class="score"><?= round($score * 10); ?>%</span>
	<? endif; ?>
	<h4><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h4>
	<span class="date mono">
		<?php printf('%s（%s前）', get_the_date('Y.n.j'), human_time_diff(strtotime($post->post_date))); ?><br />
		<span class="sans"><i class="icon-folder-open"></i>カテゴリー：<?php the_category(', '); ?></span>
	</span>
	<p class="desc"><?= fumiki_trim(get_the_excerpt(), 40); ?></p>
</li>