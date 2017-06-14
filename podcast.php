<?php
add_filter( 'body_class', function( $classes ) {
	$classes[] = 'podcast-' . fumiki_podcast_slug();
	return $classes;
} );
add_filter( 'wp_title', function( $title, $sep ) {
	if ( is_tax( 'series' ) ) {
		$term = get_queried_object();
		return esc_html( "{$term->name}{$sep}Podcast" );
	} elseif ( is_singular( 'podcast' ) ) {
		$post = get_queried_object();
		$titles = [ get_the_title( $post ) ];
		$terms = get_the_terms( $post, 'series' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$titles[] = current( $terms )->name;
		}
		$titles[] = 'Podcast';
		$title = implode( $sep, $titles );
	}
	return $title;
}, 10, 2 );
get_header( 'meta' );
?>

<?php
if ( is_singular( 'podcast' ) ) {
	the_post();
	get_template_part( 'templates/podcast-header', fumiki_podcast_slug() );
	get_template_part( 'templates/podcast-player', fumiki_podcast_slug() );
	get_template_part( 'templates/podcast-card', fumiki_podcast_slug() );
	?>

	<?php

} elseif ( is_tax( 'series' ) ) {
	get_template_part( 'templates/podcast-header', fumiki_podcast_slug() );
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/loop-podcast', fumiki_podcast_slug() );
	}
	get_template_part( 'templates/podcast-card', fumiki_podcast_slug() );
} else {
	// TODO: Portal
}
?>

<footer class="podcast-footer podcast-footer-<?= fumiki_podcast_slug() ?>">
	&copy; 2008 <a href="<?= home_url() ?>">Takahashi Fumiki</a>
</footer>
<?php wp_footer(); ?>
</body>
</html>
