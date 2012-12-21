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
<div id="content" class="container clearfix">
	<div id="main"<? if(get_post_type() == 'ebook') echo ' class="ebook"';?>>
		<? $eye_catch = get_post_meta(get_the_ID(), 'eye-catch', true); if($eye_catch):?>
		<div class="eyecatch">
			<img src="<? echo $eye_catch; ?>" alt="<? the_title(); ?>" width="570" height="300" />
		</div>
		<? endif; ?>
		<article class="entry clearfix">
			<? the_content(); ?>
			<? wp_link_pages(array(
				'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
				'after' => '</div>'
			)); ?>
			
			<? if(!lwp_is_free(true)):  ?>
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
			<? endif; ?>
				
			<? if(lwp_has_files()): ?> 
				<h2>対応端末</h2>
				<? $devices = lwp_get_devices(); ?>
				<div class="device-list clearfix">
					<? foreach($devices as $d): ?>
						<div class="device<? echo ($d["valid"]) ? ' valid' : ' invalid';?>">
							<small class="center sans"><?= $d["valid"] ? "確認済" : "未確認"; ?></small>
							<img src="<?= get_template_directory_uri(); ?>/styles/img/ebook-devices/<? echo $d["slug"]; ?>.png" alt="<? echo $d["name"]; ?>" width="48" height="48"/>
							<span class="sans center"><?= $d["name"]; ?></span>
						</div>
						<!-- .device ends -->
					<? endforeach; ?>
					<p class="clrB sans">
						ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
						端末追加のご要望については<a href="<? home_url('/inquiry', 'https'); ?>">お問い合わせ</a>よりご連絡ください。
					</p>
				</div>
				<h2 id="download-list">ダウンロード</h2>
				<?	get_template_part('templates/table-downloadables'); ?>
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
						<? lwp_list_tickets('callback=_fumiki_tickets'); ?>
					</tbody>
				</table>
			<? endif; ?>
			
			<div class="next-previous clearfix clrB">
				<p class="prev">
					<? previous_post_link('%link', '<i class="icon-circle-arrow-left"></i>%title');?>
				</p>
				<p class="next">
					<? next_post_link('%link', '<i class="icon-circle-arrow-right"></i>%title'); ?>
				</p>
			</div>	
		</article><!-- //.entry -->
		
		<div class="margin google-share clearfix">
			<div class="div_3 share">
				<? fumiki_share(get_the_title()." | ".get_bloginfo('name'), get_permalink()); ?>
			</div>
			<div class="div_3 ad"><? google_ads(4);?></div>
			<? if(!is_smartphone()): ?>
			<div class="div_3 ad_pc"><? google_ads(4);?></div>
			<? endif; ?>
		</div><!-- //.google-share -->
		
		<div id="respond"><? comments_template(); ?></div>
		
		<div class="margin">
			<? get_sidebar(); ?>
		</div>
	</div>
	<!-- #main ends -->

</div><!-- //.margin -->

<?
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了