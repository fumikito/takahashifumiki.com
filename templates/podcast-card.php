<?php
if ( is_singular( 'podcast' ) ) {
	$terms = get_the_terms( get_post(), 'series' );
} elseif ( is_tax( 'series' ) ) {
	$terms = [ get_queried_object() ];
} else {
	return;
}
if ( ! $terms || is_wp_error( $terms ) ) {
	return;
}

foreach ( $terms as $term ) :
	$itunes_url = get_option( 'ss_podcasting_itunes_url_' . $term->term_id );
	if ( ! $itunes_url ) {
		continue;
	}
	$feed_url = home_url( '/feed/podcast/' . rawurlencode( $term->slug ) );
?>
<div class="container">

	<div class="row podcast-card-wrapper">

		<div class="col-xs-12 col-md-4 text-center">
			<a href="<?= get_term_link( $term ) ?>" class="btn btn-raised btn-success btn-lg"><i class="fa fa-list"></i> All episodes</a>
		</div>

		<div class="col-xs-12 col-md-4 text-center">
			<a href="<?= esc_attr( $itunes_url ) ?>" class="btn btn-raised btn-default btn-lg"><i class="fa fa-apple"></i> iTunes</a>
		</div>

		<div class="col-xs-12 col-md-4 text-center">
			<a href="<?= esc_attr( $feed_url ) ?>" class="btn btn-raised btn-warning btn-lg"><i class="fa fa-rss"></i> Subscribe</a>
		</div>

	</div>

</div>
<?php endforeach;