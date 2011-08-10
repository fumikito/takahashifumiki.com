<?php
/**
 * @package takahashifumiki
 */

/**
 * @var string
 */
define("FUMIKI_VERSION", "2.0");

//エディタースタイルを登録
add_editor_style("editor-style.css");
//テーマサポートを追加
add_theme_support('menus');
//ファイルの読み込み
get_template_part("functions/actions");
get_template_part("functions/filters");
get_template_part("functions/utilities");
get_template_part("functions/outputs");
//サイドバーの登録
register_sidebar(array(
	 'name' => "フッター右端",
	 'id' => 'footer-sidebar',
	 'before_widget' => '<div id="%1$s" class="widget %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h4 class="widgettitle mono">',
	 'after_title' => "</h4>"
));
register_sidebar(array(
	 'name' => "通常投稿",
	 'id' => 'normal-sidebar',
	 'before_widget' => '<div id="%1$s" class="widget %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h3 class="widgettitle mono">',
	 'after_title' => "</h3>"
));
register_sidebar(array(
	 'name' => "電子書籍",
	 'id' => 'ebook-sidebar',
	 'before_widget' => '<div id="%1$s" class="widget %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h4 class="widgettitle mono">',
	 'after_title' => "</h4>"
));
/**
 * 画像サイズを追加する
 */
add_image_size( 'medium-thumbnail', 300, 225, true );