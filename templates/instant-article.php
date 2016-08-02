<!doctype html>
<html lang="ja" prefix="op: http://media.facebook.com/op#">
<head>
	<meta charset="utf-8">
	<link rel="canonical" href="<?php the_permalink() ?>">
	<meta property="op:markup_version" content="v1.0">
	<?php
	$category = get_the_category();
	$tags = get_the_tags();
	if ( $tags && ! is_wp_error( $tags ) ) {
		$category = array_merge( $category, $tags );
	}
	if ( $category ) :
	?>
	<meta property="op:tags" content="<?= esc_attr( implode(', ', array_map( function( $cat ){
		return $cat->name;
	}, $category) ) ) ?>">
	<?php endif; ?>
</head>
<body>
<article>
	<header>
		<!-- The title and subtitle shown in your Instant Article -->
		<h1><?php the_title() ?></h1>

		<!-- The date and time when your article was originally published -->
		<time class="op-published" datetime="<?php the_time( DATE_ATOM ) ?>"><?php the_time( 'Y.m.d H:i' ) ?></time>

		<!-- The date and time when your article was last updated -->
		<time class="op-modified" dateTime="<?php the_modified_date( DATE_ATOM ) ?>"><?php the_modified_date( 'Y.m.d H:i' ) ?></time>

		<!-- The authors of your article -->
		<address>
			<a rel="facebook" href="https://www.facebook.com/TakahashiFumiki.Page/"><?php the_author() ?></a>
		</address>

		<!-- The cover image shown inside your article -->
		<?php if ( has_post_thumbnail() ) : $thumbnail = get_post( get_post_thumbnail_id() ) ?>
		<figure>
			<img src="<?= get_the_post_thumbnail_url( null, 'large' ) ?>" />
			<?php if ( $thumbnail->post_excerpt ) : ?>
			<figcaption><?= wp_kses( $thumbnail->post_excerpt, [ 'a' => [ 'href' ] ] ) ?></figcaption>
			<?php endif; ?>
		</figure>
		<?php endif; ?>

	</header>

	<!-- Body text for your article -->
	<?php the_content(); ?>

	<!-- An ad within your article -->
	<figure class="op-ad">
		<iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=264573556888294_1215205251825115&adtype=banner300x250"></iframe>
	</figure>

	<!-- Analytics code for your article -->
	<figure class="op-tracker">
		<iframe hidden>
			<script>
				(function (i,s,o,g,r,a,m) {i['GoogleAnalyticsObject']=r;i[r]=i[r]||function () {(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),                         m=s.getElementsByTagName(o)0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-5329295-4', 'auto');
				ga('require', 'displayfeatures');
				ga('set', 'campaignSource', 'Facebook');
				ga('set', 'campaignMedium', 'Social Instant Article');
				ga('send', 'pageview', {
					title: '<?= esc_js( get_the_title() ) ?>',
					page : '<?= preg_replace( '#^https?://takahashifumiki\.(com|info)#', '', get_permalink() ) ?>'
				});
			</script>
		</iframe>
	</figure>

	<footer>
		<?php if ( $related = yarpp_get_related() ) : ?>
		<!-- // Related posts -->
			<ul class="op-related-articles">
				<?php $counter = 0; foreach ( $related as $rel ) : $counter++; ?>
				<li><a href="<?= get_permalink( $rel ) ?>"><?= esc_html( get_the_title( $rel ) ) ?></a></li>
				<?php if ( 3 <= $counter ) { break; } endforeach; ?>
			</ul>
		<?php endif; ?>
		<!-- Copyright details for your article -->
		<small>&copy; Takahashi Fumiki 2008</small>
	</footer>
</article>
</body>
</html>
