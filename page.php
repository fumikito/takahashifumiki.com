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

                <?php
                $pages = [];
                if ( $parent_id = wp_get_post_parent_id( get_the_ID() ) ) {
                    $pages[] = get_post( $parent_id );
                }
                foreach ( get_posts( [
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'post_parent' => get_the_ID(),
                ] ) as $page ) {
                    $pages[] = $page;
                }
				if ( $pages ) {
					?>
                    <h2>関連ページ</h2>
                    <ol class="post-loop-list large">
						<?php
                        foreach ( $pages as $post ) : setup_postdata( $post );
                            ?>
							<?php get_template_part( 'templates/loop', 'large' ); ?>
						    <?php
                        endforeach;
						wp_reset_postdata();
						?>
                    </ol><!-- .entry ends-->
					<?php
				}
                ?>



			</article>
			<!-- #main ends -->

		</div><!-- //.row -->

	</div><!-- container -->

<?php get_footer();
