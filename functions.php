<?php
/**
 * @package takahashifumiki
 */

/**
 * @const FUMIKI_VERSION テーマのバージョン
 */
define("FUMIKI_VERSION", "4.0.10");

/**
 * テーマのバージョンを返す
 * @return string
 */
function fumiki_theme_version(){
	return wp_get_theme()->display('Version');
}

// オートロードを定義
spl_autoload_register(function($class_name){
	$base_dir = __DIR__.'/includes';
	$class_name = str_replace('_', '-', strtolower(ltrim($class_name, '\\')));
	$file_name = '';
	$namespace = '';
	if( ($last_ns_pos = strrpos($class_name, '\\')) ){
		$namespace = substr($class_name, 0, $last_ns_pos);
		$class_name = substr($class_name, $last_ns_pos + 1);
		$file_name = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
		$file_name = str_replace('fumiki/', $base_dir.DIRECTORY_SEPARATOR, $file_name);
	}
	$path = $file_name.$class_name.'.php';
	if ( file_exists($path) ){
		require $path;
	}
});


// Analyticsを登録
\Fumiki\Service\Google\Analytics::get_instance(array(
	'profile_id' => 'UA-5329295-4',
	'domain' => WP_DEBUG ?  'takahashifumiki.info' : 'takahashifumiki.com',
));



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
get_template_part("functions/tinymce");
get_template_part("functions/feed");
get_template_part("functions/quotes");

/*
get_template_part('functions/wp-fulltext-search');
WP_Fulltext_Search::init();
*/

//サイドバーの登録
register_sidebar(array(
	 'name' => "トップページ",
	 'id' => 'normal-sidebar',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2 %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h2><i class="fa-check-circle"></i> ',
	 'after_title' => "</h2>"
));
register_sidebar(array(
	 'name' => "電子書籍",
	 'id' => 'ebook-sidebar',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2  %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h3><i class="fa-book"></i> ',
	 'after_title' => "</h3>"
));
register_sidebar(array(
	 'name' => "通常サイドバー",
	 'id' => 'ebook-related',
	 'before_widget' => '<div id="%1$s" class="box widget grid_2 no-shadow %2$s">',
	 'after_widget' => "</div>",
	 'before_title' => '<h3 class="entry-widget-title">',
	 'after_title' => "</h3>"
));
/**
 * 画像サイズを追加する
 */
add_image_size( 'medium-thumbnail', 300, 225, true );
add_image_size( 'pinky-cover', 90, 120, true );
