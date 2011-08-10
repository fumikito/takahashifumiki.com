<?php
the_post();
get_header('meta');
get_header('navi');
get_header('title');
?>
<div id="content" class="margin clearfix">
	<div id="main">
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
		<?php related_posts(); ?>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar(); ?>
</div>

<?php
get_footer();