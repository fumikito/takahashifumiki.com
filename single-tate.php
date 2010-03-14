<div id="wrapper">





<div id="header" class="clearfix">
	<a id="logo" rel="home" href="<?php echo $fumiki->root; ?>"><?php echo $fumiki->blogTitle; ?></a>
	<a id="toTop"></a>
		<div class="meta">
			<h1 class="mincho"><?php the_title(); ?></h1>
			<small class="old"><?php the_date('Y/n/j(D) g:iA'); ?></small>
			<ul>
				<li>
					<span>【カテゴリ】</span><?php the_category(', '); ?>
				</li>
				<li>
					<?php the_tags('<span>【タグ】</span>',', ',''); ?>
				</li>
				<li><span>【コメント】</span><a href="#comments_wrapper"><?php comments_number('まだない','1件','%件'); ?></a></li>
			</ul>
		</div><!-- .meta ends -->
</div><!-- #header ends-->





<div id="content" class="clearfix">

	<div id="main">

		<div class="entry">
			<?php the_content(); ?>
			<?php if(is_page('links')) wp_list_bookmarks(); ?>
		</div><!-- .entry ends-->

		<div id="breadcrumb">
				<?php if(function_exists('bcn_display')) bcn_display(); ?>
		</div><!-- #breadcrumb ends-->

		<div id="end_meta" class="clearfix">
			<div class="end_meta_box">
				<?php $fumiki->socialbk(get_permalink(),the_title("","",false)."|高橋文樹.com"); ?>
				<div class="adsence">
					<script type="text/javascript"><!--
						google_ad_client = "pub-0087037684083564";
						/* 160x90, 作成済み 09/05/04 */
						google_ad_slot = "9800691688";
						google_ad_width = 160;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
				</div>
			</div>
			<div class="end_meta_box">
				<?php related_posts(); ?>
			</div>
			<div class="end_meta_box">
				<h3 class="mesena"><?php the_title(); ?>の反響</h3>
				<dl class="mesena">
					<dt>コメント</dt>
					<dd>
						現在、コメントは<?php comments_number('0','1','%'); ?>件です。<br />
						<a href="#respond">コメント</a>したり、<a href="<?php echo $fumiki->root; ?>/inquiry/">コンタクト</a>してください。。
					</dd>
					<dt>この記事にリンクしてるブログ</dt>
					<dd>
						すいません、この機能は準備中です...
					</dd>
				</dl>
				<div style="text-align:center">
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
				</div>
			</div>
			<?php fumiki_to_top(); ?>
		</div><!--#end_meta ends-->

		<?php comments_template(); ?>

		<div class="google_banner">
		<script type="text/javascript"><!--
		google_ad_client = "pub-0087037684083564";
		/* 728x90, 作成済み 09/05/05 */
		google_ad_slot = "6603690226";
		google_ad_width = 728;
		google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<iframe frameborder="0" allowtransparency="true" height="90" width="728" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=878276358" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=878276358"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=878276358" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=878276358" height="90" width="728" border="0"></a></noscript></iframe>
		</div><!-- .google_banner ends-->

	</div><!-- #main ends-->


</div><!-- #content ends-->





</div><!-- #wrapper ends -->