<?php if(!is_smartphone()): ?>
<div id="sidebar" class="dark_bg ebook">
	<?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar('電子書籍');  ?>
</div>
<?php endif; ?>