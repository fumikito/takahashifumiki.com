<?php
if(is_search()):
include_once(TEMPLATEPATH."/archive.php");
else:
include_once(TEMPLATEPATH."/header.php");
$footerFlg = true;
?>

<div id="wrapper">


<div id="header">

<h1><?php echo $fumiki->blogTitle; ?></h1>

<div class="desc">
	<?php echo $fumiki->desc(); ?>
</div><!-- .desc ends-->

<ul>
	<li><a rel="alternate" type="application/rss+xml" href="<?php $fumiki->feed(); ?>">高橋文樹.comの最新エントリーフィード</a></li>
	<li class="search">
		<form action="<?php echo $fumiki->root; ?>" method="get" id="search" name="search">
			<div><input id="s" name="s" type="text" value="入力してください" /></div>
			<span><img alt="検索する" src="<?php echo $fumiki->template; ?>/img/body_btn_search.gif" width="37" height="27" /></span>
		</form>
	</li>
</ul>

</div><!-- #header ends -->


<div id="column1">

<ol>
	<li id="about"><a href="<?php echo $fumiki->root; ?>/about">高橋文樹について</a></li>
	<li id="inquiery"><a href="<?php echo $fumiki->root; ?>/inquiry">お問い合わせ</a></li>
</ol>

<div class="conBox clearfix">
<h2>告知</h2>
<ul>
<?php
//告知の出力
query_posts('category_name=announcement&showposts=3');
$queryCounter = 0;
while(have_posts()):$queryCounter++;  the_post(); ?>
<li<?php if($queryCounter < 2){ echo ' class="first"'; }?>>
	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<span>カテゴリ：<?php the_category(', '); ?><small class="old"><?php the_time('Y/n/d(D)'); ?></small></span>
	<?php if($queryCounter < 2){echo '<p>'.get_the_excerpt().'</p>';} ?>
</li>
<?php endwhile; ?>
</ul>
<a class="cat_top" href="<?php echo $fumiki->root; ?>/category/announcement/" title="告知の詳細">告知の詳細</a>
</div><!-- .conBox ends-->


<ul class="banner">
	<?php $fumiki->banner(2); ?>
</ul>

</div><!-- #column1 ends -->


<div id="column2">

<div class="conBox clearfix literature">
<h3>文芸活動</h3>
<ul>
<?php
//文芸活動の出力
query_posts('category_name=literature&showposts=5');
$queryCounter = 0;
while(have_posts()):$queryCounter++; the_post(); ?>
<li<?php if($queryCounter < 2){ echo ' class="first"'; }?>>
	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<span>カテゴリ：<?php the_category(', '); ?><small class="old"><?php the_time('Y/n/d(D)'); ?></small></span>
	<?php if($queryCounter < 2){echo '<p>'.get_the_excerpt().'</p>';} ?>
</li>
<?php endwhile; ?>
</ul>
<a class="cat_top" href="<?php echo $fumiki->root; ?>/category/literature/" title="文芸活動の詳細">文芸活動の詳細</a>
</div><!-- .conBox ends-->



<div class="conBox clearfix web">
<h3>ウェブ制作</h3>
<ul>
<?php
//Web制作の出力
query_posts(array('category_name' => 'web','category__not_in'=>array(47),'showposts'=>'5'));
$queryCounter = 0;
while(have_posts()):$queryCounter++; the_post(); ?>
<li<?php if($queryCounter < 2){ echo ' class="first"'; }?>>
	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<span>カテゴリ：<?php the_category(', '); ?><small class="old"><?php the_time('Y/n/d(D)'); ?></small></span>
	<?php if($queryCounter < 2){echo '<p>'.get_the_excerpt().'</p>';} ?>
</li>
<?php endwhile; ?>
</ul>
<a class="cat_top" href="<?php echo $fumiki->root; ?>/category/web/" title="ウェブ制作詳細">ウェブ制作詳細</a>
</div><!-- .conBox ends-->


<div class="conBox clearfix others">
<h3>その他雑文</h3>
<ul>
<?php
//雑記の出力
query_posts('category_name=others&showposts=5');
$queryCounter = 0;
while(have_posts()):$queryCounter++; the_post(); ?>
<li<?php if($queryCounter < 2){ echo ' class="first"'; }?>>
	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<span>カテゴリ：<?php the_category(', '); ?><small class="old"><?php the_time('Y/n/d(D)'); ?></small></span>
	<?php if($queryCounter < 2){echo '<p>'.get_the_excerpt().'</p>';} ?>
</li>
<?php endwhile; ?>
</ul>
<a class="cat_top" href="<?php echo $fumiki->root; ?>/category/others/" title="その他雑文">その他雑文の詳細</a>
</div><!-- .conBox ends-->


</div><!-- #column2 ends-->



<div id="column3">
<div id="tag_clouds">
	<?php st_tag_cloud(array('cloud_section'=> 'random',
                             'title'        => '',
							 'xformat'      => __('<a href="%tag_link%" title="%tag_count% topics" %tag_rel% style="%tag_size% %tag_color%">%tag_name%</a>', 'simpletags'))); ?>
</div>
</div><!-- #column3 ends-->

</div><!-- wrapper ends -->
<?php
require_once(TEMPLATEPATH."/footer.php");
endif;//ref lj.1
?>
