<?php if(!is_smartphone()): ?>
<div class="desc-parts ebook-desc-parts clearfix">
	<?php if ( function_exists('dynamic_sidebar')) dynamic_sidebar('電子書籍');  ?>
</div>
<?php endif; ?>