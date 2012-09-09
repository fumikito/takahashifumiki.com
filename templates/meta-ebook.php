<table>
	<tbody>
		<tr>
			<th>書名</th>
			<td class="book-title"><?php the_title(); ?></td>
		</tr>
		<tr>
			<th>著者</th>
			<td><?php the_author(); ?></td>
		</tr>
		<tr>
			<th>価格</th>
			<td class="price">
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
			</td>
		</tr>
		<tr>
			<th>分量</th>
			<td>400字詰め原稿用紙<?php echo intval(get_post_meta(get_the_ID(), 'lwp_number', true)); ?>枚分</td>
		</tr>
		<tr>
			<th>ISBN</th>
			<td class="mono"><?php echo ($isbn = get_post_meta(get_the_ID(), 'lwp_isbn', true)) ? $isbn : 'なし'; ?></td>
		</tr>
		<tr>
			<th>公開日</th>
			<td class="mono"><?php the_date('Y.m.d'); ?></td>
		</tr>
		<? if(is_singular()): ?>
		<tr>
			<th>ダウンロード</th>
			<td>
				<? if(lwp_is_owner()): ?>
					<p class="message success">お買い上げありがとうございます。<a href="#download-list">ダウンロード</a>からファイルをダウンロードして下さい。感想お待ちしています。</p>
				<? elseif(lwp_is_free(true)): ?>
					このコンテンツは無料です。<a href="#download-list">ダウンロード</a>からファイルをダウンロードして下さい。感想お待ちしています。
				<? else: ?>
					購入後、<a href="#download-list">ダウンロード</a>リストにあるものをいつでも入手できます。
				<? endif; ?>
			</td>
		</tr>
		<? if(!lwp_is_free()): ?>
		<tr>
			<th>宣伝URL</th>
			<td>
				<? if(is_user_logged_in()): ?>
					以下のURLを使って宣伝すると、<strong><?php the_lwp_reward(); ?></strong>の報酬が入ります。
					<input readonly="readonly" type="text" class="reglar-text promotion-link" value="<?php the_lwp_promotion_link(); ?>" onclick="this.select(); "/>
				<? else: ?>
					<a href="<?php echo wp_login_url(); ?>">会員登録</a>をすると、この書籍を宣伝して売上の一部<strong><?php the_lwp_reward(); ?></strong>を収益として受け取ることができます。
				<? endif; ?>
			</td>
		</tr>
		<? endif; ?>
		<? endif; ?>
	</tbody>
</table>			
