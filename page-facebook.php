<?php
/*
 * Template Name:Facebook
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:mixi="http://mixi-platform.com/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php wp_title("|", true, 'right'); bloginfo('name'); ?></title>
<meta name="author" content="Takahashi Fumiki" />
<meta name="copyright" content="copyright 2008- takahashifumiki.com" />
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="高橋文樹.com 最新の投稿" />
<link rel="pingback" href="<?php bloginfo('url'); ?>/xmlrpc.php" />
<link rel="shortcut icon" href="<?php ssl_template_directory(); ?>/img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php ssl_template_directory(); ?>/style.css?version=<?php echo FUMIKI_VERSION; ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class('fan-gate-body'); ?>>
	<div id="fb-root">
		<div class="margin fan-gate">
			<?php if(have_posts()) :  while(have_posts()) :  the_post(); ?>
			<div class="meta">
				<h1 class="title mincho"><?php the_title(); ?></h1>
			</div>
			<div class="entry clearfix">
				<table>
					<tbody>
						<tr>
							<th>いいね</th>
							<td>
								<?php if(is_user_like_fangate()) :  ?>
									いいねありがとうございます！
								<?php else :  ?>
									いいねしてください…
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>Facebookへのログイン</th>
							<td>
								<?php if(is_guest_on_fangate()) :  ?>
									Facebookにログインしていません。
								<?php else :  ?>
									Facebookにログイン中です。
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>高橋文樹.comアカウント</th>
							<td>
								<?php if(is_user_logged_in()) : ?>
										高橋文樹.comにログインしています。
								<?php else : ?>
									高橋文樹.comにログインしていません。<a target="_top" href="<?php echo wp_login_url()?>">こちら</a>からログインしてください。
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>Facebookと高橋文樹.comの紐付け</th>
							<td>
								<?php if(get_user_id_on_fangate()) :  ?>
									あなたのFacebookアカウントは高橋文樹.comに登録されています。
								<?php else :  ?>
									あなたのFacebookアカウントと紐づいたユーザーは高橋文樹.comにいません。
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php if(is_user_logged_in() && get_user_id_on_fangate() && is_user_like_fangate()) :  ?>
					<p class="message success center">
						ありがとうございます！
					</p>
				<?php else :  ?>
					<p class="message warning">
						ログインしてアカウントを紐付けて「いいね！」すると、この表示が変わります。
					</p>
				<?php endif;?>
				<?php the_content();?>
			</div>
			<?php	endwhile; endif; ?>
		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>