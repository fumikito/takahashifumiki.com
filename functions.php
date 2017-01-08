<?php
/**
 * @package takahashifumiki
 */

/**
 * @const FUMIKI_VERSION テーマのバージョン
 */
define( 'FUMIKI_VERSION', wp_get_theme()->get( 'Version' ) );


/**
 * テーマのバージョンを返す
 * @return string
 */
function fumiki_theme_version() {
	return FUMIKI_VERSION;
}

// オートロードを定義
spl_autoload_register( function ( $class_name ) {
	$base_dir   = __DIR__ . '/includes';
	$class_name = str_replace( '_', '-', strtolower( ltrim( $class_name, '\\' ) ) );
	$file_name  = '';
	$namespace  = '';
	if ( ( $last_ns_pos = strrpos( $class_name, '\\' ) ) ) {
		$namespace  = substr( $class_name, 0, $last_ns_pos );
		$class_name = substr( $class_name, $last_ns_pos + 1 );
		$file_name  = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
		$file_name  = str_replace( 'fumiki/', $base_dir . DIRECTORY_SEPARATOR, $file_name );
	}
	$path = $file_name . $class_name . '.php';
	if ( file_exists( $path ) ) {
		require $path;
	}
} );


// Analyticsを登録
\Fumiki\Service\Google\Analytics::get_instance( array(
	'profile_id' => 'UA-5329295-4',
	'domain'     => WP_DEBUG ? 'takahashifumiki.info' : 'takahashifumiki.com',
) );

// タグ
/*
\Fumiki\Taxonomy\Rich_Taxonomy::get_instance(array(
	'post_tag'
));
*/

// コマンド
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( \Fumiki\Command\Twitter::COMMAND_NAME, '\Fumiki\Command\Twitter' );
//	WP_CLI::add_command( \Fumiki\Command\Facebook::COMMAND_NAME, '\Fumiki\Command\Facebook' );
}

// チャート
\Fumiki\Service\Google\Chart::get_instance( [] );

//テーマサポートを追加
add_theme_support( 'menus' );

//ファイルの読み込み
get_template_part( 'functions/assets' );
get_template_part( 'functions/backward', 'compats' );
get_template_part( 'functions/adminbar' );
get_template_part( 'functions/actions' );
get_template_part( 'functions/filters' );
get_template_part( 'functions/utilities' );
get_template_part( 'functions/outputs' );
get_template_part( 'functions/wp_die' );
get_template_part( 'functions/nlp' );
get_template_part( 'functions/lwp' );
get_template_part( 'functions/tinymce' );
get_template_part( 'functions/feed' );
get_template_part( 'functions/quotes' );
get_template_part( 'functions/hametuha' );
get_template_part( 'functions/cloudflare' );
get_template_part( 'functions/sidebar' );
get_template_part( 'functions/amp' );

/*
get_template_part('functions/wp-fulltext-search');
WP_Fulltext_Search::init();
*/
