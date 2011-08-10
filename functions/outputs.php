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
		return single_post_title('', false);
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
		return "高橋文樹.comの投稿";
	}
}

function fumiki_share($title, $url){
	
	echo <<<EOS
	<div class="like">
	<!-- Hatena -->
	<a href="http://b.hatena.ne.jp/entry/{$url}" class="hatena-bookmark-button" data-hatena-bookmark-title="{$title}" data-hatena-bookmark-layout="vertical" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
	<!-- Facebook -->
	<iframe src="http://www.facebook.com/plugins/like.php?href={$fb_url}&amp;send=false&amp;layout=box_count&amp;width=70&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=60" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:70px; height:60px;" allowTransparency="true"></iframe>
	<!-- twitter -->
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="{$url}" data-text="「{$title}」" data-count="vertical" data-via="hametuha" data-related="takahashifumiki:破滅派の主催者です。" data-lang="ja">ツイート</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<!-- Google + -->
	<g:plusone size="tall" href="{$url}"></g:plusone>
	</div>
EOS;
}