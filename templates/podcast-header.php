<?php
$term = is_tax('series') ? get_queried_object() : fumiki_current_series( get_queried_object() );
if ( ! $eyectach = get_term_meta( $term->term_id, 'eyecatch_id', true ) ) {
	return;
}
?>
<header class="podcast-header podcast-header-<?= fumiki_podcast_slug() ?>">

	<div class="container">
		<div class="row">
		<h1 class="podcast-header-title">
			<?= wp_get_attachment_image( $eyectach, 'full', false, [
				'alt' => $term->name,
				'class' => 'podcast-header-image',
			] ) ?>
		</h1>
		</div>
	</div>
</header>
