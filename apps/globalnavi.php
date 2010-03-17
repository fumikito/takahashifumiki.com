<?php
add_action("admin_menu", 'fumiki_add_globalnavi');

function fumiki_add_globalnavi()
{
	add_submenu_page("edit-pages.php","グローバルナビ設定", "グローバルナビ", 10, __FILE__, 'fumiki_globalnavi_admin');
}

function fumiki_globalnavi_admin()
{
	if(isset($_POST["globalnavi"])){
		if(get_option("fumiki_globalnavi")) update_option("fumiki_globalnavi", $_POST["globalnavi"]);
		else add_option("fumiki_globalnavi", $_POST["globalnavi"]);
	}
	
	$globalnavi = get_option("fumiki_globalnavi");
?>
<div class="wrap">
<h2>グローバルナビゲーション設定</h2>
<form method="post">
<table>
<tr>
	<th>グローバルナビに設定するページ</th>
	<td><input type="text" name="globalnavi" value="<?php echo $globalnavi; ?>" /></td>
</tr>
</table>
<p class="submit">
<input type="submit" value="保存する" />
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