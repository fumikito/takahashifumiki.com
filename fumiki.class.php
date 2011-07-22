<?php

/**
 * Fumiki
 * WordPressで使うお役立ちクラス
 * @package wordpress
 * @author Takahashi Fumiki
 */
class Fumiki{
	var $version = "1.2.15";
	var $root;
	var $template;
	var $blogTitle;
	var $MooTitle = "MooTools1.2.1日本語";
	var $mode;
	var $feed_uri = "http://feeds2.feedburner.com/takahashifumiki";
	var $comment_feed_uri = "http://feeds2.feedburner.com/takahashifumiki_comment";
	var $contact = array(
		"mixi" => "http://mixi.jp/show_friend.pl?id=94088",
		"skype" => "skype:fumikito?chat",
		"twitter" => "http://twitter.com/takahashifumiki",
		"facebook" => "http://www.facebook.com/profile.php?id=1034317368&ref=profile",
		"hametuha" => "http://hametuha.org"
	);
	var $debug = true;

	/**
	 * コンストラクタ
	 * @return void
	 */
	function __construct(){
		$this->debug = !($_SERVER["SERVER_NAME"] == "takahashifumiki.com");
		$this->root = get_bloginfo('siteurl');
		$this->template = get_bloginfo('template_directory');
		$this->blogTitle = get_bloginfo('name');
	}
	
