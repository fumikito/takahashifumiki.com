<?php

get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main" class="ebook">
		<?php if(have_posts()): while(have_posts()): the_post(); ?>
		<div class="eyecatch">
			<img src="<?php echo get_post_meta(get_the_ID(), 'eye-catch', true); ?>" alt="<?php the_title(); ?>" width="570" height="300" />
		</div>
		<div class="excerpt entry">
			<h2>あらすじ</h2>
			<?php the_excerpt(); ?>
		</div>
		<div class="ebook-detail clearfix">
			<img class="cover" src="<?php echo get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<?php the_title(); ?>" width="240" height="320" />
			<?php if(lwp_on_sale()): ?>
				<img class="on-sale" src="<?php bloginfo('template_directory'); ?>/img/icon-sale-48.png" width="48" height="48" alt="On Sale" />
			<?php endif; ?>

			<dl>
				<dt>書名</dt>
				<dd class="book-title"><?php the_title(); ?></dd>
				<dt>著者</dt>
				<dd><?php the_author(); ?></dd>
				<dt>価格</dt>
				<dd class="price">
					<?php if(lwp_on_sale() && !lwp_is_owner()): ?>
						<del class="old"><?php echo lwp_currency_symbol().number_format(lwp_original_price())?></del>
						<small class="mono"><?php echo lwp_discout_rate(); ?></small>
						<br />
					<?php endif; ?>
					<span class="old"><?php echo lwp_currency_symbol().number_format(lwp_price()); ?></span>
					<?php if(!lwp_is_owner() && !lwp_is_free()): ?>
						<?php echo lwp_buy_now(null, null); ?>
					<?php endif; ?>
					<?php if(lwp_on_sale() && !lwp_is_owner()): ?>
						<p class="lwp-rest"><?php echo lwp_campaign_end(); ?>までセール中！</p>
						<?php echo lwp_campaign_timer(null, '残り時間:'); ?>
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
			<?php if(!lwp_is_free()): ?>
				<p class="message notice">
					<?php if(is_user_logged_in()): ?>
						この書籍を宣伝しませんか？　以下のURLを使って宣伝すると、<strong><?php the_lwp_reward(); ?></strong>の報酬が入ります。
						<input readonly="readonly" type="text" class="reglar-text promotion-link" value="<?php the_lwp_promotion_link(); ?>" onclick="this.select(); "/>
					<?php else: ?>
						<a href="<?php echo wp_login_url(); ?>">会員登録</a>をすると、この書籍を宣伝して売上の一部<strong><?php the_lwp_reward(); ?></strong>を収益として受け取ることができます。
					<?php endif; ?>
				</p>
			<?php endif; ?>
			<?php if(lwp_is_owner()): ?>
				<p class="message success">お買い上げありがとうございます。「ダウンロード」からファイルをダウンロードして下さい。感想お待ちしています。</p>
			<?php elseif(lwp_is_free(true)): ?>
				<p class="message notice">このコンテンツは無料です。「ダウンロード」からファイルをダウンロードして下さい。感想お待ちしています。</p>
			<?php endif; ?>
			<?php the_content(); ?>
			<div class="clrB">
				<?php link_pages('ページ: '); ?>
			</div>
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
		<?php endwhile; endif; ?>
		<div class="share">
			<h3 class="mono">Share This eBook</h3>
			<p>この電子書籍が気になったら、ぜひシェアしてください。</p>
			<?php fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
		</div>
		<?php comments_template(); ?>
		
		<?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar('電子書籍詳細下');  ?>
	</div>
	<!-- #main ends -->
	
	<?php get_sidebar('ebook'); ?>
</div>

<?php
get_footer();