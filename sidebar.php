<?php if(!is_smartphone()): ?>
<div id="sidebar" class="dark_bg">
	<?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar('通常投稿');  ?>
</div>
<?php endif; ?>