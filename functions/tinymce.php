<?php

//エディタースタイルを登録
add_editor_style("styles/stylesheets/editor-style.css");


/**
 * iframeが削除されないようにする
 * @param array $initArray
 * @return array
 */
function _fumiki_tinymce($initArray) {
	if(!empty($initArray["extended_valid_elements"])){
		$initArray["extended_valid_elements"] .= ",";
	}
	$initArray[ 'extended_valid_elements' ] .= "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width],big";
	//選択できるブロック要素を変更
	$initArray['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,dt,dd,div,pre';
	//スタイリング用クラス
	$style_formats = array(
		array(
			'title' => 'ネタバレ',
			'block' => 'p',
			'classes' => 'netabare'
		),
		array(
			'title' => 'ドロップキャップ',
			'block' => 'p',
			'classes' => 'dropcap'
		),
		array(
			'title' => 'コード',
			'inline' => 'code'
		),
		array(
			'title' => 'デカ文字',
			'inline' => 'big',
		),
		array(
			'title' => 'サクセス',
			'block' => 'p',
			'classes' => 'message success'
		),
		array(
			'title' => 'エラー',
			'block' => 'p',
			'classes' => 'message warning'
		),
		array(
			'title' => '注意',
			'block' => 'p',
			'classes' => 'message notice',
		),
		array(
			'title' => '注釈',
			'inline' => 'span',
			'classes' => 'alert'
		),


	);
	$initArray['style_formats'] = json_encode($style_formats);
	return $initArray;
}
add_filter('tiny_mce_before_init', '_fumiki_tinymce', 10000);
