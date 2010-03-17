<?php
add_action("admin_menu", 'fumiki_slideshow');
add_action("admin_head", 'fumiki_slideshow_admin_head');
function fumiki_slideshow()
{
	add_submenu_page("upload.php","スライドショー設定", "スライドショー", 10, __FILE__, 'fumiki_slideshow_admin');
}

function fumiki_slideshow_admin_head()
{
	if(preg_match("/slideshow\.php/", $_SERVER["REQUEST_URI"])){ ?>
<script type="text/javascript">
//<![CDATA[
jQuery(function(){
	jQuery('.slideshow_container').click(function(e){
		e.preventDefault();
		jQuery(this).toggleClass('active');
	});

	jQuery("#fumiki_slideshow_form").submit(function(e){
		var arr = [];
		jQuery('#slideshow_wrapper .active').each(function(){
			arr.push(this.id.replace(/thumb/,""));
		});
		document.getElementById('fumiki_slideshow_value').value = arr.join(',');
		return true;
	});
});
//]]>
</script>
<style type="text/css">
<!--
.slideshow_container{
	margin:5px;
	display:block;
	float:left;
	width:100px;
	height:100px;
	overflow:hidden;
	text-align:center;
	border:#ccc 2px solid;
	opacity:0.5;
}
.slideshow_container:hover{
	opacity:1;
}
.slideshow_container.active{
	border-color:#f00;
	opacity:1;
}
-->
</style>
	<?php }
}

function fumiki_slideshow_admin()
{
	//ポスト情報を保存
	if(isset($_POST["fumiki_slideshow_value"])){
		$val = explode(",", $_POST["fumiki_slideshow_value"]);
		if(get_option("fumiki_slideshow")) update_option("fumiki_slideshow", $val);
		else add_option("fumiki_slideshow", $val);
	}
	//設定を保存
	//オプションを取得
	$slidesarr = get_option("fumiki_slideshow");
	if(empty($slidesarr)) $slidesarr = array();
?>
<div class="wrap">
	<h2>スライドショー設定</h2>
	<p>クリックしてスライドショーを有効にする</p>
	<form method="post" id="fumiki_slideshow_form" name="fumiki_slideshow_form">
		<input type="hidden" name="fumiki_slideshow_action" value="save" />
		<input type="hidden" id="fumiki_slideshow_value" name="fumiki_slideshow_value" value="<?php echo implode(",",$slidesarr); ?>"/>
		<p class="submit">
			<input id="submit" type="submit" value="設定を保存する" name="Submit" />
		</p>
	</form>
	<div id="slideshow_wrapper">
<?php
	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_mime_type' => 'image'
		); 
	$attachments = get_posts($args);
	foreach($attachments as $a){
		$is_active = (in_array($a->ID,$slidesarr)) ? ' active' : "";
		echo "<a class=\"slideshow_container{$is_active}\" href=\"#\" id=\"thumb{$a->ID}\">".wp_get_attachment_image($a->ID,'thumbnail')."</a>\n";
	}
?>
	</div>
</div>
<?php
}