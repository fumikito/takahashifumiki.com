

<div class="hametuha-links margin">
    <h2 class="hametuha-title">
        <i class="fa fa-share-alt"></i> 破滅派に投稿しているもの
        <a class="button" href="http://hametuha.com/author/takahashi_fumiki/">全部見る</a>
    </h2>
    <?php if( $hametuha_posts = hametuha_posts() ): ?>
        <ol class="hametuha-list">
            <?php $counter = 0; foreach($hametuha_posts as $hametu): $counter++; ?>
                <li>
                    <i class="fa fa-chevron-circle-right"></i>
                    <a href="<?= esc_url($hametu['url']) ?>">
                        <h3><?= esc_html($hametu['title']) ?></h3>
                        <p class="category">
                            <span><i class="fa fa-tags"></i> <?= implode(', ', $hametu['category']) ?></span>
                            <span><i class="fa fa-calendar"></i> <?= mysql2date('Y年n月j日 H:i', $hametu['post_date']) ?></span>
                            <?php if( current_time('timestamp') - strtotime($hametu['post_date']) < 60 * 60 * 24 * 7 ): ?>
                            <span class="new"><i class="fa fa-star"></i>NEW!</span>
                            <?php endif ?>
                        </p>
                        <div class="description">
                            <?= wpautop($hametu['excerpt']) ?>
                        </div>
                    </a>
                </li>
                <?php if( $counter >= 3 ) break; ?>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p class="message warning">データを取得できませんでした.....</p>
    <?php endif; ?>
</div><!-- //.hametuha-links -->




<div class="margin pre-footer-navigation">


    <a id="footer-menu-toggle" href="#">
        <i class="fa fa-navicon"></i> メニュー
    </a>


    <? wp_nav_menu(array('theme_location' => 'top-page','container_class' => 'nav-menu', 'container' => 'nav')); ?>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- 高橋文樹レスポンシブフッター上 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-0087037684083564"
         data-ad-slot="9343442847"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

</div><!-- //.pre-footer-navigation -->


