<?php
get_header('meta');
get_header('navi');
get_header('title');
?>
<div id="content" class="margin clearfix">
	<div id="main">
		<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<div class="entry clearfix">
			<?php the_content(); ?>
		</div>
		<?php wp_link_pages(array(
			'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
			'after' => '</div>'
		)); ?>
		<? get_template_part('templates/single', 'share'); ?>
		<? endwhile; endif; ?>
		<? if(function_exists('related_posts')) related_posts(); ?>
	</div>
	<!-- #main ends -->
</div>

<?php
get_footer();