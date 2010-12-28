<?php
/*
 * Template Name: 電子書籍
 */

	the_post();
	get_header();
?>

<div id="wrapper">
	
	<?php get_header("single"); ?>
	
	<div id="content" class="clearfix">
		<div class="catch center">
			<h1><img src="<?php bloginfo('template_directory'); ?>/img/ebooks_archive_banner.jpg" alt="<?php the_title(); ?>" width="948" height="254" /></h1>
		</div>
		<!-- catch ends -->
		
		<div id="main">
			<div class="entry">
				<?php $ebooks = get_posts("post_type=ebook&post_status=publish"); ?>
				
				<p class="count right sans">現在<strong class="old"><?php echo count($ebooks); ?></strong>冊の電子書籍があります</p>
				
				<!-- ▼list of ebooks -->
				<?php foreach($ebooks as $ebook): ?>
				<div class="book-list clearfix ebook-detail">
					
					<!-- ▼cover-image -->
					<img alt="<?php echo $ebook->post_title; ?>" src="<?php echo get_post_meta($ebook->ID, "cover", true); ?>" width="240" height="320" />
					<?php if(lwp_is_free(false, $ebook)):?>
					<img class="campaign" alt="無料" src="<?php bloginfo('template_directory'); ?>/img/ebook_ribon_free.png" width="120" height="124" /> 
					<?php elseif(lwp_on_sale($ebook)): ?>
					<img class="campaign" alt="キャンペーン中" src="<?php bloginfo('template_directory'); ?>/img/ebook_ribon_campaign.png" width="120" height="124" /> 
					<?php endif; ?>
					<!-- ▲cover-image -->
					
					<!-- ▼Book-data -->
					<h2><a href="<?php echo get_permalink($ebook->ID); ?>"><?php echo $ebook->post_title; ?></a></h2>
					<dl>
						<dt class="sans">分量</dt>
						<dd><small>四〇〇字詰め原稿用紙</small><span class="old"><?php echo lwp_ammount($ebook);?></span><small>枚</small></dd>
						<dt class="sans">価格</dt>
						<dd class="orange old">
							<?php if(lwp_is_owner($ebook) || lwp_is_free(true, $ebook)): ?>
							&yen;<?php echo number_format(lwp_original_price($ebook)); ?>
							<?php else: ?>
							&yen;<?php echo number_format(lwp_price($ebook)); ?>
								<?php if(lwp_on_sale($ebook)): ?>
									<small>←&yen;<?php echo number_format(lwp_original_price($ebook)); ?></small>
								<?php endif; ?>
							<?php endif; ?>
						</dd>
						<dt class="sans">あらすじ</dt>
						<dd class="desc">
							<?php echo wpautop($ebook->post_excerpt); ?>
						</dd>
					</dl>
					<!-- ▲Book-data -->
					<p class="center clrB more">
						<a class="sans" href="<?php echo get_permalink($ebook->ID); ?>">
							<?php echo $ebook->post_title; ?>の詳細を見る
						</a>
					</p>
				</div>
				<?php endforeach; ?>
				<!-- ▲list of ebooks -->
				
				<?php the_content(); ?>
			</div>
			<!-- .entry ends -->
			
			<div id="page_finish" class="clrB">
				<span class="mincho">終わり</span>
			</div>
			<!-- #page_finish ends -->
			
			<div id="end_meta" style="background:none">
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
		
		<?php get_sidebar("ebooks"); ?>
		
	</div>
	<!-- #content -->

</div>
<!-- #wrapper ends -->

<?php
	get_footer();

