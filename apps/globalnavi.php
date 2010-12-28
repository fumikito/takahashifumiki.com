<?php
add_action("admin_menu", 'fumiki_add_globalnavi');

/**
 * グローバルナビの画面を管理画面に追加
 * 
 * @return void
 */
function fumiki_add_globalnavi()
{
	add_submenu_page("edit-pages.php","グローバルナビ設定", "グローバルナビ", 10, __FILE__, 'fumiki_globalnavi_admin');
}

/**
 * グローバルナビに追加する管理画面を表示
 * 
 * @return void
 */
function fumiki_globalnavi_admin()
{
	if(isset($_POST["globalnavi"]) && wp_verify_nonce($_POST["_wpnonce"], "fumiki_globalnavi")){
		update_option("fumiki_globalnavi", $_POST["globalnavi"]);
	}
	$globalnavi = get_option("fumiki_globalnavi");
?>
<script type="text/javascript">
//<![CDATA[
	function fumiki_enter_page(target)
	{
		//IDを取得
		var i = target.value;
		var input = document.getElementById('globalnavi');
		if(input.value == ""){
			input.value = i;
		}else{
			input.value = input.value + ',' + i;
		}
	}
//]]>
</script>
<div class="wrap">
<h2>グローバルナビゲーション設定</h2>
<form method="post">
<?php wp_nonce_field("fumiki_globalnavi"); ?>
<table class="form-table">
	<tr>
		<th>グローバルナビに設定するページ</th>
		<td><input type="text" id="globalnavi" name="globalnavi" value="<?php echo $globalnavi; ?>" /></td>
	</tr>
	<tr>
		<th>ページ</th>
		<td>
			<select onchange="fumiki_enter_page(this);">
				<?php query_posts("post_type=page&showposts=-1"); if(have_posts()): while(have_posts()): the_post(); ?>
				<option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
				<?php endwhile; endif; rewind_posts(); ?>
			</select>
		</td>
	</tr>
</table>
<p class="submit">
	<input class="button-primary" type="submit" value="保存する" />
</p>
</form>
</div>
<!-- .wrap ends -->
<?php
}

/**
 * グローバルナビに追加される関数
 * @return string
 */
function get_global_navi()
{
	$arr = get_option("fumiki_globalnavi");
	return ($arr) ? explode(",",$arr) : array();
}