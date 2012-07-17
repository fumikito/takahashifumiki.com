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
	
	<? fumiki_share(get_bloginfo('name'), home_url());?>

	
	
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
		<h2>私とあなたの関わり方</h2>
		<p class="desc">
			高橋文樹.comは私とこのサイトを訪れる方の交流の場にしようと思っています。
			とはいえ私には人に与えられるものが多くないため、一般的なWebサイトと同じものがほとんどです。
			しかし、中には実験的なもの／珍しいものもありますので、
			宝探しでもするつもりでお楽しみください。
		</p>
		<? dynamic_sidebar('通常投稿'); ?>
		<div class="grid_3">
			<h3>文学について</h3>
			<p>
				高橋文樹は小説家ですので、文学的なコンテンツを提供しています。
				カテゴリー<?= get_cat_tag('文芸活動'); ?>などに読書日記を上げたりしています。
			</p>
		</div>
		<div class="grid_3">
			<h3>電子書籍</h3>
			<p>
				このサイトでは私の作品を<a href="<?= get_post_type_archive_link('ebook'); ?>">電子書籍</a>にして販売しています。
				文芸作品で対価を得るための新しい方法として模索中ですので、
				ご興味のある方はご覧下さい。
			</p>
		</div>
		<div class="grid_3 last">
			<h3>破滅派について</h3>
			<p>
				<a href="http://hametuha.com">破滅派</a>というのは私が主催する文芸同人誌ですが、
				登記して<a href="http://hametuha.co.jp">株式会社化</a>しました。
				「文芸は経済的に自立しえるのか」というテーマの元、日々悪戦苦闘しています。
				破滅派タグにまとまっています。
			</p>
		</div>
		<div class="grid_3">
			<h3>Web制作について</h3>
			<p>
				私は小説で生計を立てられないので、Web制作で生活をまかなっています。
				その中で考えたことや知ったことを折に触れて記事にしています。
				カテゴリー<?= get_cat_tag('Web制作') ?>にまとまっています。
				このサイトのアクセスのほとんどはこの話題になってしまいました……
			</p>
		</div>
		<div class="grid_3">
			<h3>WordPress</h3>
			<p>
				<a href="http://ja.wordpress.org" target="_blank">WordPress</a>とはこのサイトのベースになっているオープンソースソフトウェアです。
				かれこれ5年ばかりいじっており、プラグインという拡張用ソフトウェアも幾つか
				自作しています（<a href="<?= home_url('/about/wp-plugins/'); ?>">一覧</a>）。
				興味のある方はWordPressタグや<a href="http://profiles.wordpress.org/Takahashi_Fumiki/" target="_blank">公式リポジトリ</a>をご覧下さい。
			</p>
		</div>
		<div class="grid_3 last">
			<h3>Do It Yourself</h3>
			<p>
				自分で作ることを<abbr title="Do It Yourself">DIY</abbr>と言いますが、
				私は山梨に3,000坪の土地を共同購入し、セルフビルドで家を建てています。
				自らの求めに応じて作るという観念に取り憑かれた結果、家まで作ることになりました。
				この詳細は建築タグなどにまとめられています。
			</p>
		</div>
		<div class="grid_3">
			<h3>キーワード一覧</h3>
			<p class="tagcloud">
				<? wp_tag_cloud('smallest=8&largest=24&unit=px&order=RAND'); ?>
			</p>
		</div>
		<div class="grid_3">
			<h3>注意事項</h3>
			<p>
				このサイトを利用するにあたって基本的に注意するようなことはありませんが、
				<a href="<?= home_url('/policy/'); ?>">プライバシーポリシー</a>や<a href="<?= home_url('/ebook/contract/'); ?>">電子書籍を購入するにあたっての利用規約</a>をお読み頂ければ、
				そんなにひどいことにはならないと思われます。
				不明な点などありましたら、<a href="<?= home_url('/inquiry/', 'https'); ?>">お問い合わせ</a>よりご連絡ください。
			</p>
		</div>
		<div class="grid_3 last">
			<h3>注意事項</h3>
			<script charset="utf-8" type="text/javascript" src="http://ws.amazon.co.jp/widgets/q?ServiceVersion=20070822&MarketPlace=JP&ID=V20070822/JP/hametuha-22/8001/44e350e4-5f34-4f29-b6a0-62408c33402d"></script>
		</div>
	</div>
	
	<? endif; ?>
	
	<? wp_nav_menu(array('theme_location' => 'top-page','container_class' => 'nav-menu')); ?>

</div><!-- //#content -->

<? get_footer();
