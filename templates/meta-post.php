<table class="title-meta">
	<tbody>
		<tr>
			<th><i class="fa-font"></i>文字数</th>
			<td>
				<?php $length = fumiki_content_length(); ?>
				<span class="mono"><?php echo number_format($length); ?></span>文字
			</td>
			<th><i class="fa-tachometer"></i>所要時間</th>
			<td>
				およそ<span class="mono"><?php echo floor($length / 400); ?></span>分
			</td>
			<th><i class="fa-calendar"></i>経過時間</th>
			<td><?php the_expiration_info(); ?></td>
			<th><i class="fa-edit"></i>最終更新日時</th>
			<td><?php the_modified_date();?></td>
		</tr>
		<tr>
			<th><i class="fa-comments"></i>フィードバック</th>
			<td><span class="mono"><?php echo comments_number('0件', "1件", '%件'); ?></span></td>
			<th><i class="fa-folder-open"></i>カテゴリー</th>
			<td><?php the_category(', '); ?></td>
			<th><i class="fa-tags"></i>タグ</th>
			<td colspan="3"><?php the_tags('', ', '); ?></td>
		</tr>
	</tbody>
</table>
