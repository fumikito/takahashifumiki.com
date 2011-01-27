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


<?php get_header("single"); ?>


<div id="content" class="clearfix">

	<div id="main">
		<div class="meta">
			<h1 class="mincho"><span><?php the_title(); ?><?php edit_post_link(" [編集]","<small>","</small>"); ?></span></h1>
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
					<span>【記事の長さ】</span>
					<?php
						$length = mb_strlen(strip_tags(preg_replace("/\[[^\]]*?\]/", "", get_the_content())), "utf-8");
						$time_to_finish = round($length / 400);
						$length = number_format($length);
						echo "<em class=\"old\">{$time_to_finish}分</em>程度<small>（約{$length}文字）</small>";
					?>
				</li>
				<li>
					<span>【カテゴリ】</span><?php the_category(', '); ?>
				</li>
				<li>
					<?php the_tags('<span>【タグ】</span>',', ',''); ?>
				</li>
			</ul>
			<p class="right">
				<?php $fumiki->hatena_add("", "", "", "はてブ"); ?>
				<?php $fumiki->mixi_check(false); ?>
				<?php $fumiki->gree_like(); ?>
				<?php $fumiki->tweet_this(); ?>
				<?php $fumiki->facebook_like("", 120, 21, "button_count"); ?>
			</p>
		</div><!-- .meta ends -->

		<div class="entry<?php if($post->post_password) echo ' blocked'; ?>">
			<?php
				$date_diff = floor((time() - strtotime(get_the_date("Y-m-d"))) / 60 / 60 / 24);
				if($date_diff > 365 && !is_page()):
			?>
			<p class="notice_old">
				この記事は<?php echo floor($date_diff / 365); ?>年以上前のものです。状況は変わっていたりします。<br />
				<cite title="Guillaume Apollinaire «Cors de chasse»">Passons Passsons puisque tout passe</cite>です。
			</p>
			<?php endif; ?>
			<?php the_content(); ?>
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
		</div><!-- .entry ends-->

		<?php
			if($multipage)
				wp_link_pages('before=<div class="page_navi old clrB"><span class="mincho">続き</span>&after=</div>');
			else
				echo '<div id="page_finish" class="clrB"><span class="mincho">終わり</span></div>';
		?>

		<div id="end_meta" class="clearfix">
			<!-- X:S ZenBackWidget --><script type="text/javascript">document.write(unescape("%3Cscript")+" src='http://widget.zenback.jp/?base_uri=http%3A//takahashifumiki.com&nsid=93705046058920128%3A%3A93705053843541286&rand="+Math.ceil((new Date()*1)*Math.random())+"' type='text/javascript'"+unescape("%3E%3C/script%3E"));</script><!-- X:E ZenBackWidget -->
			<?php fumiki_to_top(); ?>
		</div>
		<!--#end_meta ends-->

		<?php comments_template(); ?>

	</div><!-- #main ends-->

	<?php get_sidebar();?>

</div><!-- #content ends-->





</div><!-- #wrapper ends -->
<?php
endif;//縦書との分岐終了(ref:l.14)
get_footer();

endif;//Mootoolsと通常single.phpの分岐終了(ref:l.4)