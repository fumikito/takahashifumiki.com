<?php
/*
 * Template Name: アカウント
 */
	if(!is_user_logged_in() && (!is_page("login") && !is_page('inquiry'))){
		auth_redirect ();
		die();
	}
	the_post();
	get_header('meta');
	get_header('navi');
	get_header('title');
?>

<div id="content" class="margin account" class="clearfix">
	<div class="entry">
	<?php the_content(); ?>
	</div>
</div>

<?php
	get_footer();
