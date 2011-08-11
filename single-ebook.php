<?php
the_post();

get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main" class="ebook">
		<div class="eyecatch">
			<img src="<?php echo get_post_meta(get_the_ID(), 'eye-catch', true); ?>" alt="<?php the_title(); ?>" width="570" height="300" />
		</div>
		<div class="excerpt entry">
			<h2>あらすじ</h2>
			<?php the_excerpt(); ?>
		</div>
		<div class="ebook-detail clearfix">
			<img class="cover" src="<?php echo get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<?php the_title(); ?>" width="240" height="320" />
			<dl>
				<dt>書名</dt>
				<dd class="book-title"><?php the_title(); ?></dd>
				<dt>著者</dt>
				<dd><?php the_author(); ?></dd>
				<dt>価格</dt>
				<dd class="price mono">
					<?php if(lwp_on_sale()): ?>
						<?php echo lwp_currency_symbol().number_format(lwp_price());?><br />
						<del><?php echo lwp_currency_symbol().number_format(lwp_original_price())?></del>
						<small class="mono"><?php echo lwp_discout_rate(); ?>% OFf</small>
					<?php else: ?>
						<?php echo lwp_currency_symbol().number_format(lwp_price()); ?>
					<?php endif; ?>
				</dd>
				<dt>分量</dt>
				<dd>400字詰め原稿用紙<?php echo intval(get_post_meta(get_the_ID(), 'lwp_number', true)); ?>枚分</dd>
				<dt>ISBN</dt>
				<dd class="mono"><?php echo ($isbn = get_post_meta(get_the_ID(), 'lwp_isbn', true)) ? $isbn : 'なし'; ?></dd>
				<dt>公開日</dt>
				<dd class="mono"><?php the_date('Y.m.d'); ?></dd>
			</dl>
		</div>
		<div class="entry clearfix">
			<?php the_content(); ?>
			<div class="clrB">
				<?php link_pages('ページ: '); ?>
			</div>
		</div>
		<div class="share">
			<h3 class="mono">Share This eBook</h3>
			<p>この電子書籍が気になったら、ぜひシェアしてください。</p>
			<?php fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
		</div>
		<div class="entry clearfix">
			<h2>対応端末</h2>
			<?php $devices = lwp_get_devices(); ?>
			<div class="device-list clearfix">
				<?php foreach($devices as $d): ?>
					<div class="device<?php echo ($d["valid"]) ? ' valid' : ' invalid';?>">
						<small class="center sans"><?php echo $d["valid"] ? "確認済" : "未確認"; ?></small>
						<img src="<?php bloginfo('template_directory'); ?>/img/ebook-devices/<?php echo $d["slug"]; ?>.png" alt="<?php echo $d["name"]; ?>" width="48" height="48"/>
						<span class="sans center"><?php echo $d["name"]; ?></span>
					</div>
					<!-- .device ends -->
				<?php endforeach; ?>
				<p class="clrB sans">
					ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
					端末追加のご要望については<a href="<?php bloginfo('url'); ?>/inquiry">お問い合わせ</a>よりご連絡ください。
				</p>
			</div>
			<h2>ダウンロード</h2>
			<table class="file-list">
			<?php $files = lwp_get_files();?>
				<tbody>
					<?php foreach($files as $f): $counter++;?>
					<tr class="<?php echo ($counter % 2 == 0) ? 'even' : 'odd';?>">
						<td class="center">
							<?php $ext = lwp_get_ext($f); ?>
							<img src="<?php bloginfo('template_directory'); ?>/img/ebook-filetypes/<?php echo $ext; ?>.png" alt="<?php echo $ext; ?>" width="75" height="75" /><br />
							<em class="mono"><?php echo strtoupper($ext); ?></em>
						</td>
						<td>
							<div class="file-meta">
								<strong class="file-title "><?php echo $f->name; ?></strong>
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
									<img src="<?php bloginfo('template_directory'); ?>/img/ebook-devices/btn_dlactive.gif" alt="ダウンロード" width="88" height="21" />
									<small class="mono middle"><?php echo lwp_get_size($f); ?></small>
								</a>
								<small class="desc">クリックしてダウンロード</small>
							<?php else: ?>
								<span class="download clearfix" title="ダウンロードできません">
									<img src="<?php bloginfo('template_directory'); ?>/img/ebook-devices/btn_dldeact.gif" alt="ダウンロード不可" width="88" height="21" />
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
		</div>
		<?php comments_template(); ?>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar('ebook'); ?>
</div>

<?php
get_footer();