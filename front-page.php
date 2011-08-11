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
	
	<div class="archive home-archive clearfix">
		<?php if(have_posts()) while(have_posts ()) : the_post(); $counter++; if($counter < 4): ?>
			<div class="archive-box archive-box-big <?php echo ($counter % 3 == 0) ? 'alt': '';?>">
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
			<?php if($counter == 3): ?>
			<p class="center google clrB"><?php google_ads(2);?></p>
			<?php endif; ?>
		<?php else: ?>
			<div class="archive-box archive-box-small<?php echo (($counter - 3) % 6 == 0) ? ' sixth': ''; echo (($counter - 3 ) % 2 == 0) ? ' more-pad': '';?>">
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
		<?php endif; endwhile; ?>
			<div class="archive-box archive-box-small sixth last">
				<div>
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-0087037684083564";
					/* 高橋文樹トップ2011 */
					google_ad_slot = "6452503709";
					google_ad_width = 120;
					google_ad_height = 240;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
			<!-- .archive-box-small ends -->
	</div>
	<div id="page_finish" class="mono clrB">
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	</div>
	
	<?php get_sidebar(); ?>

	</div>
</div>

<?php
get_footer();
endif;