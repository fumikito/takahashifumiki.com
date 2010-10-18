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
				
			<p class="center google">
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
				<?php the_content(); ?>
				<?php
					if(is_page("links"))
						wp_list_bookmarks("categorize=1&category=2,115");
					if(is_page("inquiry"))
						wp_list_bookmarks("categorize=1&category=115");
				?>
			</div>
			<!-- .entry ends -->
			
			<div id="page_finish" class="clrB">
				<span class="mincho">終わり</span>
			</div>
			<!-- #page_finish ends -->
			
			<div id="end_meta">
				<?php fumiki_to_top(); ?>
				
			<p class="center google">
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
			<!-- #end_meta -->
			
		</div>
		<!-- #main ends -->
		
		<?php get_sidebar("page"); ?>
		
	</div>
	<!-- #content -->

</div>
<!-- #wrapper ends -->

<?php
	get_footer();