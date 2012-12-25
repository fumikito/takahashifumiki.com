<nav id="navi" class="clearfix<?= (is_normal_archive() || is_404()) ? ' archive' : ''; ?>">
	<? if(is_normal_archive() || is_404()): ?>
	<header class="margin">
		<p class="location"><i class="icon-map-marker"></i><?php bcn_display(); ?></p>
		<h1>
			<? global $wp_query; ?>
			<small class="count"><i class="icon-search"></i><?= number_format($wp_query->found_posts); ?></small>
			<?= fumiki_title(); ?>
		</h1>
		<?
			wp_pagenavi();
			get_search_form();
		?>
	</header>
	<? else: ?>
		<? if(function_exists('bcn_display')): ?>
			<div class="breadcrumb">
				<i class="icon-map-marker"></i>&nbsp;<?php bcn_display(); ?>
			</div>
		<? endif; ?>
	<? endif; ?>
</nav><!-- //#navi -->

<div id="to-top">
	<a href="#" class="tip" title="このページのトップに戻ります"><i class="icon-circle-arrow-up"></i></a>
</div>

<? if(!is_ssl() && is_smartphone() && (is_archive() || is_search())): ?>
<p class="center">
	<?	google_ads(5); ?>
</p>
<? endif; ?>