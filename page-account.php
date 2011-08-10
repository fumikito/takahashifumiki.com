<?php
/*
 * Template Name: アカウント
 */
	if(!is_user_logged_in() && !is_page("login"))
		header("Location: ".get_bloginfo('url')."/login/?redirect_to={$_SERVER['REQUEST_URI']}");
	the_post();
	get_header('meta');
	get_header('navi');
	the_content();
	get_footer();
