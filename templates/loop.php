<?php
/**
 * ループ内で使用
 */
?>
<li class="list-group-item post-loop-item">
	<a href="<?php the_permalink() ?>" class="post-loop-link clearfix">
		<div class="row-picture">
			<?php fumiki_archive_photo( 'thumbnail' ); ?>
		</div>
		<div class="row-content post-loop-content">

			<h3 class="list-group-item-heading post-loop-title"><?php the_title() ?></h3>

			<div class="post-loop-meta">
				<?php if ( is_singular( [ 'post', 'event' ] ) ) : ?>
					<span class="post-loop-meta-item">
				<i class="fa fa-calendar"></i> <?php printf( '%s（%s前）', get_the_date( 'Y.n.j' ), human_time_diff( strtotime( $post->post_date ) ) ); ?>
			</span>
				<?php endif; ?>
				<?php if ( $terms = get_the_category() ) : ?>
					<span class="post-loop-meta-item">
					<i class="fa fa-folder-open"></i> カテゴリー: <?= implode( ', ', array_map( function ( $term ) {
							return esc_html( $term->name );
						}, $terms ) ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $score = get_the_score() ) : ?>
					<span class="terms">
						<i class="fa fa-calculator"></i> 関連度<?= round( $score * 10 ); ?>%
					</span>
				<?php endif; ?>

			</div>

		</div>

	</a>
</li>
