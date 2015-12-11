<?php
include_once(TEMPLATEPATH.'/mootools/moo_header.php');
/****************************************
 * ダウンロードページとの分岐
 ****************************************/

if(is_single('294')) :
	include(TEMPLATEPATH."/mootools/download.php");
else :
?>
<!--main-menu starts-->
<div id="main-menu" class="span-4">
<h4>Core</h4>
<ul><?php
	$moo_core = new WP_Query('category_name=core&order=ASC');
	while ($moo_core->have_posts()) : $moo_core->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Native</h4>
<ul><?php
	$moo_native = new WP_Query('category_name=native&showposts=6&order=ASC');
	while ($moo_native->have_posts()) : $moo_native->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Class</h4>
<ul><?php
	$moo_class = new WP_Query('category_name=class&order=ASC');
	while ($moo_class->have_posts()) : $moo_class->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Element</h4>
<ul><?php
	$moo_element = new WP_Query('category_name=element&order=ASC');
	while ($moo_element->have_posts()) : $moo_element->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Utilities</h4>
<ul><?php
	$moo_utilities = new WP_Query('category_name=utilities&order=ASC');
	while ($moo_utilities->have_posts()) : $moo_utilities->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Fx</h4>
<ul><?php
	$moo_fx = new WP_Query('category_name=fx&order=ASC');
	while ($moo_fx->have_posts()) : $moo_fx->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Request</h4>
<ul><?php
	$moo_request = new WP_Query('category_name=request&order=ASC');
	while ($moo_request->have_posts()) : $moo_request->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>Plugins</h4>
<ul><?php
	$moo_plugins = new WP_Query('category_name=plugins&showposts=15&order=ASC');
	while ($moo_plugins->have_posts()) : $moo_plugins->the_post();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<h4>翻訳者について</h4>
<ul>
<li><a href="<?php bloginfo('url'); ?>/about">高橋文樹について</a></li>
<li><a href="<?php bloginfo('url'); ?>/about/history">略歴</a></li>
<li><a href="<?php bloginfo('url'); ?>/about/translation">翻訳プロジェクト</a></li>
</ul>
</div><!--main-menu ends-->

<?php
	$moo_id = split('/',$_SERVER['REQUEST_URI']);
	$moo_id = $moo_id[count($moo_id) - 2];
	echo get_post($moo_id)->post_content;
?>

<?php
/****************************************
 * ダウンロードページとの分岐終わり
 ****************************************/
endif;
include_once(TEMPLATEPATH.'/mootools/moo_footer.php');
?>