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

/**
 * グローバル変数の設定
 */

$fumiki_contact = array(
	"mixi" => "http://mixi.jp/show_friend.pl?id=94088",
	"skype" => "skype:fumikito?chat",
	"twitter" => "http://twitter.com/takahashifumiki",
	"facebook" => "http://www.facebook.com/profile.php?id=1034317368&ref=profile",
	"hametuha" => "http://hametuha.org"
);


/**
 * Fumiki
 * WordPressで使うお役立ちクラス
 *
 */
class Fumiki{
	var $version = "1.2.1";
	var $root;
	var $template;
	var $blogTitle;
	var $MooTitle = "MooTools1.2.1日本語";
	var $mode;
	var $feed_uri = "http://feeds2.feedburner.com/takahashifumiki";
	var $comment_feed_uri = "http://feeds2.feedburner.com/takahashifumiki_comment";

	function __construct(){
		$this->root = get_bloginfo('siteurl');
		$this->template = get_bloginfo('template_directory');
		$this->blogTitle = get_bloginfo('name');
		//initアクションにフックを登録
		add_action("init", array($this, "init"));
	}
	
	/**
	 * WordPressの初期化後にフックを登録する
	 */
	function init(){
		if(!is_admin()){
			//MooToolsをスクリプトとして登録
			wp_register_script(
				"mootools",
				get_bloginfo("template_directory")."/js/mootools.js",
				array(),
				"1.2.4",
				true
			);
			//Overlayを登録
			wp_register_script(
				"overlay",
				get_bloginfo("template_directory")."/js/Overlay.js",
				array("mootools"),
				"0.9",
				true
			);
			//Javascriptの読み込みを登録
			add_action("wp_enqueue_scripts", array($this, "js"));
			//CSSの読み込みを登録
			add_action("wp_print_styles", array($this, "css"));
		}
	}

	/**
	 * ie6でなかったら、xml宣言を出力
	 * @return void
	 */
	function xml(){
		if(!preg_match("/MSIE 6\.0/",$_SERVER["HTTP_USER_AGENT"]))
			echo '<?xml version="1.0" encoding="utf-8"?>'."\n";
	}

	/**
	 * タイトルを出力する
	 * @void
	 */
	function title(){
		if(is_home()):
			echo $this->blogTitle;
			echo "&raquo;小説家が自ら情報を発信するサイト";
		elseif(is_page() || is_single()):
			single_post_title();
			echo "｜";
			if(in_category(47)) echo $this->MooTitle;
			else echo $this->blogTitle;

		elseif(is_category()):
			if(is_category(47)):
				echo "MooTools1.2.1日本語";
			else:
				single_cat_title();
			endif;
			echo "｜";
			echo $this->blogTitle;
		elseif(is_tag()):
			single_tag_title();
			echo "｜";
			echo $this->blogTitle;
		elseif(is_archive()):
			$month = explode(" ",single_month_title('',false));
			echo preg_replace("/月/","",$month[1])."年".$month[0]."月の投稿一覧";
			echo "｜";
			echo $this->blogTitle;
		elseif(is_search()):
			echo "「".get_search_query()."」の検索結果｜".$this->blogTitle;
		elseif(is_404()):
			echo "404 Page Not Found |";
			echo $this->blogTitle;
		endif;
	}

	/**
	 * bodyにクラスをつける
	 * @return
	 */
	function body(){
		if(is_home()){
			$this->mode = "home";
		}elseif(is_single()){
			if(is_tategaki()) $this->mode = "t_single";
			else $this->mode = "n_single";
			$this->mode .= " not_home";
		}elseif(is_page()){
			$this->mode = "n_single not_home page";
		}elseif(is_archive()){
			$this->mode = "n_single not_home archive";
		}elseif(is_search()){
			$this->mode = "n_single not_home search";
		}
		echo ' class="'.$this->mode.'"';
	}

	/**
	 * ヘッダーの解説をはき出す
	 * @return
	 */
	function desc(){
		if(is_home()){
			bloginfo('description');
		}elseif(is_single() || is_page()){
			echo preg_replace("/\n/s",'',get_the_excerpt());
		}elseif(is_category()){
			echo preg_replace("/\n/s", "", strip_tags(category_description()));
		}elseif(is_tag()){
			echo "高橋文樹.com内の「";
			single_tag_title();
			echo "」というキーワードの記事です。";
		}else{
			bloginfo('description');
		}
	}

