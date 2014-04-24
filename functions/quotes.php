<?php

/**
 * Add rewrite rules
 *
 * @filter rewrite_rules_array
 * @param array $rules
 * @return array
 */
add_filter('rewrite_rules_array', function( array $rules ){
    return array_merge(array(
        '^quotes/?$' => 'index.php?quote=all',
        '^quotes/page/([0-9]+)/?$' => 'index.php?quote=all&paged=$matches[1]',
        '^quote/([0-9]+)/?$' => 'index.php?quote=$matches[1]',
    ), $rules);
});

/**
 * Add 'quote' to query vars
 *
 * @filter query_vars
 * @param array $vars
 * @return array
 */
add_filter('query_vars', function( array $vars ){
    $vars[] = 'quote';
    return $vars;
});

/**
 * 取得する投稿を変える
 */
add_filter('posts_request', function( $sql, \WP_Query &$wp_query ){
    /** @var \wpdb $wpdb */
    global $wpdb;
    if( $wp_query->is_main_query() && ($quote = $wp_query->get('quote')) ){
        $wp_query->set('ignore_sticky_posts', 1);
        $table_name = $wpdb->prefix.'quotescollection';
        if( 'all' == $quote ){
            $wp_query->is_archive = true;
            $paged = max(1, (int)$wp_query->get('paged')) - 1;
            $per_page = (int)get_option('posts_per_page');
            $query = <<<EOS
                SELECT SQL_CALC_FOUND_ROWS
                    quote_id AS ID,
                    quote AS post_content,
                    CONCAT(author, ' - ', source) AS post_title,
                    'publish' AS post_status,
                    time_added AS post_date,
                    time_added AS post_modified,
                    1 AS post_author,
                    'quote' AS post_type
                FROM {$table_name}
                ORDER BY time_added DESC
                LIMIT %d, %d
EOS;
            $sql = $wpdb->prepare($query, $paged * $per_page, $per_page);
        }else{
            $query = <<<EOS
                SELECT SQL_CALC_FOUND_ROWS
                    quote_id AS ID,
                    quote AS post_content,
                    CONCAT(author, ' - ', source) AS post_title,
                    'publish' AS post_status,
                    time_added AS post_date,
                    time_added AS post_modified,
                    1 AS post_author,
                    'quote' AS post_type
                FROM {$table_name}
                WHERE quote_id = %d
                LIMIT 1
EOS;
            $sql = $wpdb->prepare($query, $quote);
            $wp_query->is_singular = true;
        }
    }
    return $sql;
}, 10, 2);

/**
 * パーマリンクを変える
 *
 * @filter post_link
 * @param string $link
 * @param \WP_Post $post
 * return string
 */
add_filter('post_link', function($link, $post){
    if( 'quote' == $post->post_type ){
        $link = home_url("/quote/{$post->ID}/", 'http');
    }
    return $link;
}, 10, 2);


/**
 * テンプレートを差し替え
 *
 * @filter template_include
 * @param string $path
 * @return $path
 */
add_filter('template_include', function($path){
    /** @var \WP_Query $wp_query */
    global $wp_query;
    if( $wp_query->get('quote') && !$wp_query->is_404()){
        $path = get_template_directory().'/quotes.php';
    }
    return $path;
});

/**
 * カノニカルURLを書き換える
 */
add_action('wp_head', function(){
    global $wp_query;
    if( ($quote = $wp_query->get('quote')) && is_numeric($quote) ){
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', function() use ($quote){
            printf('<link rel="canonical" href="%s" />', home_url('/quote/'.$quote.'/', 'http'));
        });
    }
}, 1);
