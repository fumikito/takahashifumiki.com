<?
/**
 * 関連投稿
 */
if(have_posts()):
	switch(get_post_type()):
		case 'post':
		case 'page':
			$obj = get_post_type_object(get_post_type());
?>
			<div class="related">
				<h3 class="related-links"><i class="fa-link"></i> 関連<?= $obj->labels->name; ?></h3>
				<ol class="post-list post-list-large">
					<? while (have_posts()): the_post(); ?>
						<? get_template_part('templates/loop', get_post_type()); ?>
					<? endwhile; ?>
				</ol>
			</div><!-- //.related -->
			<? break;
	endswitch;
endif;