	/**
	 * リンクを正規化
	 * @return
	 */
	function canonical(){
		if(is_single() || is_page()){
			echo '<link rel="canonical" href="';
			the_permalink();
			echo '" />';
		}else{

		}
	}

	/**
	 * ヘッダーを掃除する
	 * @return
	 * @param $contents Object
	 */
	function clean($contents){
		//スタイルタグを削除
		$str = preg_replace("/<style type=\"text\/css\">.*?<\/style>/","",$contents);
		//wp-pagenavi
		$str = preg_replace("/<\!.*?WP-PageNavi.*?WP-PageNavi.*?-->/s","",$str);
		echo $str;
	}

	/**
	 * CSSを書き込む
	 */
	function css(){
		global $is_winIE;
		if(!is_admin()){
			//メインスタイル
			wp_enqueue_style("main", get_bloginfo("template_directory")."/style.css", array(), $this->version, "screen");
			//IE用CSS
			if($is_winIE){
				wp_enqueue_style("ie-common", get_bloginfo("template_directory")."/css/ie.css", array(), $this->version, "screen");
				if(preg_match("/MSIE 7\.0/",$_SERVER["HTTP_USER_AGENT"]))
					wp_enqueue_style("ie7", get_bloginfo("template_directory")."/css/ie7.css", array(), $this->version, "screen");
				elseif(preg_match("/MSIE 6\.0/",$_SERVER["HTTP_USER_AGENT"]))
					wp_enqueue_style("ie6", get_bloginfo("template_directory")."/css/ie6.css", array(), $this->version, "screen");
			}
			//シングルページ用CSS
			if(is_singular()){
				//Multibox用のCSS
				wp_enqueue_style("multibox", get_bloginfo("template_directory")."/css/multibox/multibox.css", array(), "1.4.1", "screen");
				//MultiboxのIE用CSS
				if($is_winIE && preg_match("/MSIE 6\.0/",$_SERVER["HTTP_USER_AGENT"])){
					wp_enqueue_style("multibox-ie", get_bloginfo("template_directory")."/css/multibox/multibox-ie6.css", array(), "1.4.1", "screen");
				}
			}
		}
	}
	
	/**
	 * Javascriptを書き込む
	 */
	function js(){
		//ホームの場合はスライドショーと縦書きを読み込む
		if(is_home()){
			//スライドショー
			wp_enqueue_script(
				"floom",
				get_bloginfo("template_directory")."/js/floom.js",
				array("mootools"),
				"1.0",
				true
			);
			//縦書き
			wp_enqueue_script(
				"tategakizer",
				get_bloginfo("template_directory")."/js/Tategakizer.js",
				array("mootools"),
				$this->version,
				true
			);
			//その他もろもろ
			wp_enqueue_script(
				"takahashi_home",
				get_bloginfo("template_directory")."/js/takahashi_home.js",
				array("mootools"),
				$this->version,
				true
			);
		}
		//シングルページの場合
		if(is_singular()){
			//コメント用スクリプト
			wp_enqueue_script('comment-reply');
			//MultiBox
			wp_enqueue_script(
				"multibox",
				get_bloginfo("template_directory")."/js/Multibox.js",
				array("overlay"),
				"1.4.1",
				true
			);
			//その他
			wp_enqueue_script(
				"takahashi_single",
				get_bloginfo("template_directory")."/js/takahashi_single.js",
				array("mootools"),
				$this->version,
				true
			);
		}
		//全ページ共通のスクリプトを読み込む
		wp_enqueue_script(
			"takahashi_onload",
			get_bloginfo("template_directory")."/js/takahashi_onload.js",
			array("mootools"),
			$this->version,
			true
		);
		//
		//Google Analyticsを読み込む
		add_action("wp_print_scripts", array($this, "ga"), 10000);
	}
	
	/**
	 * Google Analyticsのコードを吐き出す
	 */
	function ga(){
		if($_SERVER["SERVER_NAME"] == "takahashifumiki.com"):
		?>
			<!-- Google Analytics // -->
			<script type="text/javascript">
			//<![CDATA[
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-5329295-1']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			//]]>
			</script>
			<!-- // Google Analytics -->
		<?php
		endif;
	}
	
