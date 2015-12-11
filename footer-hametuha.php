<?php if ( $hametuha_posts = hametuha_posts() ) : ?>
	<div class="hametuha-links">
		<div class="margin">

			<h2 class="hametuha-title">
				<img src="<?= get_stylesheet_directory_uri() ?>/styles/img/favicon/hametuha.png" alt="破滅派" width="150"
				     height="150"/><br/>
				破滅派に投稿している作品
			</h2>

			<p class="hametuha-links__description">
				高橋文樹が主催するオンライン文芸誌です。
				<br/>
				小説やエッセーを掲載しています。
			</p>

			<ol class="hametuha-list">
				<?php $counter = 0;
				foreach ( $hametuha_posts as $link ) : $counter ++; ?>
					<li>
						<a href="<?= esc_url( $link['url'] ) ?>">
							<h3>
								<?= esc_html( $link['title'] ) ?>
								<?php if ( current_time( 'timestamp' ) - strtotime( $link['post_date'] ) < 60 * 60 * 24 * 7 ) : ?>
									<small class="new">New</small>
								<?php endif ?>
							</h3>
							<p class="category">
							<span class="date">
								<i class="fa fa-calendar"></i>
								<?= mysql2date( 'Y年n月j日 H:i', $link['post_date'] ) ?>
							</span>
							<?php if ( isset( $link['source'] ) ) : ?>
								<span><i class="fa fa-globe"></i> <?= esc_html( $link['source'] ) ?></span>
							<?php endif; ?>
							<span class="tags"><i class="fa fa-tags"></i> <?= implode( ', ', $link['category'] ) ?></span>
							</p>

							<div class="description">
								<?= wpautop( $link['excerpt'] ) ?>
							</div>
							<i class="fa fa-chevron-circle-right"></i>
						</a>
					</li>
					<?php
					if ( $counter >= 6 ) {
						break;
					}
					?>
				<?php endforeach; ?>
			</ol>
			<p class="center">
				<a class="button" href="http://hametuha.com/doujin/detail/takahashi_fumiki/">もっと見る <i class="fa fa-external-link"></i></a>
			</p>
		</div>
	</div><!-- //.hametuha-links -->
<?php endif; ?>
