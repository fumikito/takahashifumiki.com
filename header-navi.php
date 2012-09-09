<? if(!is_smartphone() || is_front_page()): ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=264573556888294";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<? endif; ?>

<div id="navi" class="clearfix">
	<?php if(is_front_page()): ?>
	<ul class="recent-posts-top">
		<?php $recent_query = new WP_Query(array(
			'post_status' => 'publish',
			'posts_per_page' => 5,
			'post_type' => array('post', 'page', 'ebook', 'events')
		)); $counter = 0; while($recent_query->have_posts()): $recent_query->the_post(); $counter++;?>
		<li>
			<strong>【更新情報：<?php echo get_post_type_object(get_post_type())->labels->name; ?>】</strong>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<small>（<?php echo human_time_diff(strtotime(get_the_date('Y-m-d H:i:s')));?>前）</small>
		</li>
		<?php endwhile;?>
	</ul>
	<?php else: ?>
		<?php if(function_exists('bcn_display')): ?>
			<div class="breadcrumb">
				<i>&nbsp;</i><?php bcn_display(); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div><!-- //#navi -->
