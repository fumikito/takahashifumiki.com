<?php
the_post();
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)):
	include_once(TEMPLATEPATH."/mootools/moo.php");
else:
	get_header();

/****************************
 * 縦書のときだけテンプレ変更
 ****************************/
if(is_tategaki()):
	include_once(TEMPLATEPATH.'/single-tate.php');
else:
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
			<?php if(!is_page()): ?>
			<ul>
				<li>
					<span>【カテゴリ】</span><?php the_category(', '); ?>
				</li>
				<li>
					<?php the_tags('<span>【タグ】</span>',', ',''); ?>
				</li>
				<li><span>【コメント】</span><a href="#comments_wrapper"><?php comments_number('まだない','1件','%件'); ?></a></li>
			</ul>
			<?php else: ?>
				<br class="clrB" />
			<?php endif; ?>
		</div><!-- .meta ends -->

		<div class="entry<?php if($post->post_password) echo ' blocked'; ?>">
			<?php the_content(); ?>
		</div><!-- .entry ends-->

		<?php
			if($multipage) wp_link_pages('before=<div class="page_navi old"><span class="mincho">続き</span>&after=</div>');
			else echo '<div id="page_finish"><span class="mincho">終わり</span></div>';
		?>

		<div id="end_meta" class="clearfix">
			<div class="end_meta_box">
				<?php $fumiki->socialbk(get_permalink(),the_title("","",false)."|高橋文樹.com"); ?>
				<div class="adsence">
					<script type="text/javascript"><!--
						google_ad_client = "pub-0087037684083564";
						/* 160x90, 作成済み 09/05/04 */
						google_ad_slot = "9800691688";
						google_ad_width = 160;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
			<div class="end_meta_box">
				<?php related_posts(); ?>
			</div>
			<div class="end_meta_box">
				<h3 class="mesena"><?php the_title(); ?>の反響</h3>
				<dl class="mesena">
					<dt>コメント</dt>
					<dd>
						現在、コメントは<?php comments_number('0','1','%'); ?>件です。<br />
						<a href="#respond">コメント</a>したり、<a href="<?php echo $fumiki->root; ?>/inquiry/">コンタクト</a>してください。。
					</dd>
					<dt>この記事にリンクしてるブログ</dt>
					<dd>
						すいません、この機能は準備中です...
					</dd>
				</dl>
			</div>
			<?php fumiki_to_top(); ?>
		</div><!--#end_meta ends-->

		<?php if(!is_page()) comments_template(); ?>

	</div><!-- #main ends-->

	<?php get_sidebar();?>

</div><!-- #content ends-->





</div><!-- #wrapper ends -->
<?php
endif;//縦書との分岐終了(ref:l.14)
get_footer();

endif;//Mootoolsと通常single.phpの分岐終了(ref:l.4)
?>