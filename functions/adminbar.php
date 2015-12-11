<?php

/**
 * 管理バーの追加を監視する
 */
add_filter( 'show_admin_bar', function () {
	return is_admin();
} );


/**
 * 管理バーに要素を追加
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	//ロゴ追加
	$logo = '<i class="fa fa-navicon ab-icon"></i><span class="ab-label">メニュー</span>';
	$wp_admin_bar->add_menu( array(
		'id'    => 'main-menues',
		'title' => $logo,
	) );
	//主要ページのメニューを追加
	$menu_name = 'main-pages';
	$wp_admin_bar->add_menu( array(
		'parent' => 'main-menues',
		'title'  => '<i class="fa fa-home ab-icon"></i><span class="ab-label">ホーム</span>',
		'id'     => 'main-pages',
		'href'   => home_url( '', 'http' ),
	) );
	//カテゴリー追加
	$wp_admin_bar->add_menu( array(
		'title'  => '<i class="fa fa-pencil-square-o ab-icon"></i><span class="ab-label">ブログ記事</span>',
		'id'     => 'category',
		'parent' => 'main-menues',
		'href'   => get_permalink( get_option( 'page_for_posts' ) ),
	) );
	$categories = get_terms( 'category', array(
		'parent'  => 0,
		'orderby' => 'id',
	) );
	foreach ( $categories as $cat ) {
		$wp_admin_bar->add_menu( array(
			'parent' => 'category',
			'id'     => 'cat-' . $cat->term_id,
			'title'  => $cat->name,
			'href'   => get_category_link( $cat ),
		) );
	}
	// 電子書籍
	$wp_admin_bar->add_menu( array(
		'id'     => 'ebook',
		'title'  => '<i class="fa fa-book ab-icon"></i><span class="ab-label">電子書籍</span>',
		'href'   => get_post_type_archive_link( 'ebook' ),
		'parent' => 'main-menues',
	) );
	// イベント
	$wp_admin_bar->add_menu( array(
		'id'     => 'event',
		'title'  => '<i class="fa fa-ticket ab-icon"></i><span class="ab-label">イベント</span>',
		'href'   => get_post_type_archive_link( 'events' ),
		'parent' => 'main-menues',
	) );
}, 1 );

/**
 * 管理バーを修正する
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	//WordPressロゴ削除
	$wp_admin_bar->remove_node( 'wp-logo' );
}, 10000 );
