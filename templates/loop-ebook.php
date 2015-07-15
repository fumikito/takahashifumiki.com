<?
/**
 * ループ内で使用
 */
?>
<li class="clearfix loop loop-ebook">

	<? fumiki_archive_photo("thumbnail"); ?>

	<h3 class="post-title"><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h3>

	<span class="date mono">
		<i class="fa-calendar"></i> <?php printf('%s（%s前）', get_the_date('Y.n.j'), human_time_diff(strtotime($post->post_date))); ?><br />
		<span class="old book-price"><del><?php lwp_the_price() ?></del></span>
	</span>
	<p class="desc"><?= fumiki_trim(get_the_excerpt(), 120); ?></p>
</li>