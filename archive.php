<?php
include_once(TEMPLATEPATH."/header.php");

?>
<div id="wrapper">



<div id="header" class="clearfix">
<a id="logo" rel="home" href="<?php echo $fumiki->root; ?>"><?php echo $fumiki->blogTitle; ?></a>
<div id="breadcrumb">
<?php if(function_exists('bcn_display')) bcn_display(); ?>
</div>
<a id="toTop"></a>
</div><!-- #header ends-->





<div id="content" class="clearfix">




	<div id="main">
		<div class="meta">
			<h1 class="mincho"><span><?php $fumiki->archiver(); ?></span></h1>
			<br class="clrB" />
		</div><!-- .meta ends -->

		<div class="entry<?php if($post->post_password) echo ' blocked'; ?>">
			<dl>
			<?php if(have_posts()): while(have_posts()): the_post(); ?>
				<dt><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></dt>
				<dd>
					<a class="hook_image" href="<?php the_permalink(); ?>">
						<span><?php $fumiki->archive_photo(); ?></span>
					</a>
					<?php the_excerpt(); ?>
					<a class="more" href="<?php the_permalink(); ?>"><?php the_title(); ?>の続きを読む&raquo;</a>
					<span>【カテゴリー】</span><?php the_category(","); the_tags('<span>【タグ】</span>');?>
					<br />
					<small class="old"><?php the_time('Y/n/j(D) g:iA'); ?></small>
				</dd>
			<?php endwhile; endif; ?>
			</dl>
		</div><!-- .entry ends-->

		<div id="page_finish" class="old"><?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?></div>

	</div><!-- #main ends-->

	<?php get_sidebar(); ?>

</div><!-- #content ends-->





</div><!-- #wrapper ends -->
<?php
include_once(TEMPLATEPATH."/footer.php");
?>