<footer class="dark_bg">
	
	<div id="footer-nav" class="margin sans clearfix">

		<div class="grid_4 first">
			<?php $admin = get_userdata(1); ?>
			<div class="inner clearfix">
				<h4 class="mono">
					<i class="fa-user"></i>
					About me
				</h4>
				<div class="admin-name">
					<?php echo get_avatar(1, 100); ?>
					<p>
						<strong><?php echo $admin->display_name; ?></strong>
						<?php echo wpautop($admin->description);?>
					</p>
					<p class="center">
						<a class="button mono" href="<?php echo home_url('/about/'); ?>">
							<i class="fa-question-sign"></i>Want to know more?
						</a>
					</p>
				</div>
			</div><!-- //.inner -->

            <?php if( !wp_is_mobile() ): ?>

			<h4 class="mono second">
				<i class="fa-twitter"></i>
				Recent tweet
			</h4>
			<blockquote class="clearfix left no-if-touch">
				<?php if(($tweet = get_twitter_timeline(1))): ?>
					<?php foreach($tweet as $t): ?>
					<blockquote>
						<i class="fa-quote-left"></i>
						<p><?php echo tweet_linkify($t->text); ?></p>
						<i class="fa-quote-right"></i>
						<cite>
							<a href="https://twitter.com/takahashifumiki/status/<?php echo $t->id_str;?>" target="_blank">
								<?php echo date('M jS Y(D) H:i', strtotime($t->created_at)); ?>&nbsp;
							</a>
						</cite>
					</blockquote>
					<small>
					</small>
					<?php break; endforeach; ?>
				<?php else: ?>
					つぶやきを取得できませんでした。
				<?php endif; ?>
			</blockquote>

            <?php endif; ?>
		</div><!-- //.grid_4 -->

        <?php if(!wp_is_mobile()): ?>
            <div class="grid_4">

                <h4 class="mono next">
                    <i class="fa-facebook"></i>
                    My Facebook Page
                </h4>
                <div class="like-box-container">
                    <div class="fb-like-box" data-href="http://www.facebook.com/takahashifumiki.page" data-width="292" data-height="420" data-show-faces="true" data-colorscheme="dark" data-stream="false" data-border-color="#3F464D" data-header="false"></div>
                </div>
            </div>
        <?php endif; ?>

		<div class="grid_4 last">

			<? if( !wp_is_mobile() ): ?>
                <h4 class="mono next no-if-touch">
                    <i class="fa-globe"></i>
                    My Web sites
                </h4>
                <ol class="inner sites no-if-touch">
                    <li><a class="hametuha one-line" target="_blank" href="http://hametuha.com/author/takahashi_fumiki/">破滅派 | 文芸誌</a></li>
                    <li><a class="hametuha-inc one-line" target="_blank" href="http://hametuha.co.jp">株式会社破滅派</a></li>
                    <li><a class="minicome one-line" target="_blank" href="http://minico.me">ミニコme! | ミニコミ誌販売ポータル</a></li>
                </ol>
			<? endif; ?>
			
			<h4 class="mono second">
				<i class="fa-search"></i>
				Find me at
			</h4>
			<ol class="inner no-text clearfix">
				<li>
					<a target="_blank" class="facebook" href="https://www.facebook.com/TakahashiFumiki.Page">
						<i class="fa-facebook"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="twitter" href="https://twitter.com/#!/takahashifumiki">
						<i class="fa-twitter"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="google" href="https://plus.google.com/108058172987021898722?rel=author">
						<i class="fa-google-plus-square"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="youtube" href="http://www.youtube.com/user/takahashifumiki">
						<i class="fa-youtube"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="github" href="https://github.com/fumikito">
						<i class="fa-github"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="foursquare" href="https://ja.foursquare.com/takahashifumiki">
						<i class="fa-foursquare"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="instagram" href="http://listagr.am/n/takahashifumiki">
						<i class="fa-instagram"></i>
					</a>
				</li>
				<li>
					<a target="_blank" class="instagram" href="http://www.linkedin.com/pub/<?= rawurlencode('文樹-高橋') ?>/41/5b4/a54">
						<i class="fa-linkedin-square"></i>
					</a>
				</li>
			</ol>
			
			<h4 class="mono second">
				<i class="fa-envelope"></i>
				Contact
			</h4>
			<ol class="inner">
				<li class="contact clearfix">
					<i class="fa-warning-sign fa-large"></i>
					執筆・Web制作のお仕事については<a href="<?php echo home_url('/inquiry/', 'https'); ?>">お問い合わせフォーム</a>よりご連絡下さい。
					なるべく早くお返事します。
				</li>
                <?php if( !wp_is_mobile()): ?>
                    <li><a class="mail" href="<?php echo home_url('/inquiry/', 'https'); ?>"><i class="fa-envelope-o"></i>お問い合わせ</a></li>
                    <li><a class="feed" href="<?php bloginfo('rss_url'); ?>"><i class="fa-rss-square"></i>RSSフィード</a></li>
                <?php endif; ?>
			</ol>
		</div><!-- //.grid_4 -->
	</div>
	<!-- #footer-nav ends -->

	<p class="divider center">
		<img src="<?= get_template_directory_uri() ?>/styles/img/divider.png" alt="takahashifumiki.com" width="100" height="100" />
	</p>

	<div id="copy-note" class="margin mono clearfix">
		<p>
			&copy; 2008 Takahashi Fumiki
		</p>
		<p class="poweredby">
			Proudly powered by <a href="http://wordpress.org">WordPress</a>.
			My theme Ver. <?php echo fumiki_theme_version(); ?> is DIYed :)
		</p>
	</div><!-- .copy ends-->

    <!-- フィルター用SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" style="height: 0;">
        <filter id="blurFilter">
            <feGaussianBlur stdDeviation="7" />
        </filter>
    </svg>
</footer>
<!-- #footer ends -->

<div id="tip-container">
	<table>
		<tr>
			<th>
				<i class="fa-book"></i>
			</th>
			<td class="content">
			</td>
		</tr>
		<tr class="close-button">
			<td colspan="2" class="right"><button>X</button></td>
		</tr>
	</table>
</div>
<?php wp_footer(); ?>
</body>
</html>