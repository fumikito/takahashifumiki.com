<nav id="navi" class="clearfix<?= (is_normal_archive() || is_404()) ? ' archive' : ''; ?>">
	<? if(function_exists('bcn_display')): ?>
		<div class="breadcrumb margin">
			<i class="fa-map-marker"></i>&nbsp;<?php bcn_display(); ?>
		</div>
	<? endif; ?>
	<? if(is_normal_archive() || is_404()): ?>
	<header class="margin">
		<h1>
			<? global $wp_query; ?>
			<?= fumiki_title(); ?>
			<small class="count"><i class="fa-search"></i><?= number_format($wp_query->found_posts); ?></small>
		</h1>
		<?
			get_search_form();
		?>
	</header>
	<? endif; ?>
</nav><!-- //#navi -->

<div id="to-top">
	<a href="#" class="tip" title="このページのトップに戻ります"><i class="fa-arrow-circle-up"></i></a>
</div>

<? if(!is_ssl() && is_smartphone() && (is_archive() || is_search())): ?>
<p class="center">
	<?	google_ads(5); ?>
</p>
<? endif; ?>