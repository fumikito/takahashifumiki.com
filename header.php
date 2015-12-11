<?php

get_header( 'meta' );


?>

<header class="header header--main dark_bg">
	<a rel="home" class="header__logo" href="<?= home_url('/', 'http') ?>">
		<img src="<?= get_stylesheet_directory_uri() ?>/styles/img/logo-adminbar.png" width="32" height="32" alt="<?= esc_attr(get_bloginfo('name')) ?>">
	</a>

	<a id="toggle-menu" class="header__toggler" href="#">
		<i class="fa fa-bars"></i><i class="fa fa-close"></i>
	</a>
	<?php
	wp_nav_menu( array( 'theme_location'  => 'top-page',
	                          'container_class' => 'nav-menu',
	                          'container'       => 'nav'
	) );
	?>


	<a id="login-button" class="account" rel="nofollow" href="<?= wp_login_url($_SERVER['REQUEST_URI']) ?>" data-href="<?= admin_url('/index.php') ?>">
		<span class="account__logged-out">
			<i class="fa fa-user"></i> ログイン
		</span>
		<span class="account__logged-in">
			<i class="fa fa-dashboard"></i> 管理画面
		</span>
	</a>
</header>

<?php


if ( ! is_front_page() ){

	get_header( 'navi' );

	get_header( 'title' );

}


