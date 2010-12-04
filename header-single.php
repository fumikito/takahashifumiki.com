<div id="header" class="clearfix">
	<a id="logo" rel="home" href="<?php bloginfo("url"); ?>"><?php bloginfo("name"); ?></a>
	<div id="message"><p class="center"><?php do_echo(); ?></p></div>
	<ul id="account" class="clearfix">
		<?php if(is_user_logged_in()): ?>
		<li><a href="<?php echo admin_url(); ?>profile.php?page=lwp-history"><img src="<?php bloginfo("template_directory"); ?>/img/account_history.jpg" alt="購入履歴" title="購入履歴"/></a></li>
		<li><a href="<?php echo admin_url(); ?>profile.php"><img src="<?php bloginfo("template_directory"); ?>/img/account_profile.jpg" alt="登録情報" title="登録情報"/></a></li>
		<li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><img src="<?php bloginfo("template_directory"); ?>/img/account_logout.jpg" alt="ログアウト" title="ログアウト"/></a></li>
		<?php else: ?>
		<li><a href="<?php bloginfo("url"); ?>/wp-register.php"><img src="<?php bloginfo("template_directory"); ?>/img/account_register.jpg" alt="新規登録" title="新規登録"/></a></li>
		<li><a href="<?php bloginfo("url"); ?>/wp-login.php?redirect_to=<?php echo rawurlencode(get_permalink()); ?>"><img src="<?php bloginfo("template_directory"); ?>/img/account_login.jpg" alt="ログイン" title="ログイン"/></a></li>
		<?php endif; ?>
	</ul>
	<div id="breadcrumb">
		<?php if(function_exists('bcn_display')) bcn_display(); ?>
	</div>
	<a id="toTop"></a>
</div>
<!-- #header ends-->
