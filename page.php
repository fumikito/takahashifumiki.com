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
			<?php wp_link_pages(array(
				'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
				'after' => '</div>'
			)); ?>
			<? get_template_part('templates/single-share'); ?>
		</div>
		<? endwhile; endif; ?>
		<? get_template_part('templates/related-posts'); ?>
		<? get_sidebar(); ?>
	</div>
	<!-- #main ends -->
</div>

<?php
get_footer();