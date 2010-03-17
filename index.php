<?php
if(is_search()):
include_once(TEMPLATEPATH."/archive.php");
else:
get_header();
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

<ol class="clearfix">
	<?php
		$globalnavi = get_global_navi();
		query_posts(array("post__in"    => $globalnavi,
		                  "post_type"   => "page",
		                  "order_by"    => "ID",
		                  "order"       => "ASC",
		                  "post_status" => "publish"));
		if(have_posts()): while(have_posts()): the_post();
	?>
	<li><a class="mincho" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; endif; ?>
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
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<span>カテゴリ：<?php the_category(', '); ?><small class="old"><?php the_time('Y/n/d(D)'); ?></small></span>
	<?php if($queryCounter < 2){echo '<p>'.get_the_excerpt().'</p>';} ?>
</li>
<?php endwhile; ?>
</ul>
<a class="cat_top" href="<?php echo $fumiki->root; ?>/category/announcement/" title="告知の詳細">告知の詳細</a>
</div><!-- .conBox ends-->


<ul class="banner">
	<?php
		wp_list_bookmarks("categorize=0&category_name=バナー&title_li=&category_before=&category_after=");
	?>
</ul><!-- banner ends-->

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

<div id="container">
	<ul id="gradually-container" class="gradually">
		<?php
		$slides = get_posts(array('post_type' => 'attachment',
		                          'post__in' => get_option("fumiki_slideshow"),
		                          'post_mime_type' => 'image'));
		foreach($slides as $s){
			$data = wp_get_attachment_image_src($s->ID,'full');
			echo "<li><img src=\"{$data[0]}\" alt=\"{$s->post_excerpt}\" title=\"{$s->post_title}\" width=\"{$data[1]}\" height=\"{$data[2]}\" /></li>\n";
		}
		?>
	</ul>
	<p class="information"></p>
</div>
<!-- #container ends -->

<div class="youtube">
<?php echo fumiki_youtube(340,180);?>
</div>
<!-- .youtube ends -->

<div id="hatena">
	<script language="javascript" type="text/javascript" src="http://b.hatena.ne.jp/js/widget.js" charset="utf-8"></script>
	<script language="javascript" type="text/javascript">
	//<![CDATA[
		Hatena.BookmarkWidget.url   = "http://takahashifumiki.com";
		Hatena.BookmarkWidget.title = "エントリー";
		Hatena.BookmarkWidget.sort  = "hot";
		Hatena.BookmarkWidget.width = 0;
		Hatena.BookmarkWidget.num   = 5;
		Hatena.BookmarkWidget.theme = "notheme";
		Hatena.BookmarkWidget.load();
	//]]>
	</script>
</div>
<!-- #hatena ends -->

<div class="tweet">
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	//<![CDATA[
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: 3,
		  interval: 3000,
		  width: 300,
		  height: 175,
		  theme: {
		    shell: {
		      background: '#ffffff',
		      color: '#009fe9'
		    },
		    tweets: {
		      background: '#ffffff',
		      color: '#999999',
		      links: '#4d4945'
		    }
		  },
		  features: {
		    scrollbar: true,
		    loop: false,
		    live: true,
		    hashtags: true,
		    timestamp: true,
		    avatars: true,
		    behavior: 'all'
		  }
		}).render().setUser('takahashifumiki').start();
	//]]>
	</script>
</div>

<div id="column3">
<?php st_tag_cloud(array('cloud_selection'=> 'random',
                             'title'        => '',
							 'xformat'      => __('<a href="%tag_link%" title="%tag_count% topics" %tag_rel% style="%tag_size% %tag_color%">%tag_name%</a>', 'simpletags'))); ?>
</div><!-- #column3 ends-->

</div><!-- wrapper ends -->
<?php
get_footer();
endif;//ref lj.1
?>
