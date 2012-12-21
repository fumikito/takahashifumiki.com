<form method="get" id="sorter" action="<? bloginfo('url'); ?>">
	<p>
		<input type="hidden" name="paged" value="1" />
		<input type="hidden" name="post_type" value="any" />
		<input type="text" name="s" value="<? the_search_query(); ?>" placeholder="検索キーワード" />
		<?
			if(isset($_REQUEST['cat'])){
				$cat_id = intval($_REQUEST['cat']);
			}elseif(is_category()){
				$cat_id = get_cat_ID(single_cat_title('', false));
			}else{
				$cat_id = 0;
			}
			wp_dropdown_categories('show_option_none=カテゴリーを選択&selected='.$cat_id);
		?>
		<select name="order">
			<option value="ASC"<? if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'ASC') echo ' selected="selected"';?>>昇順</option>
			<option value="DESC"<? if(!isset($_REQUEST['order']) || $_REQUEST['order'] != 'ASC') echo ' selected="selected"';?>>降順</option>
		</select>
		<select name="orderby">
			<option value="date"<? if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby'] == 'date') echo ' selected="selected"';?>>公開日</option>
			<option value="modified"<? if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'modified') echo ' selected="selected"';?>>最終更新日</option>
			<option value="title"<? if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'title') echo ' selected="selected"';?>>タイトル</option>
			<option value="comment_count"<? if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'comment_count') echo ' selected="selected"';?>>コメント数</option>
		</select>
		<input type="submit" class="submit button" value="検索" />
	</p>
</form>

