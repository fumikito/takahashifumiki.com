<?
get_header('meta');
get_header('navi');
?>
<div id="content" class="margin clearfix">
	<? if(have_posts()): the_post(); ?>
	<div class="main-menu">
		<h1><img alt="<? bloginfo('name'); ?>" src="<?= get_template_directory_uri(); ?>/img/header-logo-big.png" width="380" height="40" /></h1>
		<p class="desc"><? bloginfo('description'); ?></p>
		<div class="quote">
			<i></i>
			<? the_content(); ?>
			<i class="after"></i>
		</div>
	</div>
	
	
	<? if(!is_smartphone()) fumiki_share(get_bloginfo('name'), home_url());?>
	
	
	<div class="desc-box clearfix">
		<div class="static">
			<table>
				<caption>統計情報</caption>
				<tbody>
					<tr>
						<th>開始日</th>
						<td class="mono">
							<? $past = human_time_diff(strtotime('2008-4-18')); ?>
							2008.4.18（<?= $past; ?>前）
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
						<th>はてなブックマーク</th>
						<td class="mono">
							<?= number_format(hatena_total_bookmark_count()); ?>
						</td>
					</tr>
					<tr>
						<th>プラットフォーム</th>
						<td class="mono">WordPress <? global $wp_version; echo $wp_version; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="main-box clearfix">
			<div class="grid_2">
				<h2 class="owener">運営者について</h2>
				<p>
					小説家であり、Web制作を生業とし、会社を経営しています。
					なぜこのように生きることになったのかは自分でもよくわかりません。
					詳しいプロフィールについては<a href="<?= home_url('/about/'); ?>">高橋文樹について</a>をご覧下さい。
				</p>
			</div>
			<div class="grid_2">
				<h2 class="purpose">サイトの目的</h2>
				<p>
					このサイトは著者自ら情報発信をしていくことで、
					読者とのコミュニケーションを計ることを目的としています。
					また、<a href="<?= get_post_type_archive_link('ebook');?>">電子書籍販売</a>や<a href="<?= get_post_type_archive_link('events');?>">イベント開催</a>などを通じて、
					職業作家として生きるための新しい方法も模索します。
				</p>
			</div>
			<div class="grid_2 clrL">
				<h2 class="history">経緯</h2>
				<p>
					2001年の大学生だった頃、文学賞を受賞して作家デビューしましたが、
					長い冬の時代を過ごすことになり、2007年から<a href="http://hametuha.com">破滅派</a>というオンライン文芸誌を立ち上げました。
					その直後Web業界に転職したのち3年を経て独立、いまに至ります。
					詳しくは<a href="<?= home_url('/about/history/');?>">著者略歴</a>をご覧下さい。
				</p>
			</div>
			<div class="grid_2">
				<h2 class="contact">コンタクト</h2>
				<p>
					「愛情の対義語は憎しみではなく無関心である」と言ったのはマザー・テレサですが、
					読者からのフィードバックはどんなものであれ嬉しいものです。
					各ページのコメント欄や<a href="<?= home_url('/inquiry/', 'https'); ?>">お問い合わせ</a>からご連絡下さい。
					<a href="https://twitter.com/takahashifumiki" target="_blank">Twitter</a>でもお気軽にリプライを飛ばしてください。
				</p>
			</div>
		</div>
	</div>
	
	<div class="desc-parts clearfix">
		<h2><?= post_custom('excerpt_title'); ?></h2>
		<div class="desc">
			<?= post_custom('excerpt'); ?>
		</div>
		<? dynamic_sidebar('通常投稿'); ?>
	</div>
	
	<? endif; ?>
	
	<? wp_nav_menu(array('theme_location' => 'top-page','container_class' => 'nav-menu')); ?>

</div><!-- //#content -->

<? get_footer();
