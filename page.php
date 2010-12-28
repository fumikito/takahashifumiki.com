<?php
	the_post();
	get_header();
?>

<div id="wrapper">
	
	<?php get_header("single"); ?>
	
	<div id="content" class="clearfix">
		<div id="main">
			<div class="meta">
				<h1 class="mincho"><span><?php the_title(); ?></span></h1>
				<div class="calendar old">
						<?php
							ob_start();
							the_date('Y n j D g:iA');
							$buf = ob_get_contents();
							ob_end_clean();
							$fumiki->dateformat($buf);
						?>
				</div>
				<!-- .calendar ends -->
				<ul>
					<li>
						<small class="old"><?php echo the_modified_date("Y年n月d日"); ?>更新</small>
					</li>
				</ul>
			</div>
			<!-- .meta ends -->
			
			<div class="entry">
				<?php the_content(); ?>
				<?php
					if(is_page("links"))
						wp_list_bookmarks("categorize=1&category=2,115");
					if(is_page("inquiry"))
						wp_list_bookmarks("categorize=1&category=115");
				?>
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
			</div>
			<!-- .entry ends -->
			
			<div id="page_finish" class="clrB">
				<span class="mincho">終わり</span>
			</div>
			<!-- #page_finish ends -->
			
			<div id="end_meta" class="clearfix">
				<div class="end_meta_box">
					<?php
						$random = rand(0, 2);
						$sort = ($random >= 1) ? "hot" : "count";
						$title = ($random >= 1) ? "新着" : "人気";
					?>
					<script language="javascript" type="text/javascript" src="http://b.hatena.ne.jp/js/widget.js" charset="utf-8"></script>
					<script language="javascript" type="text/javascript">
					Hatena.BookmarkWidget.url   = "http://takahashifumiki.com";
					Hatena.BookmarkWidget.title = "はてなブックマーク<?php echo $title; ?>";
					Hatena.BookmarkWidget.sort  = "<?php echo $sort; ?>";
					Hatena.BookmarkWidget.width = 0;
					Hatena.BookmarkWidget.num   = 5;
					Hatena.BookmarkWidget.theme = "default";
					Hatena.BookmarkWidget.load();
					</script>
				</div>
				<div class="end_meta_box">
					<div id="yarpp">
						<h3 class="関連する投稿"></h3>
						<?php
							$args = "child_of=".get_the_ID();
							if($post->post_parent != 0)
								$args .= '&include='.implode(',', get_post_ancestors($post));
							wp_page_menu($args);
						?>
					</div>
				</div>
				<div class="end_meta_box">
					<h3 class="mesena"><?php the_title(); ?>の反響</h3>
					<dl class="mesena">
						<dt>ソーシャルメディア</dt>
						<dd class="center">
							<?php $fumiki->hatena_add("", "", "", "このエントリーをはてブする"); ?><br /><br />
							<?php $fumiki->mixi_check(); ?>
							<?php $fumiki->gree_like(); ?>
							<?php $fumiki->tweet_this(); ?><br /><br />
							<?php $fumiki->facebook_like("", 200, 80); ?>
						</dd>
					</dl>
				</div>
				<?php fumiki_to_top(); ?>
			</div>
			<!-- #end_meta -->
			
		</div>
		<!-- #main ends -->
		
		<?php
			if($post->post_parent == get_page_by_path("ebooks")->ID){
				get_sidebar('ebooks');
			}else
				get_sidebar("page");
		?>
		
	</div>
	<!-- #content -->

</div>
<!-- #wrapper ends -->

<?php
	get_footer();
