<?php
	the_post();
	//状態によって切り替え
	if(lwp_is_canceled()){
		register_echo('<img src="'.get_bloginfo('template_directory').'/img/single_header_msg_alert.gif" alt="" width="21" height="20" />購入はキャンセルされました。');
	}elseif(lwp_is_success()){
		register_echo('<img src="'.get_bloginfo('template_directory').'/img/single_header_msg_heart.gif" alt="" width="21" height="20" />ご購入ありがとうございました。電子書籍ファイルをダウンロードしてください。');
	}elseif(lwp_is_transaction_error()){
		register_echo('<img src="'.get_bloginfo('template_directory').'/img/single_header_msg_alert.gif" alt="" width="21" height="20" />決済処理でエラーが発生しました。高橋文樹まで<a href="'.get_bloginfo("url").'"/inquiry">連絡</a>してください。');
	}
	get_header();
?>

<div id="wrapper">


<?php get_header("single"); ?>


<div id="content" class="clearfix ebook">

	<div id="main">
		<div class="meta ebook-meta">
			<h1 class="center"><img src="<?php echo get_post_meta( $post->ID, "eye-catch", true); ?>" alt="<?php the_title(); ?>" width="540" height="300" /></h1>
			<p class="right clrB">
				<?php $fumiki->hatena_add("", "", "", "はてブ"); ?>
				<?php $fumiki->mixi_check(false); ?>
				<?php $fumiki->gree_like(); ?>
				<?php $fumiki->tweet_this(); ?>
				<?php $fumiki->facebook_like("", 120, 21, "button_count"); ?>
			</p>
		</div><!-- .meta ends -->

		<div class="entry">
			<!-- ▼ebook-detail -->
			<div class="ebook-detail clearfix">
				<img class="cover" alt="<?php the_title(); ?>" src="<?php echo get_post_meta($post->ID, "cover", true); ?>" width="240" height="320" />
				<dl>
					<dt class="sans">書名</dt>
					<dd class="mincho"><?php the_title(); ?></dd>
					<dt class="sans">分量</dt>
					<dd class="mincho"><small>四〇〇字詰め原稿用紙</small><span class="old"><?php echo lwp_ammount();?></span><small>枚</small></dd>
					<dt class="sans">ISBN</dt>
					<dd class="old"><?php echo lwp_isbn();?></dd>
					<dt class="sans">販売開始日</dt>
					<dd class="old"><?php the_date();?></dd>
				</dl>
			</div>
			<!-- ▲ebook-detail -->
			
			<h2>あらすじ</h2>
			<?php the_excerpt(); ?>
			<?php edit_post_link("［編集］","<p class=\"right\"><small>","</small></p>");?>
			
			<?php the_content(); ?>
			
			<h3 class="clrB">対応端末一覧</h3>
			<div class="device-list clearfix">
				<?php $devices = lwp_get_devices(); ?>
				<?php foreach($devices as $d): ?>
				<div class="device<?php echo ($d["valid"]) ? ' valid' : ' invalid';?>">
					<small class="center sans"><?php echo $d["valid"] ? "確認済" : "未確認"; ?></small>
					<img src="<?php bloginfo('template_directory'); ?>/img/ebook_devices/<?php echo $d["slug"]; ?>.png" alt="<?php echo $d["name"]; ?>" width="48" height="48"/>
					<span class="sans center"><?php echo $d["name"]; ?></span>
				</div>
				<!-- .device ends -->
				<?php endforeach; ?>
				<p class="clrB sans">
					ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
					端末追加のご要望については<a href="<?php bloginfo('url'); ?>/inquiry">お問い合わせ</a>よりご連絡ください。
				</p>
			</div>
			<!-- .device-list -->
			
			<p class="right desc">
				<a href="<?php bloginfo('url'); ?>/ebooks/devices">端末ごとの読み方</a>
			</p>

			
			<h3>ファイルのダウンロード</h3>
			<?php
				$files = lwp_get_files();
				$coutner = 0;
			?>
			<table class="file-list sans">
				<tbody>
				<?php foreach($files as $f): $counter++;?>
					<tr class="<?php echo ($counter % 2 == 0) ? 'even' : 'odd';?>">
						<td class="center">
							<?php $ext = lwp_get_ext($f); ?>
							<img src="<?php bloginfo('template_directory'); ?>/img/ebook_filetype/<?php echo $ext; ?>.png" alt="<?php echo $ext; ?>" width="75" height="75" /><br />
							<em class="old"><?php echo strtoupper($ext); ?></em>
						</td>
						<td>
							<div class="file-meta">
								<strong class="title "><?php echo $f->name; ?></strong>
								<small>（<?php lwp_get_date($f); ?>）</small>
							</div>
							<div class="desc">
								<?php echo wpautop($f->desc); ?>
								<small>対応端末：<?php echo implode(', ', lwp_get_file_devices($f)); ?></small>
							</div>
						</td>
						<td class="width150 center">
							<?php
								$accessibility = lwp_get_accessibility($f);
								if(
									($accessibility == "owner" && lwp_is_owner() ) //購入者限定でかつ所有権がある
									||
									($accessibility == "member" && is_user_logged_in()) //メンバーならダウンロードできるファイル
									||
									($accessibility == "any") // 誰でもダウンロードできるファイル
								):
							?>
								<a class="download clearfix" href="<?php echo lwp_file_link($f->ID); ?>"  title="<?php echo $f->name; ?>をダウンロード">
									<img src="<?php bloginfo('template_directory'); ?>/img/ebook_btn_dlactive.gif" alt="ダウンロード" width="88" height="21" />
									<small class="mono middle"><?php echo lwp_get_size($f); ?></small>
								</a>
								<small class="desc">クリックしてダウンロード</small>
							<?php else: ?>
								<span class="download clearfix" title="ダウンロードできません">
									<img src="<?php bloginfo('template_directory'); ?>/img/ebook_btn_dldeact.gif" alt="ダウンロード不可" width="88" height="21" />
									<small class="mono middle"><?php echo lwp_get_size($f); ?></small>
								</span>
								<small class="desc">
									<?php
										switch($accessibility){
											case "owner":
												echo "購入後ダウンロード可能";
												break;
											case "member":
												echo "会員のみダウンロード可能";
												break;
											default:
												echo "ダウンロードできません";
												break;
										}
									?>
								</small>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="right desc">
				<a href="<?php bloginfo('url'); ?>/ebooks/devices">ダウンロードして読む方法</a>
			</p>
			
		</div><!-- .entry ends-->

		
		<div id="page_finish" class="clrB">
			<a href="#toTop"><span class="sans">▲購入する</span></a>
		</div>
		<!-- #page_finish ends -->

		<?php comments_template(); ?>

	</div><!-- #main ends-->

	<?php get_sidebar("ebook");?>

</div><!-- #content ends-->


</div><!-- #wrapper ends -->
<?php
get_footer();