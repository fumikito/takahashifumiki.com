<article class="podcast-main podcast-player-<?= fumiki_podcast_slug() ?>">

	<div class="container">

		<h2 class="podcast-player-title"><?php the_title(); ?></h2>

		<?php if ( has_excerpt() ) : ?>
			<div class="podcast-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<div class="podcast-content">
			<?php the_content(); ?>
		</div>

	</div>


</article>

<div class="container">
	<?php fumiki_share( get_the_title(), get_permalink() ) ?>
</div>

<div class="container podcast-pager">

	<div class="row">
		<div class="col-xs-6">
			<?php previous_post_link( '%link', '<small>前のエピソード</small>%title', true, '', 'series' ) ?>
		</div>
		<div class="col-xs-6">
			<?php next_post_link( '%link', '<small>次のエピソード</small>%title', true, '', 'series' ) ?>
		</div>
	</div>
</div>
