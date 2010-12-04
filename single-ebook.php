<?php
	the_post();
	//状態によって切り替え
	if(lwp_is_canceled()){
		register_echo("購入はキャンセルされました。");
	}elseif(lwp_is_success()){
		register_echo("ご購入ありがとうございました。<br />電子書籍ファイルをダウンロードしてください。");
	}elseif(lwp_is_transaction_error()){
		register_echo("決済処理でエラーが発生しました。<br />高橋文樹まで<a href=\"".get_bloginfo("url")."/inquiry\">連絡</a>してください。");
	}
	get_header();
?>

<div id="wrapper">


<?php get_header("single"); ?>


<div id="content" class="clearfix ebook">

	<div id="main">
		<div class="meta">
			<h1 class="mincho"><span><small>電子書籍</small><br /><?php the_title(); ?></span></h1>
			<div class="calendar old">
					<?php
						ob_start();
						the_date('Y n j D g:iA');
						$buf = ob_get_contents();
						ob_end_clean();
						$fumiki->dateformat($buf);
					?>
			</div>
			<!-- .calendar ends -->
			<p class="right clrB">
				<?php $fumiki->hatena_add("", "", "", "はてブ"); ?>
				<?php $fumiki->mixi_check(false); ?>
				<?php $fumiki->gree_like(); ?>
				<?php $fumiki->tweet_this(); ?>
				<?php $fumiki->facebook_like("", 120, 21, "button_count"); ?>
			</p>
		</div><!-- .meta ends -->

		<div class="entry">
			<?php the_content(); ?>
			<p class="ebook-price center">
				<?php if(lwp_is_owner()): ?>
					<span class="real-price">ご購入ありがとうございます。</span>
				<?php elseif(lwp_on_sale()): ?>
					<del class="old">&yen;<?php echo lwp_original_price(); ?></del>
					→
					<span class="real-price old">&yen;<?php echo lwp_price(); ?></span>
					<br />
					<small>
						<?php echo lwp_campaign_end(); ?>までセール中！
						（あと<strong><?php echo round((lwp_campaign_end(null, true) - time()) / 60 / 60 / 24); ?>日</strong>）
					</small>
				<?php else: ?>
					<span class="real-price old">&yen;<?php echo lwp_price(); ?></span>
				<?php endif; ?>
			</p>
			
			<?php if(!lwp_is_owner()): ?>
				<?php if(is_user_logged_in()): ?>
			<div class="center">
				<?php lwp_buy_now($post, get_bloginfo("template_directory")."/img/btn_buynow.jpg"); ?>
			</div>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php
				$free_files = lwp_get_files(true);
				$files = lwp_get_files();
			?>
			<h3>ファイルのダウンロード</h3>
			<dl class="file-list">
				<?php foreach($files as $f): ?>
				<dt><?php echo $f->name; ?></dt>
				<dd class="clearfix">
					<?php if(lwp_is_owner()): ?>
					<a class="download" href="<?php echo lwp_file_link($f->ID); ?>"  title="<?php echo $f->name; ?>をダウンロード">
						<img src="<?php bloginfo("template_directory"); ?>/img/btn_dl_active.gif" width="100" hegith="100" alt="<?php echo $f->name; ?>をダウンロード"/>
					</a>
					<?php else: ?>
					<img class="download" src="<?php bloginfo("template_directory"); ?>/img/btn_dl_inactive.gif" width="100" hegith="100" alt="購入して<?php echo $f->name; ?>をダウンロード"  title="購入して<?php echo $f->name; ?>をダウンロード"/>
					<?php endif; ?>
					<?php echo wpautop($f->desc); ?>
				</dd>
				<?php endforeach; ?>
				<?php foreach($free_files as $f): ?>
				<dt><?php echo $f->name; ?></dt>
				<dd class="clearfix">
					<a class="download" href="<?php echo lwp_file_link($f->ID); ?>"  title="<?php echo $f->name; ?>をダウンロード">
						<img src="<?php bloginfo("template_directory"); ?>/img/btn_dl_active.gif" width="100" hegith="100" alt="<?php echo $f->name; ?>をダウンロード"/>
					</a>
					<?php echo wpautop($f->desc); ?>
				</dd>
				<?php endforeach; ?>
			</dl>
			<?php if(!lwp_is_owner()): ?>
				<?php if(is_user_logged_in()): ?>
			<div class="center">
				<?php lwp_buy_now($post, get_bloginfo("template_directory")."/img/btn_buynow.jpg"); ?>
			</div>
				<?php endif; ?>
			<?php endif; ?>
			<h3>購入方法</h3>
			<p>
				高橋文樹.comでは、決済にPayPalを利用しています。各種クレジットカードとPayPalアカウントを利用して買い物をすることができます。<br />
				一度PayPalのサイトに移動して決済を完了すると、電子書籍ファイルをダウンロードできるようになります。<br />
				【参考リンク】
				<a target="_blank" href="https://www.paypal.com/jp/cgi-bin/webscr?cmd=xpt/Marketing_CommandDriven/homepage/AboutPP-outside&nav=1">PayPalについてもっと詳しく<small>（外部）</small></a>
				, <a href="<?php bloginfo("url"); ?>/ebooks/flow/">購入から利用までの流れ</a>
			</p>
			<?php if(!is_user_logged_in()): ?>
			<h3>会員登録のお願い</h3>
			<p>
				高橋文樹.comで販売している電子書籍を購入するには、<a href="<?php bloginfo("url"); ?>/wp-register.php">会員登録</a>が必要です。<br />
				すでに登録済みの方は<a href="<?php bloginfo("url"); ?>/wp-login.php?redirect_to=<?php echo rawurlencode(get_permalink()); ?>">ログイン</a>してください。
			</p>
			<?php endif; ?>
		</div><!-- .entry ends-->

		
		<div id="page_finish" class="clrB"><a href="<?php bloginfo("url"); ?>/ebooks/"><span class="mincho">高橋文樹の電子書籍一覧へ&raquo;</span></a></div>

		<div id="end_meta" class="clearfix">
			<div class="end_meta_box">
				<?php
					$random = rand(0, 2);
					$sort = ($random >= 1) ? "hot" : "count";
					$title = ($random >= 1) ? "新着" : "人気";
				?>
				<script language="javascript" type="text/javascript" src="http://b.hatena.ne.jp/js/widget.js" charset="utf-8"></script>
				<script language="javascript" type="text/javascript">
				Hatena.BookmarkWidget.url   = "http://takahashifumiki.com";
				Hatena.BookmarkWidget.title = "はてなブックマーク<?php echo $title; ?>";
				Hatena.BookmarkWidget.sort  = "<?php echo $sort; ?>";
				Hatena.BookmarkWidget.width = 0;
				Hatena.BookmarkWidget.num   = 5;
				Hatena.BookmarkWidget.theme = "default";
				Hatena.BookmarkWidget.load();
				</script>
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
					<dt>ソーシャルメディア</dt>
					<dd class="center">
						<?php $fumiki->hatena_add("", "", "", "このエントリーをはてブする"); ?><br /><br />
						<?php $fumiki->mixi_check(); ?>
						<?php $fumiki->gree_like(); ?>
						<?php $fumiki->tweet_this(); ?><br /><br />
						<?php $fumiki->facebook_like("", 200, 80); ?>
					</dd>
				</dl>
			</div>
			<?php fumiki_to_top(); ?>
		</div>
		<!--#end_meta ends-->

		<?php comments_template(); ?>

	</div><!-- #main ends-->

	<?php get_sidebar();?>

</div><!-- #content ends-->


</div><!-- #wrapper ends -->
<?php
get_footer();