<div class="podcast-list-item col-xs-12 col-md-6">

	<a href="<?php the_permalink(); ?>" class="podcast-list-link">


		<?php if ( 'video' == $post->episode_type ) : ?>
			<i class="fa fa-video-camera podcast-list-signal"></i>
		<?php else : ?>
			<i class="fa fa-headphones podcast-list-signal"></i>
		<?php endif; ?>

		<h2 class="podcast-list-title"><?php the_title(); ?></h2>

		<div class="podcast-list-meta">
			<span class="podcast-list-calendar">
				<i class="fa fa-calendar"></i> <?= esc_html( preg_replace( '#(\\d{2})-(\\d{2})-(\\d{4})#u', '$3/$2/$1', $post->date_recorded ) ?: '---' ) ?> 収録
			</span>
			<span class="podcast-list-duration">
				<i class="fa fa-clock-o"></i> <?= esc_html( $post->duration ) ?>
			</span>
		</div>

		<div class="podcast-list-excerpt">
			<?php the_excerpt() ?>
		</div>

	</a>

</div>