	/**
	 * WordPressの初期化後にフックを登録する
	 */
	function init(){
		global $wp_iwphone;
		if(!is_admin() &&  (!$wp_iwphone|| !$wp_iwphone->detectiPhone())){
			//Javascriptの読み込みを登録
			add_action("wp_enqueue_scripts", array($this, "js"));
			//CSSの読み込みを登録
			add_action("wp_print_styles", array($this, "css"), 10000);
			//管理バーを消す
			if(is_user_logged_in()){
			    show_admin_bar(false);
			    wp_deregister_script( 'admin-bar' );
			    wp_deregister_style( 'admin-bar' );
				add_filter('show_admin_bar', '__return_false');
				remove_action( 'wp_head', 'wp_admin_bar_header' );
				remove_action( 'wp_head', '_admin_bar_bump_cb' );
				remove_action('wp_footer','wp_admin_bar_render',1000);
			}
		}
		//使えるタグを追加する
		add_filter("tiny_mce_before_init", array($this, "add_allowed_tag"));
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
			if("ebook" == get_post_type())
				echo "電子書籍｜";
			if(in_category(47))
				echo $this->MooTitle;
			else
				echo $this->blogTitle;

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
		elseif(is_search()):
			echo "「".get_search_query()."」の検索結果｜".$this->blogTitle;
		elseif(is_author()):
			echo "高橋文樹の記事一覧｜".$this->blogTitle;
		elseif(is_archive()):
			$month = explode("月", single_month_title('',false));
			echo "{$month[1]}年{$month[0]}月の投稿一覧";
			echo "｜";
			echo $this->blogTitle;
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
			if(is_tategaki())
				$this->mode = "t_single";
			elseif("ebook" == get_post_type())
				$this->mode = "n_single ebook page";
			else
				$this->mode = "n_single post";
			$this->mode .= " not_home";
		}elseif(is_page()){
			global $post;
			$this->mode = "n_single not_home page ".$post->post_name;
		}elseif(is_archive()){
			$this->mode = "n_single not_home archive page";
		}elseif(is_search()){
			$this->mode = "n_single not_home archive search page";
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
			//wp-pagenaviのCSSを打ち消し
			wp_dequeue_style("wp-pagenavi");
			//tmkm-amazonのCSSを打ち消し
			remove_action("wp_head", "add_tmkmamazon_stylesheet");
			if(!$this->debug){
				//共通
				wp_enqueue_style("main", get_bloginfo("template_directory")."/style-compressed.css", array(), $this->version, "screen");
			}else{
				//メインスタイル
				wp_enqueue_style("main", get_bloginfo("template_directory")."/style.css", array(), $this->version, "screen");
			}
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
				//印刷用CSS
				wp_enqueue_style("fumiki-print", get_bloginfo('template_directory')."/css/print.css", array(), $this->version, "print");
			}
		}
	}
	
	/**
	 * Javascriptを書き込む
	 */
	function js(){
		//MooToolsを読み込み
		wp_enqueue_script(
			"mootools",
			get_bloginfo("template_directory")."/js/mootools.js",
			array(),
			"1.2.4",
			true
		);
		if($this->debug){
			//Overlayを読み込み
			wp_enqueue_script(
				"overlay",
				get_bloginfo("template_directory")."/js/Overlay.js",
				array("mootools"),
				"0.9.1",
				true
			);
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
			//MultiBox
			wp_enqueue_script(
				"multibox",
				get_bloginfo("template_directory")."/js/MultiBox.js",
				array("overlay"),
				"1.4.1.1",
				true
			);
			//ホームの処理が記載されたJS
			wp_enqueue_script(
				"takahashi_home",
				get_bloginfo("template_directory")."/js/takahashi_home.js",
				array("mootools", "tategakizer"),
				$this->version,
				true
			);
			//シングルページの処理
			wp_enqueue_script(
				"takahashi_single",
				get_bloginfo("template_directory")."/js/takahashi_single.js",
				array("mootools"),
				$this->version,
				true
			);
			//全ページ共通のスクリプトを読み込む
			wp_enqueue_script(
				"takahashi_onload",
				get_bloginfo("template_directory")."/js/takahashi_onload.js",
				array("mootools"),
				$this->version,
				true
			);
		}else{
			//本番環境では合体させたやつを読み込む
			wp_enqueue_script("takahashi", get_bloginfo("template_directory")."/js/takahashi.js", array("mootools"), $this->version, true);
		}
		//シングルページの場合
		if(is_singular()){
			//コメント用スクリプト
			wp_enqueue_script('comment-reply');
		}
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
	
	/**
	 * Filter Hooks for WordPress
	 * 
	 * @param array $inti_arr TinyMCEのタグ
	 * @return array
	 */
	function add_allowed_tag($init_arr){
		if(!empty($init_arr["extended_valid_elements"])){
			$init_arr["extended_valid_elements"] .= ",";
        }
		$init_arr["extended_valid_elements"] .= "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
		return $init_arr;
	}
	
	/**
	 * mixiチェックのコードを吐き出す
	 */
	function mixi_check($script = true, $button = "2", $url = "", $echo = true){
		if($script)
			$script = <<<EOS
			<script type="text/javascript" src="http://static.mixi.jp/js/share.js"></script>
EOS;
		else
			$script = "";
		if(empty($url))
			$url = get_permalink();
		$html = <<<EOS
            <iframe scrolling="no" frameborder="0" allowTransparency="true" style="overflow:hidden; border:0; width:80px; height:20px" src="http://plugins.mixi.jp/favorite.pl?href=http%3A%2F%2Ftakahashifumiki.com&service_key=d288247468354a3415683ce1320a8403e84d5351&show_faces=false&width=140"></iframe>
EOS;
		if($echo)
			echo $html;//.$script;
		else
			return $html;//.$script;
	}
	
	/**
	 * greeのLikeボタンを追加する
	 */
	function gree_like($url = "", $echo = true){
		if(empty($url))
			$url = get_permalink();
		$url = rawurlencode($url);
		$html = <<<EOS
			<iframe src="http://share.gree.jp/share?url={$url}&type=0&height=20" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" style="border:none; overflow:hidden; width:80px; height:20px;" allowTransparency="true"></iframe>
EOS;
		if($echo)
			echo $html;
		else
			return $html;
	}
	
	/**
	 * はてなブックマークに追加するリンクを出力
	 */
	function hatena_add($url = "", $title = "", $icon = "", $string = "このエントリーをはてなブックマークに追加", $echo = true){
		if(empty($url))
			$url = get_permalink();
		if(empty($title))
			$title = the_title("", "", false);
		$html = <<<EOS
			<a href="http://b.hatena.ne.jp/entry/{$url}" class="hatena-bookmark-button" data-hatena-bookmark-title="{$title}" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
			<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
EOS;
		if($echo)
			echo $html;
		else
			return $html;
	}
	
	/**
	 * Facebookのいいねボタンを追加する
	 */
	function facebook_like($url = "", $width = 280, $height = 80, $layout = "standard", $echo = true){
		if(empty($url))
			$url = get_permalink();
		$url = rawurlencode($url);
		$html = <<<EOS
			<iframe src="http://www.facebook.com/plugins/like.php?href={$url}&amp;layout={$layout}&amp;show_faces=true&amp;width={$width}&amp;action=like&amp;colorscheme=light&amp;height={$height}" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:{$width}px; height:{$height}px;" allowTransparency="true"></iframe>
EOS;
		if($echo)
			echo $html;
		else
			return $html;
	}
	
	/**
	 * つぶやきボタンを設置する
	 */
	function tweet_this($url = "", $echo = true){
		if(empty($url))
			$url = get_permalink();
		$html = <<<EOS
		<a href="http://twitter.com/share" class="twitter-share-button" data-url="{$url}" data-text="高橋文樹.com" data-count="horizontal" data-via="takahashifumiki" data-related="hametuha:オンライン文芸誌" data-lang="ja">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
EOS;
		if($echo)
			echo $html;
		else
			return $html;
	}
	
	function facebook_comments()
	{
		?>
		<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=182792691765099&amp;xfbml=1"></script><fb:comments href="<?php the_permalink(); ?>" num_posts="2" width="auto"></fb:comments>
		<?php
	}
	
	/**
	 *  フィードのURLを返す
	 */
	function feed(){
		echo $this->feed_uri;
	}

	/**
	 *  コメントフィードのURLを返す
	 */
	function comment_feed(){
		echo $this->comment_feed_uri;
	}

	function archiver(){
		if(is_category()):
			echo 'カテゴリー&quot;';
			single_cat_title();
			echo '&quot;の記事';
		elseif(is_tag()):
			echo 'タグ&quot;';
			single_tag_title();
			echo '&quot;のついた記事';
		elseif(is_search()):
			echo '&quot;';
			the_search_query();
			echo '&quot;の検索結果';
		elseif(is_author()):
			echo '高橋文樹の書いた記事';
		elseif(is_date()):
			echo '&quot;';
			$month = explode('月', single_month_title('', false));
			echo "{$month[1]}年{$month[0]}月";
			echo '&quot;の記事';
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
	 * @param $cont Object
	 * @return
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
	 * @param $cont Object
	 * @return
	 */
	function archive_photo($size = "medium"){
		global $post;
		$images = get_children("post_parent=".$post->ID."&post_type=attachment&post_mime_type=image");
		if(!empty($images)):
			ksort($images);
			$image = current($images);
			echo wp_get_attachment_image($image->ID,$size);
		else:
			$width = ($size == "medium") ? 280 : 150;
			$height = ($size == "medium") ? 200 : 100;
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
	function socialbk($url,$title){
		?>
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
		<?php
	}
	
	/**
	 * 最新の投稿を表示する
	 * 
	 * @deprecated
	 * @return void
	 */
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