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
function fumiki_twitter($height = 300, $width = '"auto"', $loop = "true"){
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
	if(is_production() && !is_ssl()){
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
	$feed_url = 'http://cloud.feedly.com/#subscription%2Ffeed%2F'.rawurlencode(get_bloginfo('rss_url'));
	$feed_src = get_bloginfo('template_directory')."/styles/img/container-feedly.png";
	$subscribers = fumiki_feed_count();
	
	$fb_url = is_front_page() ? 'https://www.facebook.com/TakahashiFumiki.Page' : $url;
	
	echo <<<EOS
	<ul class="like">
		<li>
			<!-- Facebook -->
			<div class="fb-like" data-href="{$fb_url}" data-send="false" data-layout="box_count" data-width="72" data-show-faces="false"></div>
		</li>
		<li>
			<!-- twitter -->
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="{$url}" data-text="「{$title}」" data-count="vertical" data-via="takahashifumiki" data-related="hametuha:高橋文樹の主催するオンライン文芸誌です。" data-lang="ja">ツイート</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</li>
		<li>
			<!-- Hatena -->
			<a href="http://b.hatena.ne.jp/entry/{$url}" class="hatena-bookmark-button" data-hatena-bookmark-title="{$title}" data-hatena-bookmark-layout="vertical-balloon" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
		</li>
		<li>
			<!-- Google + -->
			<div class="g-plusone" data-href="{$url}" data-size="tall"></div>
			<script type="text/javascript">
				window.___gcfg = {lang: 'ja'};
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
		</li>
		<li>
			<!-- Feedly -->
			<a id="feedburner-count" href="{$feed_url}" title="高橋文樹.com 更新情報" rel="alternate" class="tool-tip inline-block">
				<span class="mono">{$subscribers}</span>
				<img src="{$feed_src}" alt="高橋文樹.com 更新情報" width="52" height="62" />
			</a>
		</li>
		<li>
            <!-- Pocket -->
            <a data-pocket-label="pocket" data-pocket-count="vertical" class="pocket-btn" data-lang="en"></a>
            <script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
		</li>
	</ul>
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
 * @param bool $show_nophoto falseにすると、ない場合は何も表示しない
 * @param bool $echo
 * @return string
 */
function fumiki_archive_photo($size = "medium-thumbnail", $post = null, $show_nophoto = true, $echo = true){
	$post = get_post($post);
    $image_id = false;
    if( has_post_thumbnail($post->ID) ){
        $image_id = get_post_thumbnail_id();
    }else{
        $images = get_children("post_parent=".$post->ID."&post_mime_type=image&orderby=menu_order&order=ASC&posts_per_page=1");
        if(!empty($images)){
            $image_id = current($images)->ID;
        }
    }
    if( $image_id ){
		if($echo){
			echo wp_get_attachment_image($image_id,$size);
		}else{
			return wp_get_attachment_image($image_id,$size);
		}
	}elseif( $show_nophoto ){
		$width = ($size == "medium-thumbnail") ? 280 : 150;
		$height = ($size == "medium-thumbnail") ? 200 : 100;
		$src = ($size == "medium-thumbnail") ? "archive_nophoto.gif" : "archive_nophoto_small.gif";
		if($echo){
			echo '<img class="attachment-medium" src="'.get_bloginfo('template_directory').'/styles/img/'.$src.'" width="'.$width.'" height="'.$height.'" alt="写真なし" />';
		}
	}
}

/**
 * カバー画像のURLを返す
 * @param int|object $post
 * @return string
 */
function ebook_cover_src($post = null){
	$post = get_post($post);
	$attachment_id = get_post_meta($post->ID, 'cover', true);
	if(!$attachment_id){
		return '';
	}
	if(is_numeric($attachment_id)){
		$attachment = wp_get_attachment_image_src($attachment_id, 'large');
		if($attachment){
			return $attachment[0];
		}else{
			return '';
		}
	}else{
		return $attachment_id;
	}
}

/**
 * アーカイブページでループを出力する
 * @global object $post 現在の投稿
 * @param string $additional_class
 * @param string $score
 * @param int $level 
 */
function fumiki_loop_container($additional_class = '', $score = false, $level = 2, $counter = 0){
	global $post;
	?>
	<div class="archive-box archive-box-small<? if(!empty($additional_class)) echo ' '.$additional_class;?> archive-box-<?= get_post_type(); ?>">
		
		<div class="post-type post-type-<?= get_post_type(); ?> clearfix">
			<span class="post-type-label label-<?= get_post_type(); ?>">
				<? switch(get_post_type()): case 'ebook': ?>
					<i class="fa-book"></i>
				<? break; case 'events': ?>
					<i class="fa-bullhorn"></i>
				<? break; default: ?>
					<i class="fa-pencil"></i>
				<? endswitch; ?>
				<?= get_post_type_object(get_post_type())->labels->name; ?>
			</span>
			<span class="post-counter-label"><?= $counter; ?></span>
		</div>
			
		<h<? echo $level; ?> class="archive-title">
			<a href="<? the_permalink(); ?>"><? the_title(); ?></a>
		</h<? echo $level; ?>>
		
		<small class="mono">
			<? printf('%s　%s前', get_the_time('Y/n/j (D)'), human_time_diff(strtotime($post->post_date))); ?>
		</small>
			
		<a class="photo" href="<? the_permalink(); ?>">
			<? if(get_post_type() == 'ebook'): ?>
				<img class="cover" src="<? echo ebook_cover_src(); ?>" alt="<? the_title(); ?>" width="240" height="320" />
				<? if(!lwp_on_sale()): ?>
					<img class="on-sale" src="<? bloginfo('template_directory'); ?>/styles/img/fa-sale-48.png" width="48" height="48" alt="On Sale" />
				<? endif; ?>
				<p class="price old">
					<? lwp_the_price() ?>
				</p>
			<? else: ?>
				<? fumiki_archive_photo("thumbnail", $post, false); ?>
			<? endif; ?>
		</a>
		
		<? if(get_post_type() == 'events'): ?>
		<table class="event-table">
			<tr>
				<th><i class="fa-calendar"></i>開催日時</th>
				<td>
					<? if(lwp_is_oneday_event()): ?>
						<?= lwp_event_starts('Y.n.j (D) <\b\r />H:i').'〜'.lwp_event_ends('H:i'); ?>
					<? else: ?>
						<? printf('開始: %s<br />終了: %s', lwp_event_starts('Y.n.j (D) H:i'), lwp_event_ends('Y.n.j (D) H:i')); ?>
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><i class="fa-time"></i>〆切</th>
				<td>
					<? if(lwp_is_event_available()): ?>
						<?= lwp_selling_limit('Y.n.j (D)'); ?>
					<? else: ?>
						募集終了
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><i class="fa-group"></i>参加人数</th>
				<td>
					<?= number_format(lwp_participants_number()); ?>名
				</td>
			</tr>
		</table>
		<? endif; ?>
		
		<div class="desc clearfix">
			<? the_excerpt(); ?>
		</div>
		
		<div class="taxonomies">
		<? switch(get_post_type()){
			case 'post':
				$tax = array(
					'category' => 'fa-folder-open',
					'post_tag' => 'fa-tags'
				);
				break;
			default:
				$tax = array();
				break;
		} ?>
		<? if(!empty($tax)): foreach($tax as $t => $icon_class):?>
			<? $terms = get_the_terms(get_the_ID(), $t); ?>
			<? if(!empty($terms) && !is_wp_error($terms)): ?>
			<span class="<?= $t; ?>">
				<? foreach($terms as $term): ?>
				<a href="<?= get_term_link($term); ?>">
					<i class="<?= $icon_class; ?>"></i>
					<?= esc_html($term->name); ?>
				</a>
				<? endforeach; endif; ?>
			</span>
		<? endforeach; endif; ?>
		</div>
		<? if($score): ?>
			<span class="score"><? echo $score; ?></span>
		<? endif; ?>
		<p class="more">
			<a class="button-blue" href="<? the_permalink(); ?>">見る &raquo;</a>
		</p>
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
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 高橋文樹投稿下 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-0087037684083564"
     data-ad-slot="2946163640"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOS;
			break;
		case 3:
			if(wp_is_mobile()){
				google_ads(4);
			}else{
				echo <<<EOS
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 高橋文樹.com2011関連投稿 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-0087037684083564"
     data-ad-slot="0384965250"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
EOS;
			}
			break;
		case 4:
			echo <<<EOS
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 高橋文樹サイドバー2011 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-0087037684083564"
     data-ad-slot="6378073345"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
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
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
EOS;
			break;
		case 6:
			echo <<<EOS
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0087037684083564";
/* 高橋文樹 200x200 */
google_ad_slot = "5200234519";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
EOS;
			break;
		case 7:
			echo <<<EOS
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 高橋文樹スマートフォン上 -->
<ins class="adsbygoogle my_adslot"
     style="display:inline-block"
     data-ad-client="ca-pub-0087037684083564"
     data-ad-slot="9969902841"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
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
	$date_diff = get_outdated_days($post);
	echo '（<span class="mono">'.number_format($date_diff).'</span>日前）';
}

/**
 * 投稿が指定した日数を過ぎているか
 * @param int|object $post
 * @return boolean
 */
function is_expired_post($post = null){
	return get_outdated_days($post) > 365;
}

/**
 * 経過した日数を返す
 * @param int|object $post
 * @return int
 */
function get_outdated_days($post){
	$post = get_post($post);
	return floor((current_time('timestamp') - strtotime($post->post_date)) / 60 / 60 / 24);
}

/**
 * 過ぎている日数を返す
 * @param int|object $post
 * @return string
 */
function get_outdate_string($post = null){
	$post = _fumiki_get_post($post);
	$date_diff = floor((current_time('timestamp') - strtotime($post->post_date)) / 60 / 60 / 24);
	$year = "<strong><span class=\"mono\">".floor($date_diff / 365)."</span>年";
	if(($date_diff / 365) - $year > 0.5){
		$year .= "半";
	}
	return $year.'前</strong>';
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
 * @param string $sort 'count' 'eid', または 'hot'のいずれか
 *  
 */
function get_hatena_rss($sort = 'count'){
	$hatena_transient_name = 'hatena_hotentry_'.$sort;
	$xml = get_transient($hatena_transient_name) ;
	if(false === $xml){
		$endpoint = 'http://b.hatena.ne.jp/entrylist?sort='.$sort.'&url=http://takahashifumiki.com&mode=rss';
		$context = stream_context_create(array(
			'http' => array( 'timeout' => 3 )
		));
		$response = file_get_contents($endpoint, 0, $context);
		set_transient($hatena_transient_name, $response, 60 * 60 * 2);
		$xml = $response;
	}
	if($xml){
		return simplexml_load_string($xml);
	}else{
		return $xml;
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
    if(!function_exists('twitter_get_timeline')){
		return false;
	}
	$transient_name = "twitter_public_timeline_{$screen_name}_{$count}";
	$twt_timeline = get_transient($transient_name);
	if(false === $twt_timeline){
		$twt_timeline = twitter_get_timeline($screen_name, array(
			'count' => $count,
		));
		if($twt_timeline){
			set_transient($transient_name, $twt_timeline, 60 * 30);
		}
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
 * 最新の投稿日を返す
 * @global wpdb $wpdb
 * @return string
 */
function fumiki_get_latest_updated(){
	global $wpdb;
	$sql = <<<EOS
		SELECT post_date FROM {$wpdb->posts}
		WHERE post_type = 'post' AND post_status = 'publish'
		ORDER BY post_date DESC
		LIMIT 1
EOS;
	return $wpdb->get_var($sql);
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



/**
 * キャプションを上書き
 *
 * @param array $attr
 * @param string $string HTMLマークアップ
 * @param string $content
 * @return string
 */
function _fumiki_caption_shortcode($string, $attr, $content = null) {
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) ){
		return $content;
	}

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
	. do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_filter('img_caption_shortcode', '_fumiki_caption_shortcode', 10, 3);

