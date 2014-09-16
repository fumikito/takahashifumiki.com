<nav id="navi" class="clearfix<?= (is_normal_archive() || is_404()) ? ' archive' : ''; ?>">
	<? if(function_exists('bcn_display')): ?>
		<div class="breadcrumb margin">
			<i class="fa-map-marker"></i>&nbsp;<?php bcn_display(); ?>
		</div>
	<? endif; ?>
</nav><!-- //#navi -->

<div id="to-top">
	<a href="#" class="tip" title="このページのトップに戻ります"><i class="fa-arrow-circle-up"></i></a>
</div>
