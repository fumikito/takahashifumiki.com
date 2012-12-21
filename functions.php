<?php
/**
 * @package takahashifumiki
 */

/**
 * @var string
 */
define("FUMIKI_VERSION", "4.0.0");

/**
 * テーマのバージョンを返す
 * @return string
 */
function fumiki_theme_version(){
	return wp_get_theme()->display('Version');
}

//エディタースタイルを登録
add_editor_style("editor-style.css");
//テーマサポートを追加
add_theme_support('menus');
//ファイルの読み込み
get_template_part("functions/assets");
get_template_part("functions/adminbar");
get_template_part("functions/actions");
get_template_part("functions/filters");
get_template_part("functions/utilities");
get_template_part("functions/outputs");
get_template_part("functions/wp_die");
get_template_part("functions/nlp");
get_template_part("functions/lwp");

//サイドバーの登録
register_sidebar(array(
	 'name' => "トップページ",
	 'id' => 'normal-sidebar',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2 %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h2><i class="icon-ok-sign"></i> ',
	 'after_title' => "</h2>"
));
register_sidebar(array(
	 'name' => "電子書籍",
	 'id' => 'ebook-sidebar',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2  %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h3><i class="icon-book"></i> ',
	 'after_title' => "</h3>"
));
register_sidebar(array(
	 'name' => "通常サイドバー",
	 'id' => 'ebook-related',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2 no-shadow %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h3 class="entry-widget-title"><i class="icon-ok-sign"></i> ',
	 'after_title' => "</h3>"
));
/**
 * 画像サイズを追加する
 */
add_image_size( 'medium-thumbnail', 300, 225, true );
add_image_size( 'pinky-cover', 90, 120, true );