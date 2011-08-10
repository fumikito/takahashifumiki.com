<?php
/**
 * @package WordPress
 */


/**
 * Twitterウィジェットを表示
 * @param integer $height
 * @param integer|string $width 初期値はauto
 * @return void
 */
function fumiki_twitter($height = 300, $width = '"auto"', $loop = "true")
{
?>
	<script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: 5,
		  interval: 3000,
		  width: <?php echo $width; ?>,
		  height: <?php echo $height; ?>,
		  theme: {
		    shell: {
		      background: 'none',
		      color: '#f0f0f0'
		    },
		    tweets: {
		      background: 'none',
		      color: '#dfdfdf',
		      links: '#ffffff'
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

/**
 * Facebookのいいねボックスを表示
 */
function fumiki_fb_like($width = 200, $height = 300, $icons = 20){
	$css = get_bloginfo('template_directory')."/css/facebook.css?".  filemtime(TEMPLATEPATH."/css/facebook.css");
	$page_id = "240120469352376";
	$app_key = "5e50204f4bd7cfd897c775db46e122a8";
	echo <<<EOS
<div id="fb-root"></div>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<script type="text/javascript">FB.init("{$app_key}");</script>
<fb:fan profile_id="{$page_id}" connections="{$icons}" width="{$width}" height="{$height}" css="{$css}" ></fb:fan>
EOS;
}

/**
 * はてなブックマークを出力する
 * @param string $title
 * @param string $sort hotかcount
 * @param type $need_script 同じページで2回以上読み込むなら2回目はfalse
 * @param type $num 初期値は5
 * @return void
 */
function fumiki_hotentry($title = "はてなブックマーク", $sort = "hot", $need_script = true, $num = 5){
	echo ($need_script) ? '<script language="javascript" type="text/javascript" src="http://b.hatena.ne.jp/js/widget.js" charset="utf-8"></script>' : '';
	echo <<<EOS
<script language="javascript" type="text/javascript">
//<![CDATA[
Hatena.BookmarkWidget.url   = "http://takahashifumiki.com";
Hatena.BookmarkWidget.title = "{$title}";
Hatena.BookmarkWidget.sort  = "{$sort}";
Hatena.BookmarkWidget.width = 0;
Hatena.BookmarkWidget.num   = {$num};
Hatena.BookmarkWidget.theme = "notheme";
Hatena.BookmarkWidget.load();
//]]>
</script>
EOS;
}