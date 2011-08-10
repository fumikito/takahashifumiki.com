<?php
the_post();
/****************************
 * MooToolsのときだけテンプレ変更
 ****************************/
if(in_category(47)):
	include_once(TEMPLATEPATH."/mootools/moo.php");
else:
/****************************
 * 通常
 ****************************/

get_header('meta');
get_header('navi');
get_header('title');

get_footer();
endif;//Mootoolsと通常single.phpの分岐終了