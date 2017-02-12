<?php

/**
 * 管理バーの追加を監視する
 */
add_filter( 'show_admin_bar', function () {
	return is_admin();
} );
