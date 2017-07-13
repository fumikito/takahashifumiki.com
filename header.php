<?php

get_header( 'meta' );


?>
<header class="header headroom">

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

		<div class="container-fluid">


			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-responsive-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= home_url( '/' ) ?>">
					<img src="<?= get_stylesheet_directory_uri() ?>/assets/img/favicon/faviconx120.png" width="32"
						 height="32" alt="<?= esc_attr( get_bloginfo( 'name' ) ) ?>">
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="header-navbar navbar-collapse collapse navbar-responsive-collapse">
				<?php
				wp_nav_menu( [
					'theme_location' => 'top-page',
					'depth'          => 2,
					'menu_class'     => 'nav navbar-nav',
					'container'      => 'false',
					'walker'         => new Fumiki\Utility\Navwalker(),
				] );
				wp_reset_postdata();
				?>
			</div><!-- //.collapse -->
		</div>
	</nav>


</header>

<?php
$image = get_header_image();
$has_eye_catch = is_front_page();
//exit;
if ( is_singular() && has_post_thumbnail( get_queried_object() ) ) {
	$image = get_the_post_thumbnail_url( get_queried_object(), 'full' );
	$has_eye_catch = true;
}
?>
<div id="front-image-wrapper" class="front-image<?= $has_eye_catch ? '-eyecatch': '' ?>">

	<div class="front-image-sheet" style="background-image: url('<?= esc_url( $image ) ?>')"></div>
	<div class="front-image-cover"></div>
	<div class="container front-image-container">

		<div class="front-image-title">

			<h1 class="front-image-text">
				<?php if ( is_front_page() ) : ?>
					<?= get_avatar( 1, 128, '', '高橋文樹.com', [ 'class' => 'front-image-avatar' ] ) ?>
				<?php else : ?>
					<?= fumiki_single_title() ?>
				<?php endif; ?>
			</h1>

			<?php if ( $has_eye_catch ) : ?>
			<a href="#" class="front-image-toggle" title="クリックすると写真がよく見えます">
				<i class="fa fa-camera"></i>
			</a>
			<?php endif; ?>

			<?php if ( is_front_page() && ( $image = fumiki_header_image() ) ) : ?>
				<?php if ( $image->post_excerpt ) : ?>
					<p class="front-image-credit"><?= $image->post_excerpt; ?></p>
				<?php endif; ?>
			<?php endif; ?>


		</div>
	</div>
</div>

<?php if ( 'ja' == fumiki_current_language() ) : ?>
<div class="english-speaker">

	<div class="container">

		<p>
			<i class="fa fa-globe"></i> Hi, I detected your main language is not Japanese.
			I have an english version of <a href="<?= home_url( '/en' ) ?>">about me</a>,
			so please try it!
		</p>

	</div>

</div>
<?php endif; ?>

<?php if ( ! is_front_page() ) : ?>

	<?php if ( function_exists( 'bcn_display' ) ) : ?>
		<div class="breadcrumb">
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
