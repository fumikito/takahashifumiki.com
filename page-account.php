<?php
/*
 * Template Name: アカウント
 */
get_header();
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div id="content" class="container account">
		<div class="row">

			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="entry clearfix">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; endif; ?>

<?php get_footer();
