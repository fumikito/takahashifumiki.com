<?php
if(is_paged()):
	get_template_part("index");
else:
get_header('meta');
get_header('navi');
?>
<div id="content" class="margin clearfix">
	
	<div class="main-menu mincho">
		<?php wp_nav_menu(array('theme_location' => 'top-page','container_class' => 'clearfix')); ?>
	</div>
	
	<div class="share-home share center">
		<?php fumiki_share(get_bloginfo('name'), get_bloginfo('url')); ?>
	</div>
	
	<div id="main">
		<?php get_search_form(); ?>
		<div class="archive clearfix">
			<?php $counter = 0;if(have_posts()): while(have_posts()): the_post(); $counter++;?>
				<?php if($counter == 3 || $counter == 5): ?>
					<p class="center google clrB"><?php google_ads(2);?></p>
				<?php endif; ?>
				<?php if($counter < 5): ?>
					<div class="archive-box archive-box-big <?php echo ($counter % 2 == 0) ? 'even': 'odd';?>">
						<small class="mono"><?php the_time('Y/n/j(D) g:iA'); ?></small>
						<div class="photo dark_bg">
							<?php fumiki_archive_photo(); ?>
							<h2>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
						<div class="cat dark_bg"><span class="mono">Category: </span><?php the_category(",");?></div>
						<div class="desc">
							<p><?php echo get_the_excerpt(); ?></p>
						</div>
						<p class="tag">
							<img src="<?php bloginfo('template_directory'); ?>/img/archive_icon_tag.png" alt="タグ" width="16" height="16" /><?php  the_tags('');?>
						</p>
						<p class="right">
							<a class="button" href="<?php the_permalink(); ?>">Read more...&raquo;</a>
						</p>
					</div>
					<!-- .archive-box-big ends -->
				<?php else: ?>
					<?php if($counter == 5): ?>
						<div class="clrB"></div>
					<?php endif; ?>
					
					<div class="archive-box archive-box-small <?php echo (($counter - 4) % 4 == 0) ? 'forth': '';?>">
						<small class="old"><?php the_time('Y/n/j(D)'); ?></small>
						<div class="photo dark_bg">
							<?php fumiki_archive_photo("thumbnail"); ?>
							<h2>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
						<div class="cat dark_bg"><span class="mono">Category: </span><?php the_category(",");?></div>
						<div class="desc">
							<p><?php echo get_the_excerpt(); ?></p>
						</div>
						<p class="tag">
							<img src="<?php bloginfo('template_directory'); ?>/img/archive_icon_tag.png" alt="タグ" width="16" height="16" /><?php  the_tags('');?>
						</p>
						<p class="right">
							<a class="button" href="<?php the_permalink(); ?>">Read more...&raquo;</a>
						</p>
					</div>
					<!-- .archive-box-small ends -->
					
					<?php if($counter % 4 == 0): ?>
						<div class="clrB"></div>
					<?php endif; ?>
						
				<?php endif; ?>
			<?php endwhile; endif; ?>
		</div>
		<div id="page_finish" class="mono clrB">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	</div>
	
	<?php get_sidebar(); ?>

</div>

<?php
get_footer();
endif;