<?php
if(is_author() && $wp_query->query_vars["author_name"] != "admin"){
	include_once TEMPLATEPATH."/404.php";
	die();
}
include_once(TEMPLATEPATH."/header.php");

?>
<div id="wrapper">


<?php get_header("single"); ?>


<div id="content" class="clearfix">

	<div id="main">
		<div class="meta">
			<h1 class="mincho"><?php $fumiki->archiver(); ?></h1>
			<p class="right">
				<span><?php echo number_format($wp_query->found_posts); ?>件の記事があります</span>
			</p>
			<div class="meta_desc">
			<?php if(is_category()): ?>
				<?php echo wpautop(category_description()); ?>
			<?php endif; ?>
			</div>
		</div><!-- .meta ends -->

		<div class="entry clearfix">
			<?php $counter = 0;if(have_posts()): while(have_posts()): the_post(); $counter++;?>
				<?php if($counter < 5): ?>
				<?php if($counter == 3): ?>
					<p class="center google clrB">
					<script type="text/javascript"><!--
						google_ad_client = "pub-0087037684083564";
						/* 高橋文樹 投稿内広告 */
						google_ad_slot = "5844658673";
						google_ad_width = 468;
						google_ad_height = 60;
						//-->
					</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
					</p>
					<!-- .google ends -->
				<?php endif; ?>
					
					<div class="archive-box archive-box-big <?php echo ($counter % 2 == 0) ? 'even': 'odd';?>">
						<small class="old"><?php the_time('Y/n/j(D) g:iA'); ?></small>
						<div class="photo">
							<?php $fumiki->archive_photo(); ?>
							<h2>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
						<div class="cat old">Category:<?php the_category(",");?></div>
						<div class="desc">
							<p><?php echo get_the_excerpt(); ?></p>
						</div>
						<p class="tag">
							<img src="<?php bloginfo('template_directory'); ?>/img/archive_icon_tag.png" alt="タグ" width="16" height="16" /><?php  the_tags('');?>
						</p>
						<p class="right">
							<a class="more old" href="<?php the_permalink(); ?>">Read more...&raquo;</a>
						</p>
					</div>
					<!-- .archive-box-big ends -->
				<?php else: ?>
					<?php if($counter == 5): ?>
					<div class="clrB"></div>
					<?php endif; ?>
					<div class="archive-box archive-box-small <?php echo (($counter - 4) % 4 == 0) ? 'forth': '';?>">
						<small class="old"><?php the_time('Y/n/j(D)'); ?></small>
						<div class="photo">
							<?php $fumiki->archive_photo("thumbnail"); ?>
							<h2>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
						<div class="cat old">Category:<?php the_category(",");?></div>
						<div class="desc">
							<p><?php echo get_the_excerpt(); ?></p>
						</div>
						<p class="tag">
							<img src="<?php bloginfo('template_directory'); ?>/img/archive_icon_tag.png" alt="タグ" width="16" height="16" /><?php  the_tags('');?>
						</p>
						<p class="right">
							<a class="more old" href="<?php the_permalink(); ?>">Read more...&raquo;</a>
						</p>
					</div>
					<!-- .archive-box-small ends -->
					
					<?php if($counter % 4 == 0): ?>
						<div class="clrB"></div>
					<?php endif; ?>
				<?php endif; ?>
			<?php endwhile; else: ?>
			<!-- ▼投稿無し -->
				<h2>該当する投稿はありませんでした</h2>
				<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>
				<ul>
					<li>右カラムにある<a href="#s">検索フォーム</a>から別の言葉で探す</li>
					<li><a href="#header">ページ上部のグローバルナビゲーション</a>から探す</li>
					<li><a href="<?php bloginfo('url'); ?>/inquiry">メールフォーム</a>から問い合わせる</li>
				</ul>
			<!-- ▲投稿無し -->
			<?php endif; ?>
		</div><!-- .entry ends-->

		<div id="page_finish" class="old clrB">
			<?php fumiki_to_top(); ?>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<!-- #page_finish -->

	</div><!-- #main ends-->

	<?php get_sidebar(); ?>

</div><!-- #content ends-->





</div><!-- #wrapper ends -->
<?php
include_once(TEMPLATEPATH."/footer.php");
?>
