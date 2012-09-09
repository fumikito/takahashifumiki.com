<? if(!is_smartphone()): ?>
<div class="share clrB clearfix">
	<p class="prev"><? previous_post_link('%link');?></p>
	<p class="next"><? next_post_link('%link'); ?></p>
	<h3 class="mono">Share This: <small>この<?= get_post_type_object(get_post_type())->labels->name; ?>が気に入ったら、ぜひシェアしてください。</small></h3>
	<? fumiki_share(get_the_title()."|".get_bloginfo('name'), get_permalink()); ?>
</div>
<? endif; ?>