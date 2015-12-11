<table id="meta-ebook">
	<tbody>
		<tr>
			<th><i class="fa-book"></i>書名</th>
			<td class="book-title"><?php the_title(); ?></td>
		</tr>
		<tr>
			<th><i class="fa-user"></i>著者</th>
			<td class="book-author"><?php the_author(); ?></td>
		</tr>
		<tr>
			<th><i class="fa-money"></i>価格</th>
			<td class="price">
				<?php if(lwp_on_sale() && !lwp_is_owner()) :  ?>
					<small class="mono"><?= lwp_discout_rate(); ?></small>
					<br />
				<?php endif; ?>
				<span class="old"><del><?= lwp_currency_symbol().number_format(lwp_price()); ?></del></span>
				<?php if(!lwp_is_owner() && !lwp_is_free(true) && 'ebook' != get_post_type()) :  ?>
					<?= lwp_buy_now(null, null); ?>
				<?php endif; ?>
				<?php if(lwp_on_sale() && !lwp_is_owner()) :  ?>
					<p class="lwp-rest"><?= lwp_campaign_end(); ?>までセール中！</p>
					<?= lwp_campaign_timer(null, '残り時間:'); ?>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><i class="fa-inbox"></i>分量</th>
			<td>400字詰め原稿用紙<?= intval(get_post_meta(get_the_ID(), 'lwp_number', true)); ?>枚分</td>
		</tr>
		<tr>
			<th><i class="fa-qrcode"></i>ISBN</th>
			<td class="mono"><?= ($isbn = get_post_meta(get_the_ID(), 'lwp_isbn', true)) ? $isbn : 'なし'; ?></td>
		</tr>
		<tr>
			<th><i class="fa-calendar"></i>公開日</th>
			<td class="mono"><?php the_date('Y.m.d'); ?></td>
		</tr>
		<?php if(is_singular()) :  ?>
		<tr>
			<th><i class="fa-download"></i>ダウンロード</th>
			<td>
				<?php if(lwp_is_owner()) :  ?>
					<p class="message success">お買い上げありがとうございます。<a href="#download-list">ダウンロード</a>からファイルをダウンロードして下さい。感想お待ちしています。</p>
				<?php elseif(lwp_is_free(true)) :  ?>
					このコンテンツは無料です。<a href="#download-list">ダウンロード</a>からファイルをダウンロードして下さい。感想お待ちしています。
				<?php else :  ?>
					購入後、<a href="#download-list">ダウンロード</a>リストにあるものをいつでも入手できます。
				<?php endif; ?>
			</td>
		</tr>
		<?php if(!lwp_is_free()) :  ?>
		<tr>
			<th><i class="fa-thumbs-up"></i>宣伝URL</th>
			<td>
				<?php if(is_user_logged_in()) :  ?>
					以下のURLを使って宣伝すると、<strong><?php the_lwp_reward(); ?></strong>の報酬が入ります。
					<input readonly="readonly" type="text" class="reglar-text promotion-link" value="<?php the_lwp_promotion_link(); ?>" onclick="this.select(); "/>
				<?php else :  ?>
					<a href="<?= wp_login_url(); ?>">会員登録</a>をすると、この書籍を宣伝して売上の一部<strong><?php the_lwp_reward(); ?></strong>を収益として受け取ることができます。
				<?php endif; ?>
			</td>
		</tr>
		<?php endif; ?>
		<?php endif; ?>
	</tbody>
</table>			
