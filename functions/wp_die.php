<?php

/**
 * wp_dieの描画関数をフィルター
 * @param string $function
 * @return string
 */
function _fumiki_wp_die_handler($function){
     //get_bloginfoが使えれば使う。
     //なければデフォルトのwp_dieを使う
     if(function_exists("get_bloginfo") && "" != get_bloginfo("template_directory")){
          return "_fumiki_wp_die";
     }else{
          return $function;
     }
}
add_filter("wp_die_handler", "_fumiki_wp_die_handler", 1000);

/**
 * Render wp_die
 * @param string $message
 * @param string $title
 * @param array $args 
 */
function _fumiki_wp_die( $message, $title = '', $args = array() ) {
	$defaults = array( 'response' => 500 );
	$r = wp_parse_args($args, $defaults);

	$have_gettext = function_exists('__');

	if ( function_exists( 'is_wp_error' ) && is_wp_error( $message ) ) {
		if ( empty( $title ) ) {
			$error_data = $message->get_error_data();
			if ( is_array( $error_data ) && isset( $error_data['title'] ) )
				$title = $error_data['title'];
		}
		$errors = $message->get_error_messages();
		switch ( count( $errors ) ) :
		case 0 :
			$message = '';
			break;
		case 1 :
			$message = "<p class=\"message warning\">{$errors[0]}</p>";
			break;
		default :
			$message = "<ul class=\"message warning\">\n\t\t<li>" . join( "</li>\n\t\t<li>", $errors ) . "</li>\n\t</ul>";
			break;
		endswitch;
	} elseif ( is_string( $message ) ) {
		$message = "<p class=\"message warning\">$message</p>";
	}

	if ( isset( $r['back_link'] ) && $r['back_link'] ) {
		$message .= "\n<p><a class=\"button\" href='javascript:history.back()'>戻る</a></p>";
	}

	if ( defined( 'WP_SITEURL' ) && '' != WP_SITEURL )
		$admin_dir = WP_SITEURL . '/wp-admin/';
	elseif ( function_exists( 'get_bloginfo' ) && '' != get_bloginfo( 'wpurl' ) )
		$admin_dir = get_bloginfo( 'wpurl' ) . '/wp-admin/';
	elseif ( strpos( $_SERVER['PHP_SELF'], 'wp-admin' ) !== false )
		$admin_dir = '';
	else
		$admin_dir = 'wp-admin/';

	if ( !function_exists( 'did_action' ) || !did_action( 'admin_head' ) ) :
	if ( !headers_sent() ) {
		status_header( $r['response'] );
		nocache_headers();
		header( 'Content-Type: text/html; charset=utf-8' );
	}

	if ( empty($title) ){
		$title = 'エラー｜高橋文樹.com';
	}

	$text_direction = 'ltr';
	add_action('wp_enqueue_scripts', function(){
		if(is_admin()){
			wp_enqueue_style(
				'fumiki-style',
				get_bloginfo('template_directory')."/style.css",
				array(),
				FUMIKI_VERSION
			);
		}
	});
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Ticket #11289, IE bug fix: always pad the error page with enough characters such that it is greater than 512 bytes, even after gzip compression abcdefghijklmnopqrstuvwxyz1234567890aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz11223344556677889900abacbcbdcdcededfefegfgfhghgihihjijikjkjlklkmlmlnmnmononpopoqpqprqrqsrsrtstsubcbcdcdedefefgfabcadefbghicjkldmnoepqrfstugvwxhyz1i234j567k890laabmbccnddeoeffpgghqhiirjjksklltmmnunoovppqwqrrxsstytuuzvvw0wxx1yyz2z113223434455666777889890091abc2def3ghi4jkl5mno6pqr7stu8vwx9yz11aab2bcc3dd4ee5ff6gg7hh8ii9j0jk1kl2lmm3nnoo4p5pq6qrr7ss8tt9uuvv0wwx1x2yyzz13aba4cbcb5dcdc6dedfef8egf9gfh0ghg1ihi2hji3jik4jkj5lkl6kml7mln8mnm9ono -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title ?>｜高橋文樹.com</title>
    <?php wp_head(); ?>
</head>
<body>
	
	<div id="header" class="margin dark_bg">
		<div id="logo">
			<a rel="home" href="<?php bloginfo('url'); ?>">
				<img src="<?php bloginfo('template_directory'); ?>/img/header-logo.png" alt="高橋文樹.com" width="380" height="40" />
			</a>
			<p class="shadow">小説家高橋文樹が自ら情報を発信するブログです。</p>
		</div>
	</div>
	
	<div id="error404">
		<div class="container">
			<h1>
				<span><?php echo $r['response'].": ".get_status_header_desc($r['response']); ?></span>
			</h1>
<?php endif; ?>
	<?php echo $message; ?>
	<?php if ( !function_exists( 'did_action' ) || !did_action( 'admin_head' ) ) : ?>
			
		</div>
		<!-- .container ends -->
	</div>
	<!-- .error404 ends -->
	<div id="footer" class="dark_bg shadow">
		<div id="copy-note" class="margin mono clearfix divider">
			<p>
				&copy; 2008-<?php echo date('Y'); ?> Takahashi Fumiki
			</p>
			<p class="poweredby">
				Proudly powered by <a href="http://wordpress.org">WordPress</a>.
			</p>
		</div><!-- .copy ends-->
	</div>
	<?php endif; ?>
	<?php wp_footer(); ?>
</body>
</html>
<?php
	die();
}