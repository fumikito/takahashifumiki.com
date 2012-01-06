<?php
get_header('meta');
get_header('navi');
get_header('title');
?>
<div id="content" class="margin clearfix">
	<div id="main">
		<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<div class="entry clearfix">
			<?php google_ads(); ?>
			<?php the_content(); ?>
				<div class="clrB">
				<?php link_pages('ページ: '); ?>
			</div>
		</div>
		<div class="share">
			<h3 class="mono">Share This</h3>
			<p>この記事を気に入ったら、ぜひシェアしてください。</p>
			<?php fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
		</div>
		<?php endwhile; endif; ?>
		<?php get_template_part('related-posts'); ?>
	</div>
	<!-- #main ends -->
	
	<?php if(is_ebook_related_pages()){ get_sidebar('ebook'); }else{get_sidebar();} ?>
</div>

<?php
get_footer();