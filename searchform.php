<form method="get" id="sorter" class="dark_bg center">
	<p>
		<?php if(is_search()): ?>
		<label>検索<input type="<?php attr_search(); ?>" name="s" value="<?php the_search_query(); ?>" /></label>
		<?php endif; ?>
		<select name="order">
			<option value="ASC"<?php if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'ASC') echo ' selected="selected"';?>>昇順</option>
			<option value="DESC"<?php if(!isset($_REQUEST['order']) || $_REQUEST['order'] != 'ASC') echo ' selected="selected"';?>>降順</option>
		</select>
		<select name="orderby">
			<option value="date"<?php if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby'] == 'date') echo ' selected="selected"';?>>公開日</option>
			<option value="modified"<?php if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'modified') echo ' selected="selected"';?>>最終更新日</option>
			<option value="title"<?php if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'title') echo ' selected="selected"';?>>タイトル</option>
			<option value="comment_count"<?php if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'comment_count') echo ' selected="selected"';?>>コメント数</option>
		</select>
		<input type="submit" class="submit button" value="SORT!" />
	</p>
</form>