	function feed(){
		echo $this->feed_uri;
	}


	function comment_feed(){
		echo $this->comment_feed_uri;
	}

	function archiver(){
		if(is_category()):
			echo '"';
			single_cat_title();
			echo '"カテゴリーの記事';
		elseif(is_tag()):
			echo '"';
			single_tag_title();
			echo '"というタグのついた記事';
		elseif(is_search()):
			echo '"';
			the_search_query();
			echo '"の検索結果';
		else:

		endif;
	}
	/**
	 * バナーを出力
	 * @return
	 * @param $clm Object[optional]
	 */
	function banner($clm = 1){
		global $fumiki_banner;
		$str = "";
		$counter;
		echo get_cat_ID("バナー");
		foreach($fumiki_banner as $key => $val):
			$counter++;
			if($clm > 1):
				if($counter % $clm == 1):
					$str .= '<li class="r">';
				else:
					$str .= '<li class="l">';
				endif;
			else:
				$str .='<li>';
			endif;
			$str .= '<a href="'.$val.'" title="'.$key.'">'.$key.'</a></li>';
		endforeach;
		echo $str;
	}

	/**
	 * カレンダーを出力
	 * @return
	 * @param $cont Object
	 */
	function dateformat($cont){
		$arr = explode(' ',$cont);
		$str = '<span class="year">'.$arr[0].'</span>';
		$str .= '<span class="date">'.$arr[1]."/".$arr[2].'</span>';
		$str .= '<span class="day">('.$arr[3].')</span>';
		$str .= '<span class="time">'.$arr[4].'</span>';
		echo $str;
	}
	
	/**
	 * ループ内で投稿に属する画像を一枚出力
	 * @return
	 * @param $cont Object
	 */
	function archive_photo($size = "medium"){
		global $post;
		$images = get_children("post_parent=".$post->ID."&post_type=attachment&post_mime_type=image");
		if(!empty($images)):
			ksort($images);
			$image = current($images);
			echo wp_get_attachment_image($image->ID,$size);
		else:
			$width = ($size == "medium") ? 200 : 150;
			$height = ($size == "medium") ? 150 : 100;
			$src = ($size == "medium") ? "archive_nophoto.gif" : "archive_nophoto_small.gif";
			echo '<img class="attachment-medium" src="'.$this->template.'/img/'.$src.'" width="'.$width.'" height="'.$height.'" alt="写真なし" />';
		endif;
	}

	/**
	 * 最新コメントを取得
	 *
	 * @return array
	 * @param $comments Object
	 */
	function comments($tag = 'li'){
		global $wpdb;
		global $table_prefix;
		$req = $wpdb->get_results("SELECT comment_ID,comment_post_ID,comment_date,comment_content,comment_author,comment_author_url FROM ".$table_prefix."comments WHERE comment_approved = '1' AND comment_type != 'pingback' ORDER BY comment_date DESC LIMIT 5");
		foreach($req as $c):
			echo "\t\t\t\t<".$tag."><h4>";
			if($c->comment_author_url):
				echo "<a rel=\"nofollow\" href=\"".$c->comment_author_url."\">".$c->comment_author."</a>";
			else:
				echo $c->comment_author;
			endif;
			echo "</h4><cite>".mb_substr(strip_tags($c->comment_content),0,50,'utf-8')."...<a href=\"".$this->root."?p=".$c->comment_post_ID."\" rel=\"nofollow\">続きを読む&raquo;</a></cite>".
			     "<small>".date('Y/n/d(D)',strtotime($c->comment_date))."</small></".$tag.">";
		endforeach;
	}

