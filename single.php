<?php
the_post();
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)):
	include_once(TEMPLATEPATH."/mootools/moo.php");
else:
	include_once(TEMPLATEPATH."/header.php");

/****************************
 * 縦書のときだけテンプレ変更
 ****************************/
if(is_tategaki()):
	include_once(TEMPLATEPATH.'/single-tate.php');
else:
?>

<div id="wrapper">



<div id="header">
<a id="logo" rel="home" href="<?php echo $fumiki->root; ?>"><?php echo $fumiki->blogTitle; ?></a>
<div id="breadcrumb">
<?php if(function_exists('bcn_display')) bcn_display(); ?>
</div>
<a id="toTop"></a>
</div><!-- #header ends-->





<div id="content" class="clearfix">




	<div id="main">
		<div class="meta">
			<h1 class="mincho"><span><?php the_title(); ?></span></h1>
			<div class="calendar old">
					<?php
						ob_start();
						the_date('Y n j D g:iA');
						$buf = ob_get_contents();
						ob_end_clean();
						$fumiki->dateformat($buf);
					?>
			</div>
			<?php if(!is_page()): ?>
			<ul>
				<li>
					<span>【カテゴリ】</span><?php the_category(', '); ?>
				</li>
				<li>
					<?php the_tags('<span>【タグ】</span>',', ',''); ?>
				</li>
				<li><span>【コメント】</span><a href="#comments_wrapper"><?php comments_number('まだない','1件','%件'); ?></a></li>
			</ul>
			<?php else: ?>
				<br class="clrB" />
			<?php endif; ?>
		</div><!-- .meta ends -->

		<div class="entry<?php if($post->post_password) echo ' blocked'; ?>">
			<?php the_content(); ?>
		</div><!-- .entry ends-->

		<?php
			if($multipage) wp_link_pages('before=<div class="page_navi old"><span class="mincho">続き</span>&after=</div>');
			else echo '<div id="page_finish"><span class="mincho">終わり</span></div>';
		?>

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
			</div>
			<?php fumiki_to_top(); ?>
		</div><!--#end_meta ends-->

		<?php if(!is_page()) comments_template(); ?>

	</div><!-- #main ends-->




	<div id="right">
		<div class="tweet clearfix">
			<p>
				<img src="<?php echo $fumiki->template; ?>/img/single_loader.gif" alt="読み込み中..."  />
			</p>
			<span>
				<a class="about" href="<?php echo $fumiki->root; ?>/about/">高橋文樹とは</a>
				<a class="tweet" href="http://twitter.com/takahashifumiki" title="高橋文樹はTwitterを使っています">高橋文樹はTwitterを使っています</a>
			</span>
		</div><!-- .tweet ends-->


		<ul id="column1">
			<li class="book_ad">
				<h3>最新書籍</h3>
				<a href="<?php echo $fumiki_book['url'];?>" title="<?php echo $fumiki_book['name'];?>"><img alt="<?php echo $fumiki_book['name']; ?>" src="<?php echo $fumiki->template.'/img/'.$fumiki_book['img']; ?>" /></a>
				<div>
					<strong>【<?php echo $fumiki_book['name']; ?>】</strong><br />
					<?php echo $fumiki_book['desc'];?>
				</div>
			</li>
			<li class="newpost">
				<h3>新着記事</h3>
				<?php $fumiki->newpost(); ?>
			</li>
			<li class="catnav">
				<h3>カテゴリー</h3>
				<ul>
					<li><a href="<?php echo $fumiki->root;?>/topics/announcement/">告知</a></li>
					<li><a href="<?php echo $fumiki->root;?>/topics/literature/">文芸活動</a></li>
					<li><a href="<?php echo $fumiki->root;?>/topics/web/">Web制作</a></li>
					<li><a href="<?php echo $fumiki->root;?>/topics/others/">その他雑文</a></li>
				</ul>
			</li>
			<li class="comment">
				<h3>最新コメント</h3>
				<ul>
					<?php $fumiki->comments(); ?>
				</ul>
			</li>
			<li class="tags">
				<h3>タグ</h3>
				<ul><li><?php st_tag_cloud('cloud_sort=random&cloud_selection=random&title=&smallest=8&largest=18&maxcolor=#444444&mincolor=#AAAAAA'); ?></li></ul>
			</li>
		</ul><!-- #column1 ends-->


		<ul id="column2">
			<li>
				<ul class="banner">
					<?php $fumiki->banner(); ?>
				</ul><!-- banner ends-->
			</li>
			<li class="insight">
				<iframe frameborder="0" allowtransparency="true" height="600" width="120" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=878276315" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=878276315"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=878276315" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=878276315" height="600" width="120" border="0"></a></noscript></iframe>
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
<a href="http://awasete.com/show.phtml?u=http%3A%2F%2Ftakahashifumiki.com%2F"><img src="http://img.awasete.com/image.phtml?u=http%3A%2F%2Ftakahashifumiki.com%2F&s=1" width="125" height="125" alt="あわせて読みたいブログパーツ" border="0"></a>
			</li>
			<li class="insight">
<iframe frameborder="0" allowtransparency="true" height="600" width="120" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=2574999&pid=878994330" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=2574999&pid=878994330"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=2574999&pid=878994330" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=2574999&pid=878994330" height="600" width="120" border="0"></a></noscript></iframe>
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

		</ul><!-- #column2 ends-->
	</div><!-- #right ends-->





</div><!-- #content ends-->





</div><!-- #wrapper ends -->
<?php
endif;//縦書との分岐終了(ref:l.14)
	require_once(TEMPLATEPATH."/footer.php");

endif;//Mootoolsと通常single.phpの分岐終了(ref:l.4)
?>