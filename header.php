<?php

get_header( 'meta' );


?>
<header class="header">

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

		<div class="container-fluid">


		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= home_url( '/', 'http' ) ?>">
				<img src="<?= get_stylesheet_directory_uri() ?>/assets/img/favicon/faviconx120.png" width="32" height="32" alt="<?= esc_attr(get_bloginfo('name')) ?>">
			</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="header-navbar navbar-collapse collapse navbar-responsive-collapse">
			<?php
			wp_nav_menu( [
				'theme_location'  => 'top-page',
				'depth' => 2,
				'menu_class'      => 'nav navbar-nav',
				'container'       => 'false',
				'walker' => new Fumiki\Utility\Navwalker(),
			] );
			?>
		</div><!-- //.collapse -->
		</div>
	</nav>




</header>

<?php if ( ! is_front_page() ) : ?>

	<?php if ( function_exists( 'bcn_display' ) ) : ?>
		<div class="breadcrumb hidden-xs">
			<div class="container">
				<i class="fa fa-map-marker"></i>&nbsp;<?php bcn_display(); ?>
			</div>
		</div>
	<?php endif; ?>



<?php endif; ?>

<?php /*
<a id="login-button" class="account" rel="nofollow" href="<?= wp_login_url($_SERVER['REQUEST_URI']) ?>" data-href="<?= admin_url('/index.php') ?>">
		<span class="account__logged-out">
			<i class="fa fa-user"></i> ログイン
		</span>
		<span class="account__logged-in">
			<i class="fa fa-dashboard"></i> 管理画面
		</span>
</a>
*/ ?>
