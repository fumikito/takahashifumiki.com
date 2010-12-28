<?php global $fumiki; ?>
	<div id="right">
		<div class="tweet">
			<?php fumiki_twitter(); ?>
			<?php get_search_form(); ?>
		</div>
		
		<div class="social">
			<ul class="banner">
				<?php
					wp_list_bookmarks("categorize=0&category_name=バナー&title_li=&category_before=&category_after=");
				?>
			</ul>
		</div>
		
		<ul id="column1">
			<li class="book_ad">
				<script charset="utf-8" type="text/javascript" src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822/JP/hametuha-22/8001/44e350e4-5f34-4f29-b6a0-62408c33402d"> </script>
			</li>
			<li class="catnav">
				<h3>カテゴリー</h3>
				<ul>
					<?php wp_list_categories("title_li=&depth=2&exclude=47");?>
				</ul>
			</li>
			<li class="newpost">
				<h3>新着記事</h3>
				<?php $fumiki->newpost(); ?>
			</li>
			<li class="tags">
				<h3>タグ</h3>
				<ul><li><?php st_tag_cloud('cloud_sort=random&cloud_selection=random&title=&smallest=8&largest=18&maxcolor=#444444&mincolor=#AAAAAA'); ?></li></ul>
			</li>
		</ul><!-- #column1 ends-->


		<ul id="column2">
			<li class="adscense">
				<script type="text/javascript"><!--
				google_ad_client = "pub-0087037684083564";
				/* 高橋文樹.com 右カラム */
				google_ad_slot = "9905205451";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</li>
			<li class="insight">
				<!-- lastfm -->
				<a href="http://www.lastfm.jp/user/fumikito/?chartstyle=TakahashiFumikiRight2"><img src="http://imagegen.last.fm/TakahashiFumikiRight2/recenttracks/fumikito.gif" border="0" alt="fumikito's Profile Page" /></a>
			</li>
			<li class="adscense">
				<script type="text/javascript"><!--
				google_ad_client = "pub-0087037684083564";
				/* 120x600, 作成済み 09/04/11 */
				google_ad_slot = "5922527571";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</li>
			<li class="insight">
				<!-- 併せて読みたい -->
				<a href="http://awasete.com/show.phtml?u=http%3A%2F%2Ftakahashifumiki.com%2F"><img src="http://img.awasete.com/image.phtml?u=http%3A%2F%2Ftakahashifumiki.com%2F&s=1" width="125" height="125" alt="あわせて読みたいブログパーツ" border="0"></a>
			</li>
			<li class="insight">
				<!-- nakanohito -->
				<script type="text/javascript">
				<!--
				var refer = document.referrer;
				document.write("<a href='http://nakanohito.jp/'>");
				document.write("<img src='http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=&version=js&refer="+escape(parent.document.referrer)+"&url="+escape(parent.document.URL)+"' border='0' width='96' height='96' />");
				document.write("</a>");
				//-->
				</script>
				<noscript>
				<img src="http://nakanohito.jp/an/?u=201672&h=893199&w=96&guid=ON&t=" width="96" height="96" alt="" border="0" />
				</noscript>
				<!-- nakanohito end -->
			</li>
		</ul><!-- #column2 ends-->
	</div><!-- #right ends-->