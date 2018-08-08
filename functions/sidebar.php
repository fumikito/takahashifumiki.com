<?php


//サイドバーの登録
register_sidebar( array(
	'name'          => 'トップページ',
	'id'            => 'normal-sidebar',
	'before_widget' => '<div id="%1$s" class="widget widget-front %2$s">',
	'after_widget'  => '</div><!--frontwidgets-->',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>'
) );

register_sidebar( array(
	'name'          => '通常サイドバー',
	'id'            => 'ebook-related',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widget-title">',
	'after_title'   => '</h2>'
) );



/**
 * メニューを登録する
 */
add_action( 'init', function () {
	register_nav_menus( array(
		'top-page'   => 'ヘッダー',
		'main-pages' => 'フッター',
	) );
} );
