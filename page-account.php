<?php
/*
 * Template Name: アカウント
 */
	get_header();
?>
	<?php if(have_posts()) :  while(have_posts()) :  the_post(); ?>

<div id="content" class="margin account" class="clearfix">
	<div class="entry">
	<?php the_content(); ?>
	</div>
</div>
	
	<?php endwhile; endif; ?>

<?php
	get_footer();
