<div id="yarpp" class="related clearfix">
<?php if(get_post_type() == 'post'): ?>
<h3>&quot;<?php the_title(); ?>&quot;に関連する投稿</h3>
	<?php if ($related_query->have_posts()):?>
		<ol>
			<?php while ($related_query->have_posts()) :  $related_query->the_post(); ?>
			<li class="clearfix">
				<div class="thumb">
					<a href="<?php the_permalink(); ?>"><?php fumiki_archive_photo("thumbnail"); ?></a>
				</div>
				<div class="score">
					関連度<br />
					<small class="old"><?php echo (get_the_score() * 10); ?>%</small>
				</div>
				<div class="detail">
					<span class="mono"><?php the_date('Y.m.d'); ?></span><br />
					<a class="more" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><br />
					<p><?php echo mb_substr(get_the_excerpt(), 0, 60, 'utf-8'); ?>[...] </p>
				</div>
			</li>
			<?php endwhile; ?>
		</ol>
	<?php else:?>
		<p class="message warning">
			関連する投稿はありませんでした。
		</p>
	<?php endif; ?>
<?php elseif(get_post_type() == 'page'):?>
<h3>&quot;<?php the_title(); ?>&quot;に関連するページ</h3>
<?php
	$pages = get_children("post_parent={$post->ID}&post_type=page&post_status=publish");
	if($post->post_parent > 0){
		$parent = get_page($post->post_parent);
		$pages[] = $parent;
		$cousins = get_children("post_parent={$parent->ID}&post_type=page&post_status=publish");
		foreach($cousins as $cousin){
			if($cousin->ID != $post->ID){
				$pages[] = $cousin;
			}
		}
	}
	if(!empty($pages)):
?>
		<ol>
			<?php foreach($pages as $page): ?>
			<li class="clearfix">
				<div class="thumb">
					<a href="<?php echo get_permalink($page->ID); ?>"><?php fumiki_archive_photo("thumbnail", $post); ?></a>
				</div>
				<div class="detail">
					<span class="mono"><?php echo mysql2date('Y.m.d', $page->post_date, false); ?></span><br />
					<a class="more" href="<?php echo get_permalink($page->ID) ?>" rel="bookmark"><?php echo apply_filters('the_title', $page->post_title); ?></a>
					<p><?php
						$excerpt = empty($page->post_excerpt) ? strip_tags(apply_filters('the_content', $page->post_content)) : $page->post_excerpt;
						echo mb_substr(apply_filters('get_the_excerpt', $excerpt), 0, 60, 'utf-8'); 
					?>[...] </p>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
	<?php else: ?>
		<p class="message warning">
			関連するページはありませんでした。
		</p>
	<?php endif; ?>
<?php endif;?>
		
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


<div class="meta">
<?php switch(get_post_type()): 
	case 'post': $current = ""; foreach(get_the_category() as $cat){ if($cat->category_parent == 0){ $current = $cat->name; break;}} ?>
	<h4>投稿カテゴリーについて</h4>
	<p>
		この投稿のカテゴリ<?php the_category(', '); ?>にはこの投稿と似た話題の記事があります。<br />
		このカテゴリー以外の話題として<?php foreach(array('告知', '文芸活動', 'Web制作', 'その他') as $cat): if($cat != $current): ?>、<a href="<?php echo get_category_link(get_cat_ID($cat)); ?>"><?php echo $cat;?></a><?php endif; endforeach;?>があります。
	</p>
	<h4>キーワードについて</h4>
	<p>この投稿に含まれるキーワード（<?php the_tags(''); ?>）を持つ投稿は内容が似ているかも知れません。</p>
	<h4>その他</h4>
	<p><a href="#footer">フッター</a>に最新投稿および人気記事のリストがあります。参考にしてください。</p>
	<?php break;
	case 'page': ?>
	<h4>主要ページ</h4>
	<p>高橋文樹.comの主要なページは<a href="#footer-nav">フッター</a>に記載しています。ぜひご一読ください。</p>
	<h4>キーワード</h4>
	<p>
		高橋文樹.comで扱っている主要な話題はこちらです。
	</p>
	<p><?php wp_tag_cloud('smallest=8&largest=14&unit=px&number=20&order=RAND'); ?></p>
	<?php break;
	case 'ebook':
		break;
endswitch;?>
</div>			

</div><!--#related_post-->