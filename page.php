<?php get_header(); ?>
	<div class="container container-main">
		<div class="row">

			<article id="main" class="col-xs-12 col-md-8">

				<?php get_template_part( 'templates/single', 'ad' ) ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<div class="entry clearfix">
						<?php the_content(); ?>
					</div>

					<?php wp_link_pages( array(
						'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
						'after'  => '</div>',
					) ); ?>

					<?php get_template_part( 'templates/single', 'share' ); ?>

				<?php endwhile; endif; ?>

			</article>
			<!-- #main ends -->
			<aside class="col-xs-12 col-md-4">
				<?php get_sidebar() ?>
			</aside>

		</div><!-- //.row -->

	</div><!-- container -->

<?php get_template_part( 'templates/front', 'footer' ) ?>

<?php get_footer();
