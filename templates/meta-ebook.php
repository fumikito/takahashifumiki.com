<table id="meta-ebook">
	<tbody>
	<tr>
		<th><i class="fa-book"></i>書名</th>
		<td class="book-title"><?php the_title(); ?></td>
	</tr>
	<tr>
		<th><i class="fa-user"></i>著者</th>
		<td class="book-author"><?php the_author(); ?></td>
	</tr>
	<tr>
		<th><i class="fa-inbox"></i>分量</th>
		<td>400字詰め原稿用紙<?= intval( get_post_meta( get_the_ID(), 'lwp_number', true ) ); ?>枚分</td>
	</tr>
	<tr>
		<th><i class="fa-qrcode"></i>ISBN</th>
		<td class="mono"><?= ( $isbn = get_post_meta( get_the_ID(), 'lwp_isbn', true ) ) ? $isbn : 'なし'; ?></td>
	</tr>
	<tr>
		<th><i class="fa-calendar"></i>公開日</th>
		<td class="mono"><?php the_date( 'Y.m.d' ); ?></td>
	</tr>
	</tbody>
</table>			
