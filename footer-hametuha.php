<div class="hametuha-links margin">
	<h2 class="hametuha-title">
		<i class="fa fa-share-alt"></i> 破滅派に投稿している作品
	</h2>
	<?php if( $hametuha_posts = hametuha_posts() ): ?>
		<ol class="hametuha-list">
			<?php $counter = 0; foreach($hametuha_posts as $link): $counter++; ?>
				<li>
					<a href="<?= esc_url($link['url']) ?>">
						<h3>
							<?= esc_html($link['title']) ?>
							<?php if( current_time('timestamp') - strtotime($link['post_date']) < 60 * 60 * 24 * 7 ): ?>
								<small class="new">New</small>
							<?php endif ?>
						</h3>
						<p class="category">
							<?php if( isset($link['source']) ): ?>
								<span><i class="fa fa-globe"></i> <?= esc_html($link['source']) ?></span>
							<?php endif; ?>
							<span><i class="fa fa-tags"></i> <?= implode(', ', $link['category']) ?></span>
							<span class="date"><i class="fa fa-calendar"></i> <?= mysql2date('Y年n月j日 H:i', $link['post_date']) ?></span>
						</p>
						<div class="description">
							<?= wpautop($link['excerpt']) ?>
						</div>
						<i class="fa fa-chevron-circle-right"></i>
					</a>
				</li>
				<?php if( $counter >= 6 ) break; ?>
			<?php endforeach; ?>
		</ol>
	<?php else: ?>
		<p class="message warning">データを取得できませんでした.....</p>
	<?php endif; ?>
</div><!-- //.hametuha-links -->