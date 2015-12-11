<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
global $theme_my_login;
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php if(isset($theme_my_login->errors->error_data) && array_key_exists('reauth', $theme_my_login->errors->error_data)) :  ?>
		<p class="message notice">
			高橋文樹.comで電子書籍を購入するには、ログインをする必要があります。
			はじめての方は<?php wp_register('', ''); ?>をお願いいたします。
		</p>
	<?php else :  ?>
		<?php $template->the_errors(); ?>
	<?php endif; ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="user_login<?php $template->the_instance(); ?>">メールアドレス</label></th>
					<td><input type="<?php attr_email(); ?>" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" /></td>
				</tr>
				<tr>
					<th><label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Password', 'theme-my-login' ) ?></label></th>
					<td><input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>
						<p class="forgetmenot">
							<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
							<label for="rememberme<?php $template->the_instance(); ?>"><?php _e( 'Remember Me', 'theme-my-login' ); ?></label>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
<?php
do_action( 'login_form' ); // Wordpress hook
do_action_ref_array( 'tml_login_form', array( &$template ) ); // TML hook
?>
		
		<p class="center">
			<input class="button-primary" type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="ログインする" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="testcookie" value="1" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'login' => false ) ); ?>
</div>