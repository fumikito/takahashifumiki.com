<div id="yarpp" class="related clearfix">
<?php if(get_post_type() == 'post'): ?>
<h3>&quot;<?php the_title(); ?>&quot;に関連する投稿</h3>
	<?php if(function_exists('related_posts')) related_posts(); ?>
<?php elseif(get_post_type() == 'page'):?>
<h3>&quot;<?php the_title(); ?>&quot;に関連するページ</h3>
	<?php if(function_exists('related_pages')) related_pages(); ?>
<?php endif;?>
		
<div class="google"><?php google_ads(3); ?></div>


<div class="meta">
<?php 
	switch(get_post_type()): 
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