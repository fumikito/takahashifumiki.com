<?php
get_header('meta');
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main" class="ebook">
		<?php if(have_posts()): while(have_posts()): the_post(); $counter++;?>
		<div class="ebook-detail clearfix">
			<a href="<?php the_permalink(); ?>"><img class="cover" src="<?php echo get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<?php the_title(); ?>" width="240" height="320" /></a>
			<?php if(lwp_on_sale()): ?>
				<img class="on-sale" src="<?php bloginfo('template_directory'); ?>/img/icon-sale-48.png" width="48" height="48" alt="On Sale" />
			<?php endif; ?>

			<dl>
				<dt>書名</dt>
				<dd class="book-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</dd>
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
		<div class="entry excerpt clrL">
			<?php the_excerpt(); ?>
			<p class="center">
				<a href="<?php the_permalink(); ?>" class="button">電子書籍『<?php the_title(); ?>』の詳細</a>
			</p>
		</div>
		<?php endwhile; endif;?>
		<div id="page_finish" class="mono clrB">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<!-- #page_finish -->

	</div>
	<!-- #main ends -->
	<?php get_sidebar('ebook'); ?>
</div>

<?php
get_footer();