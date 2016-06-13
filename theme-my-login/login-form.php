<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
global $theme_my_login;
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php if(isset($theme_my_login->errors->error_data) && array_key_exists('reauth', $theme_my_login->errors->error_data)) :  ?>
		<div class="alert alert-notice">
			高橋文樹.comで電子書籍を購入するには、ログインをする必要があります。
			はじめての方は<?php wp_register( '', '' ); ?>をお願いいたします。
		</div>
	<?php else :  ?>
		<?php $template->the_errors(); ?>
	<?php endif; ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
				<div class="form-group">
					<label for="user_login<?php $template->the_instance(); ?>">メールアドレス</label>
					<input type="<?php attr_email(); ?>" name="log" id="user_login<?php $template->the_instance(); ?>" class="form-control" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
				</div>
				<div class="form-group">
					<label for="user_pass<?php $template->the_instance(); ?>">パスワード</label>
					<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="form-control" value="" size="20" />
				</div>
				<div class="checkbox">
					<label for="rememberme<?php $template->the_instance(); ?>">
						<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>"
						       value="forever"/>
						次回から自動でログイン
					</label>
				</div>
<?php
do_action( 'login_form' ); // Wordpress hook
do_action_ref_array( 'tml_login_form', array( &$template ) ); // TML hook
?>
		
		<p class="text-center">
			<input class="btn btn-primary btn-raised btn-lg" type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="ログインする" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="testcookie" value="1" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'login' => false ) ); ?>
</div>