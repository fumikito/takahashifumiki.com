<?
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
		  width: <? echo $width; ?>,
		  height: <? echo $height; ?>,
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
		    loop: <? echo $loop; ?>,
		    live: true,
		    hashtags: true,
		    timestamp: true,
		    avatars: false,
		    behavior: 'all'
		  }
		}).render().setUser('takahashifumiki').start();
	//]]>
	</script>
<?
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
		<a href="http://nakanohito.jp/"><img src="http://nakanohito.jp/an/?u=201672&amp;h=893199&amp;w=96&amp;guid=ON&amp;t=" border="0" width="96" height="96" alt="" /></a>
		</noscript>
		<?
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
function fumiki_hotentry($title = "はてなブックマーク", $sort = "hot", $need_script = true, $num = 7){
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
	}elseif(is_post_type_archive('ebook')){
		return "高橋文樹の電子書籍一覧";
	}elseif(is_post_type_archive('events')){
		return "高橋文樹のイベント一覧";
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
	<div class="fb-like" data-href="{$fb_url}" data-send="false" data-layout="box_count" data-width="72" data-show-faces="false"></div>
	<!-- twitter -->
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="{$url}" data-text="「{$title}」" data-count="vertical" data-via="takahashifumiki" data-related="hametuha:高橋文樹の主催するオンライン文芸誌です。" data-lang="ja">ツイート</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js" async="async"></script>
	<!-- Google + -->
	<g:plusone size="tall" href="{$url}"></g:plusone>
	<!-- FeedBurner -->
	<a id="feedburner-count" href="{$feed_url}" title="高橋文樹.com 更新情報" rel="alternate" class="tool-tip inline-block">
		<span class="mono">{$subscribers}</span>
		<img src="{$feed_src}" alt="高橋文樹.com 更新情報" width="52" height="62" />
	</a>
	<!-- mixi いいね -->
	<div data-plugins-type="mixi-favorite" data-service-key="d288247468354a3415683ce1320a8403e84d5351" data-size="large" data-href="{$url}" data-show-faces="false" data-show-count="true" data-show-comment="true" data-width="75" data-height="65"></div><script type="text/javascript">(function(d) {var s = d.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//static.mixi.jp/js/plugins.js#lang=ja';d.getElementsByTagName('head')[0].appendChild(s);})(document);</script>
	</div>
EOS;
	
	/*
	<!-- linkedin -->
	<script src="http://platform.linkedin.com/in.js" type="text/javascript" async="async"></script>
	<script type="IN/Share" data-url="{$url}" data-counter="top"></script>
	 */
}

/**
 * アーカイブページのサムネイルを表示する
 * @param string $size thumbnail か medium 
 * @param object $post (optional) 指定しないばあいは現在の投稿
 * @return void
 */
function fumiki_archive_photo($size = "medium-thumbnail", $post = null){
	$post = _fumiki_get_post($post);
	$images = get_children("post_parent=".$post->ID."&post_type=attachment&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1");
	if(!empty($images)){
		$image = current($images);
		echo wp_get_attachment_image($image->ID,$size);
	}else{
		$width = ($size == "medium-thumbnail") ? 280 : 150;
		$height = ($size == "medium-thumbnail") ? 200 : 100;
		$src = ($size == "medium-thumbnail") ? "archive_nophoto.gif" : "archive_nophoto_small.gif";
		echo '<img class="attachment-medium" src="'.get_bloginfo('template_directory').'/img/'.$src.'" width="'.$width.'" height="'.$height.'" alt="写真なし" />';
	}
}


/**
 * アーカイブページでループを出力する
 * @param string $additional_class
 * @param string $score
 * @param int $level 
 */
function fumiki_loop_container($additional_class = '', $score = false, $level = 2){
	?>
	<div class="archive-box archive-box-small<? if(!empty($additional_class)) echo ' '.$additional_class;?> arvhice-<?= get_post_type(); ?>">
		<? if(is_search()): ?>
			<span class="post-type-label"><?= get_post_type_object(get_post_type())->labels->name; ?></span>
		<? endif; ?>
		<small class="old"><? the_time('Y/n/j (D)'); ?></small>
		<a class="photo dark_bg" href="<? the_permalink(); ?>">
			<? if(get_post_type() == 'ebook'): ?>
				
			<? else: ?>
				<? fumiki_archive_photo("thumbnail"); ?>
			<? endif; ?>
		</a>
		<h<? echo $level; ?> class="archive-title">
			<a href="<? the_permalink(); ?>"><?= fumiki_trim(get_the_title(), 28); ?></a>
		</h<? echo $level; ?>>

		<div class="desc">
			<p class="clearfix"><?= fumiki_trim(get_the_excerpt(), 40); ?></p>
		</div>
		<div class="taxonomies">
		<? if(get_post_type() == 'post'): ?>
			<span class="cat"><? the_category(",");?></span>
			<span class="tag"><? the_tags('', ' ');?></span>
		<? endif; ?>
		</div>
		<? if($score): ?>
			<span class="score"><? echo $score; ?></span>
		<? endif; ?>
	</div>
	<!-- .archive-box-small ends -->
	<?
}


/**
 * Google Adsenceを出力する
 * @param int $number 
 * @return void
 */
function google_ads($number = 1){
	switch($number){
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
		case 3:
			echo <<<EOS
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-0087037684083564";
				/* 高橋文樹.com2011関連投稿 */
				google_ad_slot = "0384965250";
				google_ad_width = 336;
				google_ad_height = 280;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
EOS;
			break;
		case 4:
			echo <<<EOS
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-0087037684083564";
				/* 高橋文樹サイドバー2011 */
				google_ad_slot = "6378073345";
				google_ad_width = 300;
				google_ad_height = 250;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
EOS;
			break;
		case 5:
			echo <<<EOS
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-0087037684083564";
				/* 髙橋文樹スマートフォン */
				google_ad_slot = "4758038990";
				google_ad_width = 320;
				google_ad_height = 50;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
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
		$year = "<strong><span class=\"mono\">".floor($date_diff / 365)."</span>年";
		if(($date_diff / 365) - $year > 0.5){
			$year .= "半";
		}
		echo $year.'前</strong>';
	}
	echo '<span class="mono">'.number_format($date_diff).'</span>日経過';
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

/**
 * はてなブックマークのXMLを返す
 *  
 */
function get_hatena_rss(){
	$hatena_transient_name = 'hatena_hotentry';
	$xml = get_transient($hatena_transient_name) ;
	if(false === $xml){
		$endpoint = 'http://b.hatena.ne.jp/entrylist?sort=count&url=http://takahashifumiki.com&mode=rss';
		$context = stream_context_create(array(
			'http' => array( 'timeout' => 3 )
		));
		$response = file_get_contents($endpoint, 0, $context);
		if(count($http_response_header) == 0 || $http_response_header[0] != 'HTTP/1.0 200 OK'){
			$xml = null;
		}else{
			set_transient($hatena_transient_name, $response, 60 * 60 * 2);
			$xml = $response;
		}
	}
	if($xml){
		return simplexml_load_string($xml);
	}else{
		return $xlm;
	}
}

/**
 * RSSから日付を返す
 * @param SimpleXMLElement $item
 * @return string 
 */
function get_hatena_date($item){
	$dc = $item->children('http://purl.org/dc/elements/1.1/');
	if($dc->date){
		return (string)$dc->date;
	}else{
		return "";
	}
}

/**
 * RSSからブックマーク数を返す
 * @param SimpleXMLElement $item
 * @return int
 */
function get_hatena_count($item){
	$hatena = $item->children('http://www.hatena.ne.jp/info/xmlns#');
	if($hatena->bookmarkcount){
		return (int)$hatena->bookmarkcount;
	}else{
		return 0;
	}
}


/**
 * Twitter タイムラインを取得する
 * @param int $count
 * @param string $screen_name 
 * @return array
 */
function get_twitter_timeline($count = 20, $screen_name = 'takahashifumiki'){
	$transient_name = "twitter_public_timeline_{$screen_name}_{$count}";
	$twt_timeline = get_transient($transient_name);
	if(false === $twt_timeline){
		$endpoint = 'https://twitter.com/statuses/user_timeline.json?screen_name='.(string)$screen_name.'&count='.intval($count);
		$context = stream_context_create(array(
			'http' => array( 'timeout' => 3 )
		));
		$response = file_get_contents($endpoint, 0, $context);
		if(count($http_response_header) == 0 || $http_response_header[0] != 'HTTP/1.0 200 OK'){
			$twt_timeline = null;
		}else{
			$twt_timeline = json_decode($response);
		}
		set_transient($transient_name, $twt_timeline, 60 * 30);
	}
	return $twt_timeline;
}

/**
 * つぶやきを無害化してリンクする
 * @param string $tweet
 * @return string
 */
function tweet_linkify($tweet){
	return preg_replace("/(https?:\/\/[^ 　\t\n\r]+)/u", '<a href="$1$2" target="_blank">$1$2</a>', esc_html($tweet));
}

/**
 * アスキーアートを表示する
 * @param array $args
 * @param string $content
 * @return string
 */
function _fumiki_asciiart($args, $content){
	return "<div style=\"line-height:1.8; font-size:16px; font-family:'Mona','IPA モナー Pゴシック','IPAMonaPGothic','IPA mona PGothic','IPA MONAPGOTHIC','MS PGothic AA','mona-gothic-jisx0208.1990-0','MS PGothic','ＭＳ Ｐゴシック', Osaka, mono;\">".$content.'</div>';
}
add_shortcode('aa', '_fumiki_asciiart');

/**
 * 文字列を特定の長さで切って返す
 * @param string $string
 * @param int $length
 * @param string $ellipsis
 * @return string 
 */
function fumiki_trim($string, $length = 32, $ellipsis = '&hellip;'){
	if(mb_strlen($string, 'utf-8') >= $length){
		return mb_substr($string, 0, $length, 'utf-8').$ellipsis;
	}else{
		return $string;
	}
}

/**
 * 指定した投稿タイプの公開記事数を返す
 * @global wpdb $wpdb
 * @param string|array $post_types
 * @return int 
 */
function fumiki_get_post_count($post_types = array()){
	global $wpdb;
	if(empty($post_types)){
		$post_types = array('post', 'page', 'ebook', 'events');
	}elseif(is_string($post_types)){
		$post_types = array($post_types);
	}
	$in_clouse = implode(',', array_map(function($var){
		return "'".(string)$var."'";
	}, $post_types));
	$sql = <<<EOS
		SELECT COUNT(ID) FROM {$wpdb->posts}
		WHERE post_status = 'publish' AND post_type IN ({$in_clouse})
EOS;
	return (int) $wpdb->get_var($sql);
}

/**
 * 投稿の総文字数を返す
 * @global wpdb $wpdb
 * @param array $post_types
 * @return string 
 */
function fumiki_get_post_length($post_types = array()){
	global $wpdb;
	if(empty($post_types)){
		$post_types = array('post', 'page', 'ebook', 'events');
	}elseif(is_string($post_types)){
		$post_types = array($post_types);
	}
	$in_clouse = implode(',', array_map(function($var){
		return "'".(string)$var."'";
	}, $post_types));
	$sql = <<<EOS
		SELECT SUM(CHAR_LENGTH(post_content)) FROM {$wpdb->posts}
		WHERE post_status = 'publish' AND post_type IN ({$in_clouse})
EOS;
	return (int) $wpdb->get_var($sql);
}

/**
 * はてなブックマークの総数を取得する
 * @return int
 */
function hatena_total_bookmark_count(){
	$cache = get_transient('hatena_bookmark_total_count');
	if(false === $cache){
		require ABSPATH . WPINC . '/class-IXR.php';
		$client = new IXR_Client('http://b.hatena.ne.jp/xmlrpc');
		$client->query('bookmark.getTotalCount', 'http://takahashifumiki.com/');
		$cache = $client->getResponse();
		set_transient('hatena_bookmark_total_count', $cache, 60 * 60 * 24);
	}
	return (int)$cache;
}

/**
 * カテゴリー名を渡すとリンクを返す
 * @param string $category_name
 * @return string 
 */
function get_cat_tag($category_name){
	$cat_id = get_cat_ID($category_name);
	if($cat_id){
		return sprintf('<a href="%s">%s</a>', get_category_link($cat_id), $category_name);
	}else{
		return '';
	}
}