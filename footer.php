<div id="footer_wrapper">
<div id="footer">



<div class="footer_navi">
<h3>カテゴリー</h3>

<ul class="footer_navi_child">
<li class="cat-item"><a href="<?php echo $fumiki->root; ?>/category/announcement/" title="<?php echo strip_tags(category_description(71)); ?>">告知</a></li>
<li class="cat-item"><a href="<?php echo $fumiki->root; ?>/category/literature/" title="<?php echo strip_tags(category_description(3)); ?>">文芸活動</a>
<ul><?php wp_list_categories('child_of=3&title_li='); ?></ul>
</li>
</ul><!-- .footer_navi_child ends -->

<div class="footer_navi_child">
<ul>
	<li><a href="<?php echo $fumiki->root; ?>/category/web/" title="<?php echo strip_tags(category_description(6)); ?>">Web制作</a>
		<ul>
			<li><a href="<?php echo $fumiki->root; ?>/category/web/programing/" title="<?php echo strip_tags(category_description(8)); ?>">プログラミング</a></li>
			<li><a href="<?php echo $fumiki->root; ?>/category/web/design/" title="<?php echo strip_tags(category_description(7)); ?>">デザイン</a></li>
		</ul>
	</li>
	<li>
		<a href="<?php echo $fumiki->root; ?>/category/others/" title="<?php echo strip_tags(category_description(10)); ?>">その他雑文</a>
	</li>
</ul>

<h3 class="feed">フィード</h3>
<ul>
	<li><a href="<?php $fumiki->feed(); ?>" rel="alternate" title="高橋文樹.comの新着エントリー">新着エントリー</a></li>
	<li><a href="<?php $fumiki->comment_feed(); ?>" rel="alternate" title="高橋文樹.comの新着コメント">新着コメント</a></li>
</ul>

</div><!-- .footer_navi_child ends -->

</div><!-- .footer_navi_ends-->






<div class="footer_navi">

<div class="footer_navi_child">
<h3 class="pages">主なページ</h3>
<?php wp_page_menu('sort_column=ID&show_home=1'); ?>
</div><!-- .footer_navi_child ends-->

<div class="footer_navi_child">
<ul>
<?php wp_list_bookmarks('orderby=id&title_before=<h3 class="bm">&title_after=</h3>&title_li='); ?>
</ul>
<div class="about_copytright">
	<a rel="license" href="http://creativecommons.org/licenses/by-sa/2.1/jp/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/2.1/jp/80x15.png" width="80" height="15" /></a>
	高橋文樹.comの<a href="<?php echo $fumiki->root; ?>/policy/">著作権について</a>
</div>

</div><!-- .footer_navi_child ends-->

</div><!--footer_navi_ends -->



<div class="copy">
	&copy; 高橋文樹 2008-<?php echo date('Y'); ?>
</div><!-- .copy ends-->

</div><!-- #footer ends-->

</div><!-- #footer_wrapper ends -->

<?php
	$fumiki->js();
	wp_footer();
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5329295-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>