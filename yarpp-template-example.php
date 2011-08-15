<?php /*
Example template
Author: mitcho (Michael Yoshitaka Erlewine)
*/
?>
<div id="yarpp" class="related clearfix">
<h3>&quot;<?php the_title(); ?>&quot;に関連する投稿</h3>

<div class="google">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-0087037684083564";
	/* 高橋文樹.com2011関連投稿 */
	google_ad_slot = "0384965250";
	google_ad_width = 336;
	google_ad_height = 280;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>

<?php if(get_post_type() != "page"): ?>

	<?php if ($related_query->have_posts()):?>
	<ol>
		<?php while ($related_query->have_posts()) :  $related_query->the_post(); ?>
		<li>
			<span class="mono"><?php the_date('Y.m.d'); ?></span>
			<a class="button" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?><small>（関連度：<?php the_score(); ?>）</small></a>
			カテゴリー: <?php the_category(','); ?><br />
			<?php the_tags("タグ: ")?>
		</li>
		<?php endwhile; ?>
	</ol>
	<?php else: ?>
	<?php
		$cats = get_the_category();
		$cat = current($cats);
		query_posts("showposts=3&cat={$cat->term_id}");
		if(have_posts()):
	?>
		<ol>
		<?php while(have_posts()): the_post(); ?>
			<li>
				<span class="mono"><?php the_date('Y.m.d'); ?></span>
				<a class="button" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
				カテゴリー: <?php the_category(','); ?><br />
				<?php the_tags("タグ: ")?>
			</li>
		<?php endwhile;wp_reset_query();?>
		</ol>
		<?php else: ?>
		<p>関連する投稿はありませんでした</p>
		<?php endif; ?>

	<?php endif; ?>
<?php else:?>
	<?php
		global $post;
		$related = array();
		if($post->post_parent == 0){
			$children = get_children("post_parent={$post->ID}&post_type=page");
			foreach($children as $child){
				$related[] = $child->ID;
			}
		}else{
			$related[] = $post->post_parent;
		}
		if(empty($related)):
		?>
		<p>関連する記事はありません。</p>
		<?php
			else:
		?>
		<ol>
			<?php query_posts(array('post__in' => $related, 'post_type' => 'page')); while(have_posts()): the_post(); ?>
			<li>
				<span class="mono"><?php the_date('Y.m.d'); ?></span>
				<a class="button" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
			</li>		
			<?php endwhile;wp_reset_query(); ?>
		</ol>
		<?php
		endif;
	?>
<?php endif; ?>
</div><!--#related_post-->