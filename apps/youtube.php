<?php
add_action("admin_menu", 'fumiki_add_youtube');
function fumiki_add_youtube()
{
	add_submenu_page("upload.php","Youtube設定", "Youtube", 10, __FILE__, 'fumiki_youtube_admin');
}

function fumiki_youtube_admin()
{
	if(isset($_POST["youtube"])) file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."youtube.txt", stripcslashes($_POST["youtube"]));
?>
<div class="wrap">
<h2>Youtube設定</h2>
<form method="post">
<table>
<tr>
	<th>Youtubeのソース</th>
	<td><textarea name="youtube"></textarea></td>
</tr>
</table>
<p class="submit">
<input type="submit" value="保存する" />
</p>
</form>
<p>
<?php echo fumiki_youtube();?>
</p>
</div>
<?php
}

/**
 * Youtubeのソースを返す
 * @param integer $width
 * @param integer $height
 * @return String
 */
function fumiki_youtube($width = false, $height = false){
	$file = dirname(__FILE__).DIRECTORY_SEPARATOR."youtube.txt";
	if(file_exists($file)){
		$youtube = file_get_contents($file);
		if($width) $youtube = preg_replace("/width=\"[0-9]+\"/s", "width=\"{$width}\"", $youtube);
		if($height) $youtube = preg_replace("/height=\"[0-9]+\"/s", "height=\"{$height}\"", $youtube);
		return $youtube;
	}
	else return false;
}