<?
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)) :
	include_once(TEMPLATEPATH."/mootools/moo.php");
else :
/****************************
 * 通常
 ****************************/

get_header();
the_post();
?>
<div id="content" class="margin clearfix">
	<div id="main" class="<?= get_post_type(); ?>">

		<?php if( has_post_thumbnail() ) : ?>
			<figure class="eyecatch">
				<?
                    $attachment = get_post(get_post_thumbnail_id());
                    the_post_thumbnail('large', array(
                        'alt' => $attachment->post_title,
                        'title' => $attachment->post_title,
                    ));
                ?>
                <?php if( $attachment->post_excerpt ) :  ?>
                    <figcaption>
                        <?= $attachment->post_excerpt ?>
                    </figcaption>
                <?php endif ?>
			</figure>
		<?php endif; ?>

		<?php if( !empty($post->post_excerpt) ) :  ?>
			<div class="post-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<!-- ebook -->
		<?php if('ebook' == get_post_type()) :  ?>
			<div class="ebook-meta clearfix">
				<div class="img-container">
					<img class="cover" src="<?= get_post_meta(get_the_ID(), 'cover', true); ?>" alt="<?php the_title(); ?>" width="240" height="320" />
					<?php if(lwp_on_sale()) :  ?>
						<div class="on-sale old">
							<i class="fa-start"></i>
							Sale
						</div>
					<?php endif; ?>
				</div><!-- .img-container -->
				<?php get_template_part('templates/meta', 'ebook'); ?>
			</div>
		<?php endif; ?>


		<?php if( is_singular('post') && is_expired_post() ) :  ?>
			<p id="outdated-post" class="message warning">
				この投稿は<?= get_outdate_string(); ?>の記事です。情報が古くなっている可能性があるので、その点ご了承ください。
			</p>
		<?php endif; ?>


		<article class="entry clearfix">
			<?php the_content(); ?>
		</article><!-- //.entry -->

		<!-- // pagination -->
		<?php wp_link_pages(array(
			'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
			'after' => '</div>'
		)); ?>

		<div id="contents-last">&nbsp;</div>

		<!-- // Buy message -->
		<?php if( !lwp_is_free(true) ) :   ?>
			<div class="lwp-message lwp-container">
				<?php if(lwp_is_owner()) :  ?>
					<p class="message success">
						お買い上げありがとうございます!
						<?php if(lwp_has_files()) :  ?>
							<a href="#download-contents">ダウンロードリスト</a>からファイルをダウンロードしてください。
						<?php endif; ?>
					</p>
				<?php else :  ?>
					<p class="message notice">
						この<?= get_post_type_object(get_post_type())->labels->name; ?>は<strong><?php lwp_the_price();?></strong>で
						<?php if( 'ebook' == get_post_type() ) :  ?>
							販売していましたが、新規販売は中止しています。
						<?php else :  ?>
							販売しています。
						<?php endif; ?>
						<?php if( lwp_has_files() ) :  ?>
							購入した方はと<a href="#download-contents">ダウンロードリスト</a>のファイルをダウンロードできるようになります。
						<?php endif; ?>
					</p>
					<?php if( 'ebook' != get_post_type() ) :  ?>
						<p class="center"><?= lwp_buy_now(null, null); ?></p>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>


		<!-- // file lists -->
		<?php if( lwp_has_files() ) :  ?>
			<div class="lwp-file-list lwp-container">
				<h2><i class="fa-laptop"></i> 対応端末</h2>
				<?php $devices = lwp_get_devices(); ?>
				<div class="device-list clearfix">
					<?php foreach($devices as $d) :  if('valid' != $d['valid']) continue; ?>
						<div class="device<?= ($d["valid"]) ? ' valid' : ' invalid';?>">
							<small class="center sans"><?= $d["valid"] ? "確認済" : "未確認"; ?></small>
							<img src="<?= get_template_directory_uri(); ?>/styles/img/ebook-devices/<?= $d["slug"]; ?>.png" alt="<?= $d["name"]; ?>" width="48" height="48"/>
							<span class="sans center"><?= $d["name"]; ?></span>
						</div>
						<!-- .device ends -->
					<?php endforeach; ?>
					<p class="clrB sans device-desc">
						ここに掲載されていないものでも表示できる場合があります。端末は管理人が購入し次第検証いたします。<br />
						端末追加のご要望については<a href="<?php home_url('/inquiry/', 'https'); ?>">お問い合わせ</a>よりご連絡ください。
					</p>
				</div>
				<h2 id="download-list"><i class="fa-download"></i>ダウンロード</h2>
				<?php	get_template_part('templates/table', 'downloadables'); ?>
			</div><!-- //.lwp-file-list -->
		<?php endif; ?>

		<!-- // ticket list -->
		<?php if( lwp_has_ticket() ) :  ?>
			<div class="lwp-ticket-list lwp-container">
				<h2><i class="fa-ticket"></i><?php the_title(); ?>のチケット</h2>
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
					<?php lwp_list_tickets('callback=_fumiki_tickets'); ?>
					</tbody>
				</table>
			</div><!-- //.lwp-ticket-list -->
		<?php endif; ?>

        <?php get_template_part('templates/single', 'share'); ?>

		<div class="next-previous clearfix clrB">
			<p class="prev">
				<?php previous_post_link('%link', '<i class="fa-arrow-circle-left"></i>%title');?>
			</p>
			<p class="next">
				<?php next_post_link('%link', '<i class="fa-arrow-circle-right"></i>%title'); ?>
			</p>
		</div>
		
		<div id="respond"><?php comments_template(); ?></div>


		<?php if( function_exists('related_posts') ) related_posts() ?>

        <?php get_template_part('templates/single', 'ebook'); ?>

	</div>
	<!-- #main ends -->

</div><!-- //.margin -->

<?
get_footer('hametuha');
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了