<? if(is_singular()): ?>
	<?
	//関連投稿
	switch(get_post_type()):
		case 'post':
		case 'page':
			$obj = get_post_type_object(get_post_type());
			?>
			<div class="related">
				<h3 class="related-links"><i class="fa-link"></i> 関連<?= $obj->labels->name; ?></h3>
				<? if(function_exists('related_posts')) related_posts(); ?>
			</div>
			<? break; endswitch; ?>
<? endif; ?>