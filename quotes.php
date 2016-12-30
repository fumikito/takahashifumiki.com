<?php get_header() ?>

<div class="container container-quotes">

	<div class="row">

		<div class="page-header">
			<p class="page-header-image">
				<img class="page-header-src" alt="<?php bloginfo( 'name' ); ?>" src="<?= get_template_directory_uri(); ?>/assets/img/logo-front-page.png"
				     width="200" height="200"/>
			</p>
			<h1 class="page-header-text">好きな言葉</h1>
		</div>


		<div class="col-xs-12 col-md-8 col-md-offset-2">


			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="quotes-loop<?= ( ! is_archive() ) ? ' quotes-single' : '' ?>">

					<p class="text-left quotes-sign">
						<i class="fa fa-quote-left"></i>
					</p>

					<blockquote class="quotes-content">
						<?php the_content() ?>
						<cite class="quotes-cite"><?php the_title() ?></cite>
					</blockquote>

					<p class="text-right quotes-sign">
						<i class="fa fa-quote-right"></i>
					</p>

					<div class="quotes-date text-right">
						<?php if ( is_archive() ) : ?>
							<a href="<?php the_permalink() ?>"><?= mysql2date( get_option('date_format'), $post->post_date, false ) ?></a>
						<?php else : ?>
							<span class="date">採録日: <?= mysql2date( get_option('date_format'), $post->post_date, false ) ?></span>
						<?php endif; ?>
					</div><!--- //.date -->

					<?php if ( ! is_archive() ) : ?>
						<hr />
						<p class="more-quotes text-center">
							<a class="btn btn-raised btn-primary btn-lg" href="<?= home_url( '/quotes/' ) ?>">好きな言葉一覧へ</a>
						</p>
					<?php endif; ?>


				</div><!-- //.quotes-loop -->
			<?php endwhile; endif; ?>
			<?php if ( is_archive() && function_exists( 'wp_pagenavi' ) ) {
				ob_start();
				wp_pagenavi();
				$content = ob_get_contents();
				ob_end_clean();
				echo str_replace( 'ページ', ' Pages', $content );
			} ?>
		</div>

	</div>

</div><!-- //.quotes-conainer -->

<?php get_footer() ?>
