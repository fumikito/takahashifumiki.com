<?php
/*
 * 便利関数群
 */

if(!function_exists("h")){
	/**
	 * htmlspecialcharsのエイリアス
	 * @param string $str
	 * @return string
	 */
	function h($str){
		return htmlspecialchars($str, ENT_QUOTES);
	}
}



/**
 * アプリケーションの読み込み
 */
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR."slideshow.php");
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR."youtube.php");
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR."globalnavi.php");



//クラスの初期化
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."fumiki.class.php");
$fumiki = new Fumiki();

//initアクションにフックを登録
add_action("init", array($fumiki, "init"));


/************************************
 * コメントの書式定義
 ************************************/
function fumiki_comment_layout($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
?>
	<li <?php if(get_user_by_email($comment->comment_author_email)): comment_class('fumiki'); else: comment_class(); endif; ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar($comment,40 ); ?>
			<cite><?php comment_author_link(); ?><?php if(!get_user_by_email($comment->comment_author_email)) echo "<small>さん</small>"; ?></cite>
			<span class="old"><?php comment_date(); comment_time(); edit_comment_link('（編集）'); ?></span>
		</div><!-- .comment-author ends-->

		<?php comment_text(); ?>

		<div class="reply">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div><!-- .reply ends-->

<?php }


/**
 * トラックバックの数取得
 * @return
 * @param $id Object[optional]
 */
function fumiki_get_tb($id = ''){
	global $wpdb;
	global $table_prefix;
	$req = $wpdb->get_results("SELECT comment_ID,comment_post_ID,comment_date,comment_content,comment_author,comment_author_url ".
								"FROM ".$table_prefix."comments ".
								"WHERE comment_approved = '1' ".
								"AND comment_post_ID = '".$id."'".
								"AND (comment_type = 'pingback' ".
								"OR comment_type = 'trackback') ".
								"ORDER BY comment_date ASC");
	if($req){
		$str = '<ul class="post_tb">';
		foreach($req as $tb):
			$str .= "<li>";
			$str .= '<cite>'.
			            '<a href="'.$tb->comment_author_url.'" rel="nofollow" class="old">'.$tb->comment_author.'</a>より<br />'.
						'<small class="old">'.$tb->comment_date.'</small>'.
			        '</cite>';
			$str .= '<div>'.$tb->comment_content.'</div>';
			$str .= '</li>';
		endforeach;
		$str .= '</ul>';
		echo $str;
		return true;
	}
	else return false;
}


/**
 * 上に戻るリンクを出力
 * @return
 */
function fumiki_to_top(){ ?>
	<div class="toTop"><a href="#toTop">トップに戻る</a></div>
<?php }

/**
 * flashプラグインの後方互換
 * @return str
 */
function flash_converter($atts,$content = null){
	$arr = shortcode_atts(array(
		0 => null,
		'w' => null,
		'h' => null
	),$atts);
	$str = '<div id="fumiki_flash_container">'.
	           '<span style="display:none">';
	$str .= $arr[0];
	if(!is_null($arr['w'])) $str .= '::'.$arr['w'];
	if(!is_null($arr['h'])) $str .= '::'.$arr['h'];
	$str .= '</span>'.
			   '<noscript>'.
			   '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
	if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
	if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
	$str .= '>'.
	        '<param name="movie" value="'.$arr[0].'" />'.
			'<!--[if !IE]>-->'.
			'<object type="application/x-shockwave-flash" data="'.$arr[0].'"';
	if(!is_null($arr['w'])) $str .= ' width="'.$arr['w'].'"';
	if(!is_null($arr['h'])) $str .= ' height="'.$arr['h'].'"';
	$str .= '>'.
	        '<!--<![endif]-->'.
			'<!--[if !IE]>-->'.
			'</object>'.
			'<!--<![endif]-->'.
			'</object>'.
			'</noscript>'.
			'</div>';
	return $str;
}
//ショートコードに登録
add_shortcode('flash','flash_converter');

/**
 * Twitterウィジェットを表示
 * @param integer $width
 * @param integer $height
 * @return void
 */
function fumiki_twitter($width = 300, $height =200, $loop = "true")
{
?>
	<script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: 3,
		  interval: 3000,
		  width: <?php echo $width; ?>,
		  height: <?php echo $height; ?>,
		  theme: {
		    shell: {
		      background: '#ffffff',
		      color: '#00A0E9'
		    },
		    tweets: {
		      background: '#ffffff',
		      color: '#999999',
		      links: '#4d4945'
		    }
		  },
		  features: {
		    scrollbar: false,
		    loop: <?php echo $loop; ?>,
		    live: true,
		    hashtags: true,
		    timestamp: true,
		    avatars: false,
		    behavior: 'all'
		  }
		}).render().setUser('takahashifumiki').start();
	//]]>
	</script>
<?php
}