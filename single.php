<?php get_header(); ?>

<?php the_post(); ?>


	<div class="container container-main">
		<div class="row">

			<div class="page-header">

				<p class="page-header-image">
					<img class="page-header-src" alt="<?php bloginfo( 'name' ); ?>" src="<?= get_template_directory_uri(); ?>/assets/img/logo-front-page.png"
					     width="200" height="200"/>
				</p>
				
				<h1 class="page-header-text"><?= fumiki_single_title() ?></h1>

				<?php get_template_part( 'templates/meta', get_post_type() ); ?>

			</div>

			<article id="main" class="col-xs-12 col-md-9">

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="eyecatch row">
						<?php
						$attachment = get_post( get_post_thumbnail_id() );
						the_post_thumbnail( 'large', array(
							'alt'   => $attachment->post_title,
							'title' => $attachment->post_title,
						) );
						?>
						<?php if ( $attachment->post_excerpt ) : ?>
							<figcaption>
								<?= $attachment->post_excerpt ?>
							</figcaption>
						<?php endif ?>
					</figure>
				<?php endif; ?>

				<div class="row">
					<?php get_template_part( 'templates/single', 'ad' ) ?>
				</div>

				<?php if ( is_singular( 'post' ) && is_expired_post() ) : ?>
					<div id="outdated-post" class="alert alert-warning">
						この投稿は<?= get_outdate_string(); ?>の記事です。
						情報が古くなっている可能性があるので、その点ご了承ください。
					</div>
				<?php endif; ?>

				<?php if ( in_category( 'dream-diary' ) ) : ?>
					<div id="outdated-post" class="alert alert-info">
						この投稿は<a class="alert-link" href="<?= get_term_link( 'dream-diary', 'category' ) ?>">夢日記</a>です。
						まったく現実とはことなることが書いてある可能性がありますが、ご了承ください。
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $post->post_excerpt ) ) : ?>
					<div class="post-excerpt">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

				<!-- ebook -->
				<?php if ( 'ebook' == get_post_type() ) : ?>
					<div class="ebook-meta clearfix">
						<div class="img-container">
							<img class="cover" src="<?= get_post_meta( get_the_ID(), 'cover', true ); ?>"
							     alt="<?php the_title(); ?>" width="240" height="320"/>
						</div><!-- .img-container -->
						<?php get_template_part( 'templates/meta', 'ebook' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry clearfix">
					<?php the_content(); ?>
				</div>

				<?php wp_link_pages( array(
					'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
					'after'  => '</div>',
				) ); ?>

				<div id="contents-last">&nbsp;</div>

				<div class="row nextprevious">
					<?php previous_post_link( '<div class="prev">%link</div>', '<small>前の投稿</small><i class="fa fa-arrow-circle-left"></i>%title' ); ?>
					<?php next_post_link( '<div class="next">%link</div>', '<small>次の投稿</small><i class="fa fa-arrow-circle-right"></i>%title' ); ?>
				</div>

				<?php get_template_part( 'templates/single', 'share' ); ?>

				<div id="respond" class="row comment-wrapper" style="overflow-x: hidden;"><?php comments_template(); ?></div>

			</article>
			<!-- #main ends -->
			<aside class="col-xs-12 col-md-3 sidebar">
				<?php get_sidebar() ?>
			</aside>

		</div><!-- //.row -->

	</div><!-- container -->

<?php get_footer();
