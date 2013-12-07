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

the_post();
get_header('navi');
get_header('title');
?>
<div id="content" class="margin clearfix">
	<div id="main" class="<?= get_post_type(); ?>">

		<? if(has_post_thumbnail()):?>
			<div class="eyecatch">
				<? the_post_thumbnail('large'); ?>
			</div>
		<? endif; ?>

		<? if( !empty($post->post_excerpt) ): ?>
			<div class="post-excerpt">
				<? the_excerpt(); ?>
			</div>
		<? endif; ?>

		<!-- ebook -->
		<? if('ebook' == get_post_type()): ?>
			<div class="ebook-meta clearfix">
				<div class="img-container">
					<img class="cover" src="<?= get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<? the_title(); ?>" width="240" height="320" />
					<? if(lwp_on_sale()): ?>
						<div class="on-sale old">
							<i class="fa-start"></i>
							Sale
						</div>
					<? endif; ?>
				</div><!-- .img-container -->
				<? get_template_part('templates/meta', 'ebook'); ?>
			</div>
		<? endif; ?>


		<? if(is_singular('post') && is_expired_post()): ?>
			<p id="outdated-post" class="message warning">
				この投稿は<?= get_outdate_string(); ?>の記事です。情報が<a href="#">古く</a>なっている可能性があるので、その点ご了承ください。
			</p>
		<? endif; ?>
		<article class="entry clearfix">
			<? the_content(); ?>
		</article><!-- //.entry -->

		<!-- // pagination -->
		<? wp_link_pages(array(
			'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
			'after' => '</div>'
		)); ?>

		<div id="contents-last">&nbsp;</div>

		<!-- // Buy message -->
		<? if(!lwp_is_free(true)):  ?>
			<div class="lwp-message lwp-container">
				<? if(lwp_is_owner()): ?>
					<p class="message success">
						お買い上げありがとうございます!
						<? if(lwp_has_files()): ?>
							<a href="#download-contents">ダウンロードリスト</a>からファイルをダウンロードしてください。
						<? endif; ?>
					</p>
				<? else: ?>
					<p class="message notice">
						この<?= get_post_type_object(get_post_type())->labels->name; ?>は<strong><? lwp_the_price();?></strong>で販売しています。
						<? if(lwp_has_files()): ?>
							購入すると<a href="#download-contents">ダウンロードリスト</a>のファイルをダウンロードできるようになります。
						<? endif; ?>
					</p>
					<p class="center"><? echo lwp_buy_now(null, null); ?></p>
				<? endif; ?>
			</div>
		<? endif; ?>


		<!-- // file lists -->
		<? if(lwp_has_files()): ?>
			<div class="lwp-file-list lwp-container">
				<h2><i class="fa-laptop"></i> 対応端末</h2>
				<? $devices = lwp_get_devices(); ?>
				<div class="device-list clearfix">
					<? foreach($devices as $d): if('valid' != $d['valid']) continue; ?>
						<div class="device<? echo ($d["valid"]) ? ' valid' : ' invalid';?>">
							<small class="center sans"><?= $d["valid"] ? "確認済" : "未確認"; ?></small>
							<img src="<?= get_template_directory_uri(); ?>/styles/img/ebook-devices/<? echo $d["slug"]; ?>.png" alt="<? echo $d["name"]; ?>" width="48" height="48"/>
							<span class="sans center"><?= $d["name"]; ?></span>
						</div>
						<!-- .device ends -->
					<? endforeach; ?>
					<p class="clrB sans device-desc">
						ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
						端末追加のご要望については<a href="<? home_url('/inquiry/', 'https'); ?>">お問い合わせ</a>よりご連絡ください。
					</p>
				</div>
				<h2 id="download-list"><i class="fa-download"></i>ダウンロード</h2>
				<?	get_template_part('templates/table-downloadables'); ?>
			</div><!-- //.lwp-file-list -->
		<? endif; ?>

		<!-- // ticket list -->
		<? if(lwp_has_ticket()): ?>
			<div class="lwp-ticket-list lwp-container">
				<h2><i class="fa-ticket"></i><? the_title(); ?>のチケット</h2>
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
			</div><!-- //.lwp-ticket-list -->
		<? endif; ?>

		<? get_template_part('templates/single', 'share'); ?>

		<div class="next-previous clearfix clrB">
			<p class="prev">
				<? previous_post_link('%link', '<i class="fa-arrow-circle-left"></i>%title');?>
			</p>
			<p class="next">
				<? next_post_link('%link', '<i class="fa-arrow-circle-right"></i>%title'); ?>
			</p>
		</div>
		
		<div id="respond"><? comments_template(); ?></div>

		<? if(function_exists('related_posts')) related_posts(); ?>

	</div>
	<!-- #main ends -->

	<div id="sidebar">
		<? get_sidebar(); ?>
	</div><!-- //#sidebar -->


</div><!-- //.margin -->

<?
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了