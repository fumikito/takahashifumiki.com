<?php
the_post();
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
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main">
		<div class="post">
			<?php the_content(); ?>
		</div>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了