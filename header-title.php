


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
		<div class="calendar shadow">
			<?php
				$date = explode(',', mysql2date('M,jS,D,Y,', $post->post_date, false));
				printf('<span class="date">%1$s %2$s (%3$s)</span><span class="year">%4$s</span>', $date[0], $date[1], $date[2], $date[3]); 
			?>
		</div>
	<?php endif; ?>
	
	

		
	<?php if(is_singular() && !is_ssl()): ?>
	
		<? if(is_singular('ebook')): ?>
		<div class="excerpt">
			<? the_excerpt(); ?>
		</div>
		<? endif; ?>

		<div class="title-meta clearfix<? if(is_singular('ebook')) echo ' ebook-detail'; ?>">
			<div class="google center">
				<? if(is_singular('ebook')): ?>
				<img class="cover" src="<?php echo ebook_cover_src(); ?>" alt="<?php the_title(); ?>" width="240" height="320" />
					<? if(lwp_on_sale()): ?>
						<img class="on-sale" src="<?php bloginfo('template_directory'); ?>/styles/img/icon-sale-48.png" width="48" height="48" alt="On Sale" />
					<? endif; ?>
				<? elseif(!is_smartphone()): ?>
					<? google_ads(3); ?>
				<? endif; ?>
			</div>
			<? if(is_page()){
				get_template_part('templates/meta-post');
			}else{
				get_template_part('templates/meta-'.  get_post_type());
			} ?>
		</div>
	<?php endif ?>
</header><!-- header -->


<? if(!is_ssl() && is_smartphone()): ?>
<p class="center">
	<?	google_ads(5); ?>
</p>
<? endif; ?>