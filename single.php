<?php
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
<?php
get_header('navi');
get_header('title');
?>

<div id="content" class="margin clearfix">
	<div id="main">
		<?php if(have_posts()): while(have_posts()): the_post();?>
		<div class="entry clearfix">
			<?php the_content(); ?>
			<?php wp_link_pages(array(
				'before' => '<div class="wp-pagenavi clrB"><span class="pages">ページ: </span>',
				'after' => '</div>'
				
			)); ?>
			<?php if(!lwp_is_free(true)): ?>
			<div class="ebook">
				<?php $files = lwp_get_files(); ?>
				<?php if(lwp_is_owner()): ?>
				<p class="message success">
					お買い上げありがとうございます!
					<?php if(!empty($files)): ?>
					<a href="#download-contents">ダウンロードリスト</a>からファイルをダウンロードしてください。
					<?php endif; ?>
				</p>
				<?php else: ?>
				<p class="message notice">
					この投稿は<strong><?php lwp_the_price();?></strong>で販売しています。
					<?php if(!empty($files)): ?>
					購入すると<a href="#download-contents">ダウンロードリスト</a>のファイルをダウンロードできるようになります。
					<?php endif; ?>
				</p>
				<p class="center"><?php echo lwp_buy_now(null, null); ?></p>
				<?php endif; ?>
				<?php if(!empty($files)): ?>
				<table class="file-list" id="download-contents">
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
									<?php echo wpautop($f->detail); ?>
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
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if(lwp_has_ticket()): ?>
				<h2>イベント詳細</h2>
				<table class="form-table">
					<tr>
						<th>開催日時</th>
						<td><?php echo get_post_meta(get_the_ID(), 'fumiki_event_schedule', true) ?: '未定'; ?></td>
					</tr>
					<tr>
						<th>申込〆切</th>
						<td><?php echo lwp_selling_limit(); ?></td>
					</tr>
					<tr>
						<th>キャンセル条件</th>
						<td>
							<?php if(lwp_is_cancelable()): ?>
								<?php
									function _fumiki_cancel_condition($limit, $days_before, $ratio){
										$limit = date_i18n(get_option('date_format'), strtotime($limit) - ($days_before * 60 * 60 * 24));
										echo '<li>'.$limit.'までは'.$ratio.'%返金</li>';
									}
									lwp_list_cancel_condition('callback=_fumiki_cancel_condition');
								?>
							<?php else: ?>
								できません
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>あなたのステータス</th>
						<td>
							<?php if(lwp_is_participating()): ?>
								すでに申し込み済みです。キャンセルする場合は<a href="<?php echo lwp_cancel_url();?>">こちら</a>から。<br />
								<a class="button" href="<?php echo lwp_ticket_url(); ?>">チケットを表示する</a>
							<?php elseif(is_user_logged_in()): ?>
								申し込んでいません。
							<?php else: ?>
								<a href="<?php echo wp_login_url(get_permalink());?>">ログイン</a>して申し込んでください。
							<?php endif; ?>
						</td>
					</tr>
				</table>
				<h2>チケット</h2>
					<table class="form-table" style="table-layout: fixed;">
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
							<?php
								/**
								 * 
								 * @global Literally_WordPress $lwp
								 * @param int $id 
								 */
								function _fumiki_tickets($parent_id){
									global $lwp;
									?>
							<tr>
								<th scope="row"><?php the_title(); ?></td>
								<td><?php lwp_the_price();?></td>
								<td>
									<?php lwp_the_ticket_stock();?>
								</td>
								<td><?php the_content(); ?></td>
								<td><a class="lwp-buynow" href="<?php echo esc_url(lwp_buy_url());?>">注文</a></td>
							</tr>
									<?php
								}
								lwp_list_tickets('callback=_fumiki_tickets');
							?>
						</tbody>
					</table>
					<?php $number = lwp_participants_number(); ?>
					<h2>参加者: <?php echo number_format($number); ?>名</h2>
					<?php if($number): ?>
						<ol>
							<?php lwp_list_participants();?>
						</ol>
						<?php lwp_token_chekcer();?>
					<?php else: ?>
					<p class="message warning">
						大変です！　まだ誰も参加表明していません！
					</p>
					<?php endif; ?>
			<?php endif; ?>
			<div class="share clrB clearfix">
				<p class="prev"><?php previous_post_link('%link');?></p>
				<p class="next"><?php	next_post_link('%link'); ?></p>
				<h3 class="mono">Share This: <small>この記事が気に入ったら、ぜひシェアしてください。</small></h3>
				<?php fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
			</div>
			
			<?php if(is_singular('post')): ?>
				<div class="google clearfix">
					<div class="left"><?php google_ads(4);?></div>
					<div class="right"><?php google_ads(4);?></div>
				</div>
			<?php endif; ?>
		</div><!-- //.entry -->
		
		
		<?php endwhile; endif; ?>
		<div id="respond"><?php comments_template(); ?></div>
		<?php get_template_part('related-posts'); ?>
	</div>
	<!-- #main ends -->

</div>

<?php
get_footer();
endif;//Mootoolsと通常single.phpの分岐終了