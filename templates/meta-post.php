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
		<? if(is_singular('post')): ?>
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
		<? endif; ?>
	</tbody>
</table>			
