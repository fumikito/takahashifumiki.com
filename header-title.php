


<div class="margin header">
		
	<?php $title = fumiki_title(); ?>
	<h1 class="title mincho<?php if(mb_strlen($title, 'utf-8') <= 20) echo ' center'; ?>">
		<?php if(is_singular('ebook')): ?>
			<strong class="sans">【高橋文樹の電子書籍】</strong>
		<?php endif; ?>
		<?php echo $title; ?>
	</h1>
	
	<?php if((is_archive() && !is_post_type_archive('ebook')) || is_search()):?>
		<div class="calendar shadow">
			<span class="date">Found</span>
			<span class="year"><?php global $wp_query;  echo number_format($wp_query->found_posts); ?></span>
		</div>
	<?php endif; ?>
	<?php if(is_singular()): ?>
		<div class="calendar shadow">
			<?php
				$date = explode(',', mysql2date('M,jS,D,Y,', $post->post_date, false));
				printf('<span class="date">%1$s %2$s (%3$s)</span><span class="year">%4$s</span>', $date[0], $date[1], $date[2], $date[3]); 
			?>
		</div>
	<?php endif; ?>

		
	<?php if(is_singular() && !is_page_template('page-account.php')): ?>
	<div class="title-meta clearfix">
		
		<div class="google"><?php google_ads(3); ?></div>
		<table>
			<tbody>
				<tr>
					<th class="letters"><i></i>文字数</th>
					<td>
						<?php $length = fumiki_content_length(); ?>
						<span class="mono"><?php echo number_format($length); ?></span>文字
					</td>
				</tr>
				<tr>
					<th class="minutes"><i></i>所要時間</th>
					<td>
						およそ<span class="mono"><?php echo floor($length / 400); ?></span>分
					</td>
				</tr>
				<tr>
					<th class="past"><i></i>経過時間</th>
					<td><?php the_expiration_info(); ?></td>
				</tr>
				<tr>
					<th class="modified"><i></i>最終更新日時</th>
					<td><?php the_modified_date();?></td>
				</tr>
				<tr>
					<th class="category"><i></i>カテゴリー</th>
					<td><?php the_category(', '); ?></td>
				</tr>
				<tr>
					<th class="tag"><i></i>タグ</th>
					<td><?php the_tags('', ', '); ?></td>
				</tr>
				<tr>
					<th class="count"><i></i>フィードバック</th>
					<td><span class="mono"><?php echo comments_number('0件', "1件", '%件'); ?></span></td>
				</tr>
			</tbody>
		</table>			
	</div>
	<?php endif ?>
		
</div><!-- .header -->