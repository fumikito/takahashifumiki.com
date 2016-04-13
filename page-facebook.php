<?php
/*
 * Template Name:Facebook
 */
nocache_headers();

// Only logged in user can see.
if ( ! is_user_logged_in() ) {
	auth_redirect();
}

add_filter('body_class', function($classes){
	$classes[] = 'fan-gate-body';
	return $classes;
});

$user = get_userdata( get_current_user_id() );

get_header( 'meta' );
?>
	<div id="fb-root">

		<?php get_header( 'title' ) ?>

		<div class="margin fan-gate">

			<?php if ( is_user_connected_with( 'facebook' ) ) : ?>
			<div class="fangate">

				<div class="fangate__status">
					Facebookと連携済みです
				</div>

				<div class="fangate__status">

				</div>

			</div>

			<?php endif; ?>

			<?php if ( have_posts() ) :  while ( have_posts() ) :  the_post(); ?>
			<div class="entry clearfix">
				<?php the_content();?>
				<?php if ( ! is_user_connected_with( 'facebook' ) ) : ?>
					<p class="message warning">
						<?= esc_html( $user->display_name ) ?>さんのアカウントは
						Facebookと連携されていないようです。
						<a href="<?= admin_url( 'profile.php' ) ?>">プロフィールページ</a>から
						アカウントの連携を行ってください。
					</p>
				<?php endif; ?>
			</div>
			<?php endwhile; endif; ?>

			<?php get_template_part('templates/share', 'general') ?>

		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>