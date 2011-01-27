<?php global $fumiki; ?>
<div id="right">
	<div class="rectangle">
		<div class="price">
			<h3 class="green sans">
				<span class="old">Price</span>
				販売価格
			</h3>
			<?php if(lwp_is_owner() || lwp_is_free(true)):?>
				<!-- ▼購入済み -->
				<p class="center">
					<span class="real-price old orange">&yen;<?php echo lwp_original_price(); ?></span>
				</p>
				<!-- ▲購入済み -->	
			<?php else: ?>
				<?php if(lwp_on_sale()): ?>
				<!-- ▼セール中 -->
				<img class="onsale" alt="セール中" src="<?php bloginfo('template_directory'); ?>/img/ebook_price_sale.gif" width="48" height="48" />
				<p class="center">
					<del class="old">&yen;<?php echo lwp_original_price(); ?></del>
					→
					<span class="real-price old orange">&yen;<?php echo lwp_price(); ?></span>
				</p>
				<p class="right sans">
					<span class="discount"><span><?php echo ceil((1 - lwp_price() / lwp_original_price()) * 100);?>%</span>OFF!</span>
				</p>
				<p class="limit sans center">
					<strong class="orange"><?php echo lwp_campaign_end(); ?></strong>までセール中！
				</p>
				<!-- #sale-timer starts -->
				<div id="sale-timer" class="right sans">
					<?php $rest = lwp_campaign_end(null, true) - time();?>
					<input type="hidden" name="rest_time" value="<?php echo lwp_campaign_end(null, true); ?>" />
					<small>あと</small>
					<span class="mono"><?php echo sprintf("%02d", floor($rest / 60 / 60)); ?></span><small>時間</small>
					<span class="mono"><?php echo sprintf("%02d", floor($rest % 3600 / 60)); ?></span><small>分</small>
					<span class="mono"><?php echo sprintf("%02d", floor($rest % 60)); ?></span><small>秒</small>
				</div>
				<!-- #sale-timer ends -->
				<!-- ▲セール中 -->		
				<?php else: ?>
				<!-- ▼定価販売 -->
				<p class="center">
					<span class="real-price old orange">&yen;<?php echo lwp_price(); ?></span>
				</p>
				<!-- ▲定価販売 -->				
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<!-- price ends -->
		
		<div class="conversion center">
			<?php if(lwp_is_free()): ?>
					<!-- ▼無料 -->
						<img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_free.jpg" alt="無料コンテンツ" width="200" height="62" />
						<p class="thank-you green">
							無料コンテンツです。
						</p>
					<!-- ▲無料 -->
			<?php elseif(is_user_logged_in()): ?>
				<?php if(lwp_is_owner()): ?>
					<!-- ▼購入済み -->
					<img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_bought.jpg" alt="購入済み" width="278" height="62" />
					<p class="thank-you green">
						ご購入ありがとうございます。
					</p>
					<!-- ▲購入済み -->
				<?php else: ?>
					<!-- ▼未購入 -->
					<?php lwp_buy_now($post, get_bloginfo("template_directory")."/img/ebook_conversion_buy.jpg"); ?>
					<h4 class="left orange sans">決済手段</h4>
					<p class="left sans">
						PayPalを利用したクレジットカード決済を行います。PayPalアカウントは必要ありません。
					</p>
					<p class="right sans">
						<img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_paypal.gif" width="200" height="61" alt="Available via PayPal!" title="Available via PayPal!" /><br />
						PayPalについて<a target="_blank" href="https://www.paypal.com/jp/cgi-bin/webscr?cmd=xpt/Marketing_CommandDriven/homepage/AboutPP-outside&nav=1">もっと詳しく[外部]</a>
					</p>
					<h4 class="left orange sans">対応カード</h4>
					<img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_cc.jpg" width="280" height="35" alt="VISA, Mater Card, JCB, Amex" title="VISA, Mater Card, JCB, Amex" />
					<p class="sans right">
						VISA, Amex, Master Card, JCBに対応しています。
					</p>
					<!-- ▲未購入 -->
				<?php endif; ?>
			<?php else: ?>
				<!-- ▼未ログイン -->
				<p>
					<a href="<?php bloginfo("url"); ?>/login/?action=register"><img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_signup.jpg" alt="新規登録" width="200" height="52" /></a>
				</p>
				<p>または</p>
				<p>
					<a href="<?php bloginfo("url"); ?>/login/?redirect_to=<?php echo rawurlencode($_SERVER['REQUEST_URI']); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/ebook_conversion_login.jpg" alt="ログイン" width="200" height="52" /></a>
				</p>
				<!-- ▲未ログイン -->
			<?php endif; ?>
			
			<?php if(!lwp_is_owner()): ?>
				<!-- ▼購入方法 -->
				<div class="how-to-buy left">
				<?php get_sidebar('faq'); ?>
				</div>
				<!-- ▲購入方法 -->
			<?php endif; ?>
		</div>
		<!-- .conversion ends -->
	</div>
	<!-- .recatngel ends -->
	
	<div class="tweet">
		<?php fumiki_twitter(); ?>
		<?php get_search_form(); ?>
		
	</div>
	
</div><!-- #right ends-->