	/**
	 * ソーシャルブックマークを出力
	 * @return
	 * @param $url Object
	 * @param $title Object
	 */
	function socialbk($url,$title){?>
<div class="socialbk clearfix">
<a class="yahoo" href="#" onclick="window.open('http://bookmarks.yahoo.co.jp/bookmarklet/showpopup?t=<?php echo $title; ?>&amp;u=<?php echo $url; ?>&amp;opener=bm&amp;ei=UTF-8','popup','width=550px,height=480px,status=1,location=0,resizable=1,scrollbars=0,left=100,top=50',0); return false;" title="この記事をYahoo!ブックマークに追加" rel="nofollow">この記事をYahoo!ブックマークに追加</a>
<a class="google" href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo $url; ?>&title=<?php echo $title; ?>" title="この記事をGoogle Bookmarksに追加" target="_blank" rel="nofollow">この記事をGoogle Bookmarksに追加</a>
<a class="hatena" href="http://b.hatena.ne.jp/append?<?php echo $url; ?>" rel="nofollow" title="はてなにブックマーク">はてなにブックマーク</a>
<a class="twitter" href="http://twitter.com/home?status=<?php echo rawurlencode('読んだ '); echo $url;?>" title="この記事についてTwitterでつぶやく" target="_blank" rel="nofollow">この記事をTwitterでつぶやく</a>
<a class="delicious" href="javascript:location.href='http://del.icio.us/post?v=4;url='+encodeURIComponent(location.href)+';title='+encodeURIComponent(document.title)" rel="nofollow" title="このページをdel.icio.usに登録">このページをdel.icio.usに登録</a>
<a class="livedoor" href="http://clip.livedoor.com/redirect?link=<?php echo $url; ?>&title=<?php echo urlencode($title) ?>&jump=ref" title="この記事をクリップ！">この記事をLivedoorクリップ！</a>
<a class="nifty" href="javascript:(function(){location.href='http://clip.nifty.com/create?url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title);})()" rel="nofollow" title="このエントリをニフティクリップに登録">このエントリをニフティクリップに登録</a>
<a class="buzzur" href="http://buzzurl.jp/entry/<?php echo $url; ?>" rel="nofollow" title="このエントリをBuzzurlにブックマーク">このエントリをBuzzurlにブックマーク</a>
<a class="pookmark" href="javascript:window.location='http://pookmark.jp/post?url='+encodeURIComponent('<?php echo $url; ?>')+'&title='+encodeURIComponent('<?php echo $title ?>');" title="このページを POOKMARK Airlines の行き先に登録する">このページを POOKMARK Airlines の行き先に登録する</a>
<a class="blogpeople" href="javascript:void(window.open('http://www.blogpeople.net/ib_addlink.jsp?u='+escape(location.href)+'&amp;t='+escape(document.title),'blog_ib','scrollbars=no,width=475,height=350,left=100,top=100,status=yes,resizable=yes'))" rel="nofollow" title="このエントリを BlogPeople Instant Bookmark に登録">このエントリを BlogPeople Instant Bookmark に登録</a>
</div>
	<?php }

	function newpost(){
		$p = new WP_Query('showposts=5');
		echo '<ul>';
		while($p->have_posts()):$p->the_post(); $counter++; ?>
			<li>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"<?php if($counter ==5) echo ' class="last"'; ?>><?php the_title(); ?></a><br />
				<small><?php the_category(','); ?>&nbsp;<?php the_time('Y/n/j'); ?></small>
			</li>
<?php	endwhile;
		echo '</ul>';
	}
}

$fumiki = new Fumiki();

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

function fumiki_inquiry($content){
	if(is_page('inquiry')):
	global $fumiki_contact;
	$h = $fumiki_contact['hametuha'];
	$t = $fumiki_contact['twitter'];
	$f = $fumiki_contact['facebook'];
	$m = $fumiki_contact['mixi'];
	$s = $fumiki_contact['skype'];
	$str = <<< EOD
	<p>
		メール・コメント以外に、下記のサービスを利用して高橋文樹にコンタクトを取ることができます。
	</p>
	<ol id="web_service" class="clearfix">
		<li class="hametuha"><a title="破滅派通信編集部" href="$h">破滅派通信編集部</a></li>
		<li class="twitter"><a title="twitter"  href="$t" rel="nofollow">twitter</a></li>
		<li class="mixi"><a title="mixi"  href="$m" rel="nofollow">mixi</a></li>
		<li class="facebook"><a title="Facebook"  href="$f" rel="nofollow">Facebook</a></li>
		<li class="skype"><a title="skyupe"  href="$s" rel="nofollow">skype</a></li>
	</ol>
EOD;
	$content = $str.$content;
	endif;
	return $content;
}
//フィルター登録
add_filter("the_content",'fumiki_inquiry');

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