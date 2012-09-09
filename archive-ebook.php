<?php
get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main" class="ebook">
		<?php $counter = 0;  if(have_posts()): while(have_posts()): the_post(); $counter++;?>
		<div class="ebook-detail clearfix title-meta">
			<div class="google center">
				<a href="<?php the_permalink(); ?>"><img class="cover" src="<?php echo get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<?php the_title(); ?>" width="240" height="320" /></a>
				<?php if(lwp_on_sale()): ?>
					<img class="on-sale" src="<?php bloginfo('template_directory'); ?>/img/icon-sale-48.png" width="48" height="48" alt="On Sale" />
				<?php endif; ?>
			</div>
			<? get_template_part('templates/meta-ebook'); ?>
			<div class="excerpt">
				<?php the_excerpt(); ?>
			</div>
			<p class="center">
				<a href="<?php the_permalink(); ?>" class="button">電子書籍『<?php the_title(); ?>』の詳細</a>
			</p>
		</div>
		<?php endwhile; endif;?>
		<div id="page_finish" class="mono clrB">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<!-- #page_finish -->

	</div>
	<!-- #main ends -->
	<?php get_sidebar('ebook'); ?>
</div>

<?php
get_footer();