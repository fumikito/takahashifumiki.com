<?
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)):
	include_once(TEMPLATEPATH."/mootools/moo.php");
else:
/****************************
 * 通常
 ****************************/

get_header('meta');
?>
<?
the_post();
get_header('navi');
get_header('title');
?>
<? if(is_smartphone()) google_ads(5); ?>
<div id="content" class="margin clearfix">
	<div id="main">
		<div class="entry clearfix">
			<? the_content(); ?>
			<? wp_link_pages(array(
				'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
				'after' => '</div>'
				
			)); ?>
			<? if(!lwp_is_free(true)): ?>
				<div class="ebook">
					<? if(lwp_is_owner()): ?>
						<p class="message success">
							お買い上げありがとうございます!
							<? if(lwp_has_files()): ?>
								<a href="#download-contents">ダウンロードリスト</a>からファイルをダウンロードしてください。
							<? endif; ?>
						</p>
					<? else: ?>
						<p class="message notice">
							この投稿は<strong><? lwp_the_price();?></strong>で販売しています。
							<? if(lwp_has_files()): ?>
							購入すると<a href="#download-contents">ダウンロードリスト</a>のファイルをダウンロードできるようになります。
							<? endif; ?>
						</p>
						<p class="center"><? echo lwp_buy_now(null, null); ?></p>
					<? endif; ?>
					<? get_template_part('templates/table-downloadables'); ?>
				</div>
			<? endif; ?>
			<? if(lwp_has_ticket()): ?>
				<h2><? the_title(); ?>のチケット</h2>
				<table id="ticket-list" class="form-table">
					<thead>
						<tr>
							<th scope="col">名称</th>
							<th scope="col">価格</th>
							<th scope="col">在庫</th>
							<th scope="col">詳細</th>
							<th scope="col">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?
							/**
								* 
								* @global Literally_WordPress $lwp
								* @param int $id 
								*/
							function _fumiki_tickets($parent_id){
								global $lwp;
								?>
						<tr>
							<th scope="row"><? the_title(); ?></td>
							<td><? lwp_the_price();?></td>
							<td>
								<? lwp_the_ticket_stock(); ?>
							</td>
							<td><? the_content(); ?></td>
							<td>
								<? if(lwp_get_ticket_stock() <= 0): ?>
									売り切れ
								<? elseif(time() >= lwp_selling_limit('U', $parent_id)): ?>
									募集終了
								<? else: ?>
									<a class="lwp-buynow" href="<? echo esc_url(lwp_buy_url());?>">注文</a>
								<? endif; ?>
							</td>
						</tr>
								<?
							}
							lwp_list_tickets('callback=_fumiki_tickets');
						?>
					</tbody>
				</table>
			<? endif; ?>
				
			<? get_template_part('templates/single-share'); ?>
			
			<? if(is_smartphone()): ?>
				
			<? else: ?>
				<div class="google clearfix">
					<div class="left"><? google_ads(4);?></div>
					<div class="right"><? google_ads(4);?></div>
				</div>
			<? endif ?>
		</div><!-- //.entry -->
		
		
		<div id="respond"><? comments_template(); ?></div>
		<? get_template_part('templates/related-posts'); ?>
		<? get_sidebar();?>
	</div>
	<!-- #main ends -->

</div>

<?
if(is_smartphone()){
	google_ads(5);
}
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了