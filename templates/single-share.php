<div class="row">
	
	<div class="col-xs-12 col-sm-6 mb">
		
		<p class="ad-title">SPONSORED LINK</p>
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

	</div>
	
	<div class="col-xw-12 col-sm-6 mb">
		<?php if ( $tags = get_the_tags() ) : ?>
            <h2 class="post-tags-title"><i class="fa fa-tags"></i> この投稿のタグ</h2>
            <div class="post-tags-list">
				<?php foreach ( $tags as $tag ) : ?>
					<?php printf(
						'<a href="%s" class="btn btn-raised btn-primary"><i class="fa fa-tag"></i> %s(%d)</a>',
						get_tag_link( $tag ),
						esc_html( $tag->name ),
						$tag->count
					) ?>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>

		<?php if ( is_singular( 'post' ) ) : ?>
			<?php if ( is_singular( 'post' ) ) : ?>
                <div class="post-detail">
                    <h2 class="post-detail-title"><i class="fa fa-info"></i> この記事について</h2>
                    <p class="post-detail-desc">
                        この記事は<?php the_author_posts_link() ?>が<?php the_time( get_option( 'date_format' ) ) ?>に<?php the_category( ', ' ) ?>の記事として公開しました。
                    </p>
                </div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
</div>

<?php if ( is_singular() ) : ?>
	<?php get_template_part( 'templates/share', 'general' ) ?>
<?php endif; ?>


<div class="roaaw">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-0087037684083564"
     data-ad-slot="5721553648"></ins>
					<script>
					     (adsbygoogle = window.adsbygoogle || []).push({});
			</script>

</div>
