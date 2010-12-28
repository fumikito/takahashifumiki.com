<?php
/*
 * Template Name: アカウント
 */
	if(!is_user_logged_in() && !is_page("login"))
		header("Location: ".get_bloginfo('url')."/login/?redirect_to={$_SERVER['REQUEST_URI']}");
	the_post();
	get_header();
?>

<div id="wrapper">
	
	<?php get_header('single'); ?>
	
	<div id="content" class="clearfix">
		
		<div id="main">
			<div class="meta">
				<h1 class="mincho"><span><?php the_title(); ?></span></h1>
				<div class="calendar old">
						<?php $fumiki->dateformat(date('Y n j D g:iA'));?>
				</div>
				<!-- .calendar ends -->
				<ul>
					<li>
						<small class="old">
							<?php
								if(is_user_logged_in()){
									get_currentuserinfo();
									echo "登録日：".mysql2date('Y年n月j日',$userdata->user_registered);
								}else
									echo "&nbsp;";
							?>
						</small>
					</li>
				</ul>
			</div>
			<!-- .meta ends -->
			
			<div class="account-wrap" class="clearfix">
				<div class="entry clearfix">
					<?php if($_REQUEST['action'] == "register"): ?>
					<p class="message center">
						<a href="<?php bloginfo('url'); ?>/ebooks/contract">高橋文樹.comの利用規約</a>にご同意の上、会員登録を行ってください。
					</p>
					<?php endif; ?>
					<?php if(is_page("本棚")): ?>
					<!-- ▼購入済み書籍一覧 -->
						<?php $ebooks = lwp_bought_books(); ?>
						<?php if(empty($ebooks)): ?>
							<p>購入済みの書籍はまだありません</p>
						<?php else: ?>
							<!-- .book-shelf starts -->
							<table class="book-shelf">
								<thead>
									<tr>
										<th>書名</th>
										<th>購入価格</th>
										<th>購入日</th>
										<th></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td>総合計</td>
										<td class="old">&yen;<?php echo number_format(lwp_user_bought_price());?></td>
										<td></td>
										<td>ご利用ありがとうございます。</td>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($ebooks as $ebook):
											// TODO: 本棚にするか、取引履歴にするか
											$tran = lwp_get_tran($ebook->ID);
											$tran = $tran[0];
									?>
									<tr>
										<td><?php echo $ebook->post_title; ?></td>
										<td class="old">&yen;<?php echo number_format($tran->price); ?></td>
										<td><?php echo mysql2date(get_option("date_format"), $tran->updated, false); ?></td>
										<td><a class="more" href="<?php echo get_permalink($ebook->ID); ?>">ダウンロード</a></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<!-- .book-shelf ends -->
						<?php endif; ?>
					<!-- ▲購入済み書籍一覧 -->
					<?php endif; ?>
					<?php the_content(); ?>
					<p class="center google clrB">
					<script type="text/javascript"><!--
						google_ad_client = "pub-0087037684083564";
						/* 高橋文樹 投稿内広告 */
						google_ad_slot = "5844658673";
						google_ad_width = 468;
						google_ad_height = 60;
						//-->
					</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
					</p>
					<!-- .google ends -->
				</div>
				<!-- .entry ends -->
				
				
			</div>
			<!-- #account-content -->
			
			
			<div id="end_meta" style="background:none">
				<?php fumiki_to_top(); ?>
			</div>
			<!-- #end_meta -->
			
		</div>
		<!-- #main ends -->
		
		<?php get_sidebar("ebooks"); ?>
	</div>
	
</div>
<!-- #wrapper ends -->

<?php
	get_footer();
