<?php

/**
 * 管理バーの追加を監視する 
 */
function _fumiki_admin_bar_visible(){
	return !isset($_GET['lwp']);
}
add_filter('show_admin_bar', '_fumiki_admin_bar_visible');


/**
 * 管理バーを操作する
 * @param WP_Admin_Bar $wp_admin_bar 
 */
function _fumiki_admin_bar($wp_admin_bar){
	//ロゴ追加
	$logo = is_admin() ? get_bloginfo('name') : sprintf('<img class="adminbar-logo" src="%s/styles/img/header-logo.png" alt="%s" width="190" height="20" />', get_stylesheet_directory_uri(), get_bloginfo('name'));
	$wp_admin_bar->add_menu(array(
		'id' => 'main-menues',
		'title' => $logo,
		'href' => home_url('/', 'http')
	));
	//ダッシュボード
	if(current_user_can('edit_posts') && !is_admin()){
		$wp_admin_bar->add_menu(array(
			'parent' => 'main-menues',
			'title' => 'ダッシュボード',
			'href' => admin_url()
		));
	}
	//主要ページのメニューを追加
	$menu_name = 'main-pages';
	$wp_admin_bar->add_menu(array(
		'parent' => 'main-menues',
		'title' => '高橋文樹.comについて',
		'id' => 'main-pages',
		'href' => home_url('/about/', 'http')
	));
	if(!wp_is_mobile()){
		$location = get_nav_menu_locations();
		$menu = wp_get_nav_menu_object($location[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		foreach($menu_items as $key => $item){
			$wp_admin_bar->add_menu(array(
				'parent' => 'main-pages',
				'id' => 'page-menu-'.$key,
				'title' => $item->title,
				'href' => $item->url
			));
		}
	}
	//カテゴリー追加
	$wp_admin_bar->add_menu(array(
		'title' => 'ブログ',
		'id' => 'category',
		'parent' => 'main-menues',
		'href' =>  home_url('latest')
	));
	if(!wp_is_mobile()){
		$categories = get_terms('category', array(
			'parent' => 0,
			'orderby' => 'id'
		));
		foreach($categories as $cat){
			$wp_admin_bar->add_menu(array(
				'parent' => 'category',
				'id' => 'cat-'.$cat->term_id,
				'title' => $cat->name,
				'href' => get_category_link($cat)
			));
			$children = get_terms('category', array(
				'parent' => $cat->term_id,
				'exclude' => 47
			));
			foreach($children as $child){
				$wp_admin_bar->add_menu(array(
					'parent' => 'cat-'.$cat->term_id,
					'id' => 'cat-child-'.$child->term_id,
					'title' => '-- '.$child->name,
					'href' => get_category_link($child->term_id)
				));
			}
		}
	}
	$wp_admin_bar->add_menu(array(
		'id' => 'ebook',
		'title' => '電子書籍',
		'href' => get_post_type_archive_link('ebook'),
		'parent' => 'main-menues'
	));
	$wp_admin_bar->add_menu(array(
		'id' => 'event',
		'title' => 'イベント',
		'href' => get_post_type_archive_link('events'),
		'parent' => 'main-menues'
	));
}
add_action( 'admin_bar_menu', '_fumiki_admin_bar', 1);

/**
 * 管理バーを修正する
 * @param WP_Admin_Bar $wp_admin_bar 
 */
function _fumiki_admin_bar_fix($wp_admin_bar){
	//共通
	if(!is_admin()){
		//WordPressロゴ削除
		$wp_admin_bar->remove_node('wp-logo');
	}
	//ログインしていないユーザー向け
	if(!is_user_logged_in()){
		$wp_admin_bar->add_menu(array(
			'parent' => 'top-secondary',
			'id' => 'my-account',
			'title' => 'こんにちはゲストさん！'
		));
		$wp_admin_bar->add_group(array(
			'parent' => 'my-account',
			'id' => 'user-actions'
		));
		if(is_singular()){
			$url = wp_login_url(get_permalink());
		}else{
			$url = wp_login_url();
		}
		$wp_admin_bar->add_menu(array(
			'id' => 'adminbar-login',
			'parent' => 'user-actions',
			'title' => 'ログイン',
			'href' => $url
		));
		$wp_admin_bar->add_menu(array(
			'id' => 'adminbar-register',
			'parent' => 'user-actions',
			'title' => 'はじめての方は新規登録',
			'href' => preg_replace("/^.*href=\"([^\"]+)\".*$/", "$1", wp_register('', '', false))
		));
	}else{
		$wp_admin_bar->remove_menu('new-content');
	}
	$wp_admin_bar->remove_menu('site-name');
}
add_action( 'admin_bar_menu', '_fumiki_admin_bar_fix', 10000);