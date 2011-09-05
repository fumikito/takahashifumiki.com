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
 * なかのひとを出力する
 * @return void
 */
function fumiki_nakanohito(){
	if(is_production()){
		?>
		<p id="nakanohito"></p>
		<noscript>
		<img src="http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=" width="96" height="96" alt="" border="0" />
		</noscript>
		<?php
	}
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


/**
 * ページのタイトルを取得する
 * @return string
 */
function fumiki_title(){
	if(is_singular()){
		return get_the_title();
	}elseif(is_home()){
		return "最新の投稿";
	}elseif(is_category()){
		return 'カテゴリー: '.single_cat_title('', false);
	}elseif(is_tag()){
		return 'タグ: '.single_tag_title('', false);
	}elseif(is_tax()){
		return '';
	}elseif(is_date()){
		$month = explode("月", single_month_title('',false));
        return "{$month[1]}年{$month[0]}月の投稿";
	}elseif(is_search()){
		return "検索: ".get_search_query();
	}elseif(is_404()){
		return "ご指定のページは見つかりませんでした";
	}else{
		return wp_title('', false);
	}
}

/**
 * いいねボタンを出力する
 * @param string $title
 * @param string $url 
 * @return void
 */
function fumiki_share($title, $url){
	$feed_url = get_bloginfo('rss_url');
	$feed_src = get_bloginfo('template_directory')."/img/RSS-container.png";
	$subscribers = 'N/A';
	$saved_data = get_transient('feedburner_subscribers');
	if(false === $saved_data){
		$endpoint = "https://feedburner.google.com/api/awareness/1.0/GetFeedData?id=i25crst2uldga4n0o9ld5pkgpc&dates=".date('Y-m-d', gmmktime() - (60 * 60 * 24 * 2));
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$endpoint);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
		$response = curl_exec($ch);
		$res_array = array();
		preg_match("/circulation=\"(.*)\"/isU", $response, $res_array);
		if(is_numeric($res_array[1])){
			$subscribers = $res_array[1];
			set_transient('feedburner_subscribers', $res_array[1], 60 * 60 * 24);
		}
	}else{
		$subscribers = $saved_data;
	}
	
	$fb_url = is_front_page() ? urlencode('http://www.facebook.com/pages/高橋文樹/240120469352376') : urlencode($url);
	
	echo <<<EOS
	<div class="like">
	<!-- Hatena -->
	<a href="http://b.hatena.ne.jp/entry/{$url}" class="hatena-bookmark-button" data-hatena-bookmark-title="{$title}" data-hatena-bookmark-layout="vertical" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
	<!-- Facebook -->
	<iframe src="http://www.facebook.com/plugins/like.php?href={$fb_url}&amp;send=false&amp;layout=box_count&amp;width=72&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=60" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:72px; height:60px;" allowTransparency="true"></iframe>
	<!-- twitter -->
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="{$url}" data-text="「{$title}」" data-count="vertical" data-via="takahashifumiki" data-related="hametuha:高橋文樹の主催するオンライン文芸誌です。" data-lang="ja">ツイート</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<!-- Google + -->
	<g:plusone size="tall" href="{$url}"></g:plusone>
	<!-- FeedBurner -->
	<a id="feedburner-count" href="{$feed_url}" title="高橋文樹.com 更新情報" rel="alternate" class="tool-tip inline-block">
		<span class="mono">{$subscribers}</span>
		<img src="{$feed_src}" alt="高橋文樹.com 更新情報" width="52" height="62" />
	</a>
	</div>
EOS;
}

/**
 * アーカイブページのサムネイルを表示する
 * @param string $size thumbnail か medium 
 * @param object $post (optional) 指定しないばあいは現在の投稿
 * @return void
 */
function fumiki_archive_photo($size = "medium", $post = null){
	$post = _fumiki_get_post($post);
	$images = get_children("post_parent=".$post->ID."&post_type=attachment&post_mime_type=image&orderby=menu_order&order=ASC");
	if(!empty($images)){
		$image = current($images);
		echo wp_get_attachment_image($image->ID,$size);
	}else{
		$width = ($size == "medium") ? 280 : 150;
		$height = ($size == "medium") ? 200 : 100;
		$src = ($size == "medium") ? "archive_nophoto.gif" : "archive_nophoto_small.gif";
		echo '<img class="attachment-medium" src="'.get_bloginfo('template_directory').'/img/'.$src.'" width="'.$width.'" height="'.$height.'" alt="写真なし" />';
	}
}

/**
 * Google Adsenceを出力する
 * @param int $number 
 * @return void
 */
function google_ads($number = 1){
	switch($number){
		case 2:
			echo <<<EOS
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-0087037684083564";
			/* 高橋文樹 投稿内広告 */
			google_ad_slot = "5844658673";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
EOS;
			break;
		case 1:
		default:
			echo <<<EOS
			<div class="google">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-0087037684083564";
				/* 高橋文樹 top */
				google_ad_slot = "4068259334";
				google_ad_width = 600;
				google_ad_height = 15;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
EOS;
			break;
	}
}


/**
 * 投稿が古い場合にメッセージを出力する
 * @param object $post 
 * @return void
 */
function the_expiration_info($post = null){
	$post = _fumiki_get_post($post);
	$date_diff = floor((time() - strtotime($post->post_date)) / 60 / 60 / 24);
	if($date_diff > 365 && !is_page()){
		$year = floor($date_diff / 365)."年";
		if(($date_diff / 365) - $year > 0.5){
			$year .= "半";
		}
		echo <<<EOS
<p class="message warning">
この記事は{$year}以上前のものです。状況は変わっているかもしれません。
</p>
EOS;
	}
}

/**
 * Ustreamのチャンネルがオンエア中になっているかどうかを返す
 * @return boolean
 */
function is_on_air(){
	$ust_status_array = get_transient( 'ustream_status' ) ;
	if(false === $ust_status_array){
		$opt = stream_context_create(array(
			'http' => array( 'timeout' => 3 )
		));
		$ust_status_serial = file_get_contents('http://api.ustream.tv/php/channel/' . urlencode('一人バーベキュー入門') . '/getValueOf/status',0,$opt);
		$ust_status_array = unserialize($ust_status_serial);
		set_transient('ustream_status', $ust_status_serial, 120);
	}
	if(isset($ust_status_array['results']) && $ust_status_array['results'] == 'live'){
		return true;
	}else{
		return false;
	}
}