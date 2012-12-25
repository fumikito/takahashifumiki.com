<? get_header('meta'); ?>
<div id="content" class="margin clearfix">
	<? if(have_posts()): the_post(); ?>
	
	<div class="desc-box clearfix">
		
		<div class="box grid_1 title_box no_shadow">
			<h1 class="center">
				<img alt="<? bloginfo('name'); ?>" src="<?= get_template_directory_uri(); ?>/styles/img/header-logo-big.png" width="380" height="40" />
			</h1>
			<p class="desc center"><? echo implode("<br />", array_filter(explode("。", get_bloginfo('description')), function($var){
				return !empty($var);
			})); ?></p>
			<div class="quote">
				<i></i>
				<? if(function_exists('quotescollection_get_randomquote')): $quote = quotescollection_get_randomquote();?>
				<blockquote>
					<p><?= esc_html($quote['quote']); ?></p>
					<cite>-- <?= esc_html($quote['author']) ?>, <?= esc_html($quote['source']);?></cite>
				</blockquote>
				<? endif; ?>
				<i class="after"></i>
			</div>
		</div>	
		
		<div class="box grid_2">
			<h2>
				<i class="icon-user"></i>
				運営者について
			</h2>
			<p class="center">
				<?php echo get_avatar(1, 150); ?>
			</p>
			<p>
				小説家であり、Web制作を生業とし、会社を経営しています。
				なぜこのように生きることになったのかは自分でもよくわかりません。
				詳しいプロフィールについては<a href="<?= home_url('/about/'); ?>">高橋文樹について</a>をご覧下さい。
			</p>
		</div>

		<div class="box grid_2">
			<h2>
				<i class="icon-flag"></i>
				サイトの目的
			</h2>
			<p>
				このサイトは著者自ら情報発信をしていくことで、
				読者とのコミュニケーションを計ることを目的としています。
				また、<a href="<?= get_post_type_archive_link('ebook');?>">電子書籍販売</a>や<a href="<?= get_post_type_archive_link('events');?>">イベント開催</a>などを通じて、
				職業作家として生きるための新しい方法も模索します。
			</p>
		</div>

		<div class="box grid_2">
			<h2>
				<i class="icon-time"></i>
				経緯
			</h2>
			<p class="center">
				<img class="avatar" src="<?= get_template_directory_uri(); ?>/styles/img/front-page/history.jpg" width="150" height="150" alt="これまでの経緯" />
			</p>
			<p>
				2001年の大学生だった頃、文学賞を受賞して作家デビューしましたが、
				長い冬の時代を過ごすことになり、2007年から<a href="http://hametuha.com">破滅派</a>というオンライン文芸誌を立ち上げました。
				その直後Web業界に転職したのち3年を経て独立、いまに至ります。
				詳しくは<a href="<?= home_url('/about/history/');?>">著者略歴</a>をご覧下さい。
			</p>
		</div>
		
		<div class="box grid_2">
			<table>
				<caption>
					<i class="icon-signal"></i>統計情報
				</caption>
				<tbody>
					<tr>
						<th>開始日</th>
						<td class="mono">
							<? $past = human_time_diff(strtotime('2008-4-18')); ?>
							2008.4.18（<?= $past; ?>前）
						</td>
					</tr>
					<tr>
						<th>最新投稿日</th>
						<td class="mono">
							<? $last_updated = fumiki_get_latest_updated(); ?>
							<?= mysql2date('Y.n.j', $last_updated); ?>
							（<?= human_time_diff(strtotime($last_updated)); ?>前）
						</td>
					</tr>
					<tr>
						<th>投稿数</th>
						<td class="mono"><? 
							$post_counts = fumiki_get_post_count();
							echo number_format($post_counts);
							printf(" (月%s本)", absint($post_counts / preg_replace("/[^0-9]/", "", $past) * 30));
						?></td>
					</tr>
					<tr>
						<th>総文字量</th>
						<td class="mono">
							<? $length = fumiki_get_post_length(); ?>
							<?= number_format($length)." (".number_format($length / $post_counts)."/1post)"; ?>
						</td>
					</tr>
					
					<tr>
						<th>はてブ総数</th>
						<td class="mono">
							<?= number_format(hatena_total_bookmark_count()); ?>
						</td>
					</tr>
					<tr>
						<th>使用ソフト</th>
						<td class="mono">WordPress <? global $wp_version; echo $wp_version; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		
		
		<div class=" box grid_2">
			<h2 class="contact">
				<i class="icon-envelope"></i>
				コンタクト
			</h2>
			<p>
				「愛情の対義語は憎しみではなく無関心である」と言ったのはマザー・テレサですが、
				読者からのフィードバックはどんなものであれ嬉しいものです。
				各ページのコメント欄や<a href="<?= home_url('/inquiry/', 'https'); ?>">お問い合わせ</a>からご連絡下さい。
				<a href="https://twitter.com/takahashifumiki" target="_blank">Twitter</a>でもお気軽にリプライを飛ばしてください。
			</p>
		</div>
		
	
		<div class="box grid_1 no_shadow">
			<h2>
				<i class="icon-heart"></i>
				<?= post_custom('excerpt_title'); ?>
			</h2>
			<div class="desc">
				<?= post_custom('excerpt'); ?>
			</div>
		</div>
		
		<div class="box grid_2">
			<h2>
				<i class="icon-calendar"></i>
				最新の投稿
			</h2>
			<ol class="post-list">
				<? $query = new WP_Query('post_type=post&post_status=publish&posts_per_page=5'); ?>
				<? if($query->have_posts()) while($query->have_posts()): $query->the_post(); ?>
				<? get_template_part('templates/loop-post-list'); ?>
				<? endwhile; ?>
			</ol>
		</div>
		
		<? dynamic_sidebar('トップページ'); ?>
		<? dynamic_sidebar('通常サイドバー'); ?>
		
	</div>
	
	<? endif; ?>
	</div><!-- //.desc-box -->
	
	<div class="desc-parts">
		<? wp_nav_menu(array('theme_location' => 'top-page','container_class' => 'nav-menu')); ?>
	</div>
	
</div><!-- //#content -->

<? get_footer();
