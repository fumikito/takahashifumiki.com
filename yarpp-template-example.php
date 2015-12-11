<?
/**
 * 関連投稿
 */
if( have_posts() ) :
	switch( get_post_type() ) :
		case 'post':
		case 'page':
			$obj = get_post_type_object( get_post_type() );
?>
			<div class="related">
				<h2 class="related-links"><i class="fa fa-link"></i> 関連<?= $obj->labels->name; ?></h2>
				<ol class="post-list post-list-large">
					<?php while( have_posts() ) :  the_post(); ?>
						<?php get_template_part('templates/loop', get_post_type()); ?>
					<?php endwhile; ?>
				</ol>
			</div><!-- //.related -->
			<?php break;
	endswitch;
endif;
