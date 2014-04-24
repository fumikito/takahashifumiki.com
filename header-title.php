


<header class="margin header">
		
	<? $title = fumiki_title(); ?>
	<h1 class="title">
		<?= $title; ?>
	</h1>
	
	<?php if((is_archive() && !is_post_type_archive('ebook')) || is_search()):?>
		<div class="calendar shadow">
			<span class="date">Found</span>
			<span class="year"><?php global $wp_query;  echo number_format($wp_query->found_posts); ?></span>
		</div>
	<?php endif; ?>


	<?php if(is_singular('post')): ?>
		<?php get_template_part('templates/meta-'.  get_post_type()); ?>
	<?php endif; ?>

</header><!-- header -->


<? if(!is_ssl() && is_smartphone()): ?>
<p class="center">
	<?	google_ads(7); ?>
</p>
<? endif; ?>