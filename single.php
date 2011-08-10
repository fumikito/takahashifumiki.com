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
		<div class="entry clearfix">
			<?php the_content(); ?>
		</div>
		<div class="share">
			<h3 class="mono">Share This</h3>
			<p>この記事を気に入ったら、ぜひシェアしてください。</p>
			<?php fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
		</div>
		<div class="related">
			<div class="google">
				
			</div>
			<?php related_posts(); ?>
		</div>
		<?php comments_template(); ?>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了