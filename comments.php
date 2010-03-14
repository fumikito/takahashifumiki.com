<div id="comments_wrapper">
<?php
/**
 * 直接読み込まれた場合の処理
 */
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {

?>
	<p class="nocomments">この投稿はパスワードによって保護されています。<p>
<?php
}
/***********************
 * コメントループの開始
 ***********************/
if(have_comments()): ?>



<h3 class="comment_header mincho"><small class="old"><?php comments_number('0','1','%'); ?></small><span><?php the_title(); ?></span>へのコメント</h3>
<ul id="comment_wrapper" class="clrL">
<?php
//コメントの取得
wp_list_comments('style=ul&type=comment&callback=fumiki_comment_layout');
?>
</ul>
<?php previous_comments_link(); ?>
<?php next_comments_link(); ?>

<?php else:
/**************************
 * コメントがないとき
 *************************/
if('open' == $post->comment_status): ?>

<?php
/**************************
 * コメントが禁止されているとき
 *************************/
else: ?>
だめだわ。

<?php endif; endif;//ref17,35
/***********************
 * コメントループの終了
 ***********************/

/************************
 * トラックバックエリア
 ***********************/
?>

<div id="trackback">
<h3>トラックバック</h3>
<?php if(!fumiki_get_tb($post->ID)): ?>
<p>トラックバックはありません。送ってください。</p>
<?php endif; ?>
<div class="tburl">
<label>トラックバックURI<input type="input" readonly="readonly" value="<?php trackback_url(); ?>" onclick="this.selected = true;" /></label>
</div>
</div><!-- #trackback-->

<?php
/************************
 * コメントが投稿できるときだけフォームを表示
 ***********************/
if ('open' == $post->comment_status) :
?>


<div id="respond">
<form action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post" id="commentform">
<fieldset>
<legend><img src="<?php bloginfo('template_directory'); ?>/img/single_comment_legend.png" alt="<?php comment_form_title('コメント投稿','%s に返信'); ?>" /></legend>
<div id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></div>
<?php
/*
 * ログインしているユーザだったら
 * */
if ( $user_ID ) :
 ?>

<p id="loginName">
<strong><?php echo $user_identity; ?></strong>として<a href="<?php echo $fumiki->root; ?>/wp-admin/profile.php">ログイン</a>中。<br />
<a href="<?php wp_logout_url(get_permalink()); ?>">ログアウト &raquo;</a>
</p>

<?php
/*
 * ログインしていなかったら
 * */
else : ?>

<label>
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" />
	名前 <?php if ($req) echo '(必須)<small>※公開はされません</small>';; ?>
</label>

<label>
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
	Eメール <?php if ($req) echo '(必須)<small>※公開はされません</small>'; ?>
</label>

<label>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
	Webサイト
</label>

<?php
/*
 * ユーザ認証終わり(ref.65)
 * */
endif; ?>

<label id="comment_label" for="comment">ここにコメントを書いてください</label>
<textarea name="comment" id="comment"></textarea>

<input name="submit" type="image" src="<?php bloginfo('template_directory'); ?>/img/single_comment_submit.gif" id="submit" value="投稿する" />
<?php
comment_id_fields();
do_action('comment_form', $post->ID); ?>
</fieldset>
</form>
</div><!-- respond ends -->
<?php endif; /*ref52*/ ?>

<?php fumiki_to_top(); ?>

</div><!-- #comment_wrapper ends-->