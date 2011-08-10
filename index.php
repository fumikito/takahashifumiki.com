<?php
get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main">

		<div class="archive clearfix">
			<?php $counter = 0;if(have_posts()): while(have_posts()): the_post(); $counter++;?>
				<?php if($counter == 3 || $counter == 5): ?>
					<p class="center google clrB">
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-0087037684083564";
					/* 高橋文樹 投稿内広告 */
					google_ad_slot = "5844658673";
					google_ad_width = 468;
					google_ad_height = 60;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
					</p>
					<!-- .google ends -->
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
			<?php endwhile; else: ?>
			<!-- ▼投稿無し -->
			<div class="entry">
				<h2>該当する投稿はありませんでした</h2>
				<p>ご迷惑おかけいたします。以下の方法をお試しください。</p>
				<ul>
					<li>右カラムにある<a href="#s">検索フォーム</a>から別の言葉で探す</li>
					<li><a href="#menu">ページ上部のメニュー</a>から探す</li>
					<li><a href="<?php bloginfo('url'); ?>/inquiry/">メールフォーム</a>から問い合わせる</li>
					<li><a href="#footer-nav">フッター</a>にあるTwitterなどのリンクから問い合わせる</li>
				</ul>
			<!-- ▲投稿無し -->
			</div>
			<?php endif; ?>
		</div><!-- .entry ends-->

		<div id="page_finish" class="mono clrB">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<!-- #page_finish -->

</div>
	<!-- #main ends -->
	
	<?php get_sidebar(); ?>
</div>

<?php
get_footer();