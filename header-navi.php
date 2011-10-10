<div id="navi">
	<div class="margin clearfix">
		<div class="grid_4">
			<?php if(is_user_logged_in()): global $user_ID, $user_email, $user_identity; ?>
			<p class="mono">You are logged in</p>
			<div class="user_box">
				<?php echo get_avatar($user_email, 48); ?>
				<p class="user-name"><?php echo $user_identity; ?>さん</p>
				<p class="greet clrB">
					こんにちは。お越しいただけて嬉しいです。最後にログインしたのは<?php echo get_last_login(); ?>ですね。これからもまた来てください。
				</p>
				<p>
					<a class="button" href="<?php bloginfo('url'); ?>/book-shelf/">本棚</a>
					<?php if(current_user_can('edit_others_posts')): ?>
						<a class="button" href="<?php echo admin_url(); ?>">管理画面</a>
					<?php else: ?>
						<a class="button" href="<?php echo wp_login_url(); ?>?action=profile">登録情報</a>
					<?php endif; ?>
					<a class="button" href="<?php echo wp_logout_url(); ?>">ログアウト</a>
				</p>
			</div>
			<?php else: ?>
			<p class="mono">Welcom, Guest!</p>
				<?php echo get_avatar(1, 48); ?>
				<p class="user-name">ようこそ!</p>
				<p class="greet clrB">
					高橋文樹.comではユーザー登録を受け付けています。登録をすることで、電子書籍の購入やお得な更新情報が手に入ります。
						<?php echo admin_url(); ?>
				</p>
				<p>
					<a class="button" href="<?php echo wp_login_url(); ?>">ログイン</a>
					<?php echo preg_replace("/<a/", "<a class=\"button\"", wp_register('','',false)); ?>
				</p>
			<?php endif;?>
		</div>
		<div class="grid_4">
			<p class="mono">Description</p>
			<p class="description">
				<?php bloginfo('description'); ?>
			</p>
			<p class="mono">Topics</p>
			<p><?php wp_tag_cloud('smallest=8&largest=14&unit=px&number=20&order=RAND'); ?></p>
		</div>
		<div class="grid_4">
			<p class="mono">Main Pages</p>
			<?php wp_nav_menu(array( 'theme_location' => 'main-pages','container_class' => 'main-page')); ?>
		</div>
		<div class="grid_4">
			<p class="mono">Categories</p>
			<ul>
				<?php wp_list_cats("show_count=0&depth=1&hierarchical=1&exclude=47"); ?>
			</ul>
		</div>
	</div>
</div>

<div id="header" class="margin dark_bg">
	<div id="logo">
		<a rel="home" href="<?php bloginfo('url')?>">
			<img src="<?php bloginfo('template_directory')?>/img/header-logo.png" alt="<?php bloginfo('name'); ?>" width="380" height="40" />
		</a>
		<p class="shadow"><?php $desc = explode("。", get_bloginfo("description")); echo $desc[0]; ?></p>
	</div>
	<a class="button mono" href="#navi">Menu</a>
	<div id="search">
		<form method="get" action="<?php bloginfo('url'); ?>">
			<input type="text" class="tooltip" title="キーワードを入力したらEnterを教えて下さい。" name="s" id="s" value="検索キーワード..." onfocus="this.value='';" onblur="if(this.value == '') this.value='検索キーワード...';" />
		</form>
	</div>
</div>