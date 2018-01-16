<?php

/**
 * 管理バーの追加を監視する
 */
add_filter( 'show_admin_bar', function () {
	return is_admin();
} );

add_action( 'admin_bar_menu', function( WP_Admin_Bar $admin_bar ) {
    // Add mailchimp.
    $admin_bar->add_group( [
        'id' => 'external',
        'title' => '外部サイト',
        'parent' => 'site-name',
    ] );
    $admin_bar->add_menu( [
        'id'     => 'mailchimp',
        'parent' => 'external',
        'title'  => 'MailChimp', 'text_domain',
        'href'   => 'https://us14.admin.mailchimp.com/lists/members?id=159311#p:1-s:10-so:null',
        'group'  => false,
        'meta' => [
            'target' => '_blank',
        ]
    ] );
    $admin_bar->add_menu( [
        'id'     => 'fb-page',
        'parent' => 'external',
        'title'  => 'Facebook',
        'href'   => 'https://www.facebook.com/TakahashiFumiki.Page/insights/?referrer=page_insights_tab_button',
        'group'  => false,
        'meta' => [
            'target' => '_blank',
        ]
    ] );
}, 9999 );
