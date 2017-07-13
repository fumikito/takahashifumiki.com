<?php get_header(); ?>
	<div class="container container-main">
		<div class="row">

			<article id="main" class="col-xs-12 col-md-10 col-md-offset-1">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<div class="entry clearfix">
							<?php the_content(); ?>
						</div>

						<?php wp_link_pages( array(
							'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
							'after'  => '</div>',
						) ); ?>

					<?php endwhile; ?>

				<?php endif; ?>

				<?php get_template_part( 'templates/share', 'general' ) ?>

			</article>
			<!-- #main ends -->

		</div><!-- //.row -->

	</div><!-- container -->

<?php get_footer();
