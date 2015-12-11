<header class="margin header">

	<a class="single-logo" href="<?= home_url( '/', 'http' ) ?>">
		<img alt="<?php bloginfo( 'name' ); ?>" src="<?= get_template_directory_uri(); ?>/styles/img/logo-front-page.png"
		     width="256" height="256"/>
	</a>

	<h1 class="title"><?= fumiki_title(); ?></h1>

	<?php if ( is_singular( 'post' ) ) :  ?>
		<?php get_template_part( 'templates/meta', get_post_type() ); ?>
	<?php endif; ?>

</header><!-- header -->
