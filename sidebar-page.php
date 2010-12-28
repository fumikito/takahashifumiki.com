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
		<li class="newpost">
			<h3>新着記事</h3>
			<?php $fumiki->newpost(); ?>
		</li>
		
		<li class="insight center" style="margin-top:20px">
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
	</ul><!-- #column2 ends-->
</div><!-- #right ends-->