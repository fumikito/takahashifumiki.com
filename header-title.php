


<header class="margin header">
		
	<? $title = fumiki_title(); ?>
	<h1 class="title mincho<? if(mb_strlen($title, 'utf-8') <= 20) echo ' center'; ?>">
		<? if(is_singular('ebook')): ?>
			<strong class="sans">【高橋文樹の電子書籍】</strong>
		<? elseif(is_singular('events')): ?>
			<strong class="sans">［イベント］</strong>
		<? endif; ?>
		<?= $title; ?>
	</h1>
	
	<?php if((is_archive() && !is_post_type_archive('ebook')) || is_search()):?>
		<div class="calendar shadow">
			<span class="date">Found</span>
			<span class="year"><?php global $wp_query;  echo number_format($wp_query->found_posts); ?></span>
		</div>
	<?php endif; ?>


	<?php if(is_singular('post')): ?>
		<div class="calendar">
			<?php
				$date = explode(',', mysql2date('M,jS,D,Y,', $post->post_date, false));
				printf('<span class="date">%1$s %2$s (%3$s)</span><span class="year">%4$s</span>', $date[0], $date[1], $date[2], $date[3]); 
			?>
		</div>
		<?php get_template_part('templates/meta-'.  get_post_type()); ?>
	<?php endif; ?>

</header><!-- header -->


<? if(!is_ssl() && is_smartphone()): ?>
<p class="center">
	<?	google_ads(7); ?>
</p>
<? endif; ?>