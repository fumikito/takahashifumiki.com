<?php

/**
 * 電子書籍の投稿タイプを作る
 */
add_action( 'init', function() {
	if ( function_exists( 'lwp_files' ) ) {
		return;
	}
	register_post_type( 'ebook', [
		'label'  => '電子書籍',
		'public' => true,
	    'supports' => [ 'title', 'editor', 'author', 'custom-fields' ],
	] );
} );

/**
 * リダイレクトする
 */
add_action( 'template_redirect', function(){
	if ( is_singular( 'ebook' ) && ( $redirect_to = get_post_meta( get_the_ID(), 'redirect_to', true ) ) ) {
		wp_redirect( $redirect_to, 301 );
		exit;
	}
} );
