<?
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)):
	include_once(TEMPLATEPATH."/mootools/moo.php");
else:
/****************************
 * 通常
 ****************************/

get_header('meta');

the_post();
get_header('navi');
get_header('title');
?>
<div id="content" class="margin clearfix">
	<div id="main">
		<? if(is_singular('post') && is_expired_post()): ?>
			<p id="outdated-post" class="message warning">
				この投稿は<?= get_outdate_string(); ?>の記事です。情報が<a href="#">古く</a>なっている可能性があるので、その点ご了承ください。
			</p>
		<? endif; ?>
		<article class="entry clearfix">
			<? the_content(); ?>
		</article><!-- //.entry -->


		<? wp_link_pages(array(
			'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
			'after' => '</div>'
		)); ?>

		<div id="contents-last">&nbsp;</div>

		<div class="google-share clearfix">
			<div class="share">
				<? fumiki_share(get_the_title()." | ".get_bloginfo('name'), get_permalink()); ?>
			</div>
			<div class="ad">
				<? google_ads(3)?>
			</div>
			<div class="ad2">
				<? google_ads(2) ?>
			</div>
		</div><!-- //.google-share -->

		<div class="next-previous clearfix clrB">
			<p class="prev">
				<? previous_post_link('%link', '<i class="fa-arrow-circle-left"></i>%title');?>
			</p>
			<p class="next">
				<? next_post_link('%link', '<i class="fa-arrow-circle-right"></i>%title'); ?>
			</p>
		</div>
		
		<div id="respond"><? comments_template(); ?></div>

		<? get_template_part('templates/related', 'posts'); ?>

	</div>
	<!-- #main ends -->

	<div id="sidebar">
		<? get_sidebar(); ?>
	</div><!-- //#sidebar -->

</div><!-- //.margin -->

<?
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了