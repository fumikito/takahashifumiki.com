<?php global $fumiki; ?>
	<div id="right">
		<div class="tweet">
			<?php fumiki_twitter(); ?>
		</div>
		
		<div class="social">
			<ul class="banner">
				<?php
					wp_list_bookmarks("categorize=0&category_name=バナー&title_li=&category_before=&category_after=");
				?>
			</ul>
		</div>
		
		<ul id="column1">
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
			<li class="comment">
				<h3>最新コメント</h3>
				<ul>
					<?php $fumiki->comments(); ?>
				</ul>
			</li>
			<li class="book_ad">
				<h3>最新書籍</h3>
				<p>
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="Player_1631949b-d1f4-4979-a4e6-59778849c179"  width="120px" height="500px">
					<param name="movie" value="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhametuha-22%2F8010%2F1631949b-d1f4-4979-a4e6-59778849c179&Operation=GetDisplayTemplate" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#FFFFFF" />
					<param name="allowscriptaccess" value="always" />
					<param name="wmode" value="transparent" />
					<embed src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhametuha-22%2F8010%2F1631949b-d1f4-4979-a4e6-59778849c179&Operation=GetDisplayTemplate" id="Player_1631949b-d1f4-4979-a4e6-59778849c179" quality="high" bgcolor="#ffffff" name="Player_1631949b-d1f4-4979-a4e6-59778849c179" allowscriptaccess="always"  type="application/x-shockwave-flash" align="middle" height="500px" width="120px" wmode="transparent"></embed>
				</object>
				<noscript>
					<a href="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822%2FJP%2Fhametuha-22%2F8010%2F1631949b-d1f4-4979-a4e6-59778849c179&Operation=NoScript">Amazon.co.jp ウィジェット</a>
				</noscript>
				</p>
				<div>
					僕の書籍その他です。
				</div>
			</li>
			<li class="tags">
				<h3>タグ</h3>
				<ul><li><?php st_tag_cloud('cloud_sort=random&cloud_selection=random&title=&smallest=8&largest=18&maxcolor=#444444&mincolor=#AAAAAA'); ?></li></ul>
			</li>
		</ul><!-- #column1 ends-->


		<ul id="column2">
			<li class="insight">
				<!-- valuecommerce -->
				<iframe frameborder="0" allowtransparency="true" height="600" width="120" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=879419532" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=879419532"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=879419532" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=879419532" height="600" width="120" border="0"></a></noscript></iframe>
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
				<!-- nakanohito -->
				<script LANGUAGE="Javascript">
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
			<li class="insight">
				<iframe frameborder="0" allowtransparency="true" height="125" width="125" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=879419537" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=879419537"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=879419537" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=879419537" height="125" width="125" border="0"></a></noscript></iframe>
			</li>
			<li class="insight">
				<iframe frameborder="0" allowtransparency="true" height="120" width="120" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=879021437" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=879021437"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=879021437" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=879021437" height="120" width="120" border="0"></a></noscript></iframe>
			</li>
		</ul><!-- #column2 ends-->
	</div><!-- #right ends-->