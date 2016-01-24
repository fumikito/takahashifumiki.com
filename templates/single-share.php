<div class="google-share clearfix">
	<div class="share">
		<?php fumiki_share( get_the_title() . " | " . get_bloginfo( 'name' ), get_permalink() ); ?>
	</div>
	<?php if ( is_singular() ) : ?>
		<div class="followMe">
			<h3 class="followMe__title">フォローしてください</h3>
			<p class="followMe__lead">
				ここで会ったのもなにかの縁。<br />
				高橋文樹.comの最新情報を見逃さないためにもフォローをお願いします。
			</p>
			<div class="followMe__wrapper">
				<div class="followMe__div followMe__div--facebook">
					<div class="followMe__button">
						<div class="fb-like" data-href="https://www.facebook.com/takahashifumiki.Page" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
					</div>
					<p class="followMe__desc">
						Facebookでは、ブログやtwitterでは書き辛いちょっとレアな情報を提供しています。<br />
					</p>
				</div>
				<div class="followMe__div followMe__div--twitter">
					<div class="followMe__button">
						<a href="https://twitter.com/takahashifumiki" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @takahashifumiki</a>
					</div>
					<p class="followMe__desc">
						Twitterでは日々の感じたことなどをつぶやいています。<br />
						メンションも気軽に飛ばしてください。
					</p>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<p class="sponsered">SPONSORED LINK</p>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- 高橋文樹スマートフォン上 -->
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-client="ca-pub-0087037684083564"
	     data-ad-slot="9969902841"
	     data-ad-format="auto"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	<?php if ( is_singular( 'post' ) ) : ?>
		<div class="single-content-detail">
			<i class="fa fa-info"></i>
			<p>
				この記事は<?php the_category( ', ' ) ?>にカテゴライズされています。タグは<?php the_tags( '', ', ' ) ?>です。
				そこら辺を見ると、似たような記事が見つかるかもしれません。
			</p>
		</div>
	<?php endif; ?>
</div><!-- //.google-share -->
