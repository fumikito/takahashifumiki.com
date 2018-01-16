<?php
/**
 * Newsletter
 */

add_shortcode( 'mailchimp', function ( $atts = [], $contnet = '' ) {
    ob_start();
    ?>
    <!-- Begin MailChimp Signup Form -->
    <div id="mc_embed_signup">
        <form
            action="<?= esc_attr( add_query_arg( [
				'u'  => '9b5777bb4451fb83373411d34',
				'id' => 'bf9c92d04a',
				'REGISTERED' => urlencode( date_i18n( 'Y-m-d' ) ),
				'SOURCE' => urlencode( 'takahashifumiki.com' ),
			], 'https://takahashifumiki.us14.list-manage.com/subscribe/post' ) )?>"
            method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
            target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
                <h2>ニュースレターのご購読</h2>
                <p class="description"><span class="asterisk text-danger">*</span> は必須項目です。</p>
                <div class="form-group">
                    <label for="mce-EMAIL">メール <span class="asterisk text-danger">*</span>
                    </label>
                    <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" placeholder="ex. info@takahashifumiki.com">
                </div>
                <div class="form-group">
                    <label for="mce-FNAME">お名前 </label>
                    <input type="text" value="" name="FNAME" class="form-control" id="mce-FNAME" placeholder="ex. 高橋文樹">
                </div>
                <div class="form-group">
                    <label for="mce-MMERGE2">会社・団体 </label>
                    <input type="text" value="" name="MMERGE2" class="form-control" id="mce-MMERGE2" placeholder="ex. 株式会社破滅派">
                </div>
                <div class="form-group">
					<div class="radio">
						<label for="mce-MMERGE3-0"><input type="radio" value="出版関連" name="MMERGE3" id="mce-MMERGE3-0">出版関連</label>
					</div>
					<div class="radio">
						<label for="mce-MMERGE3-1"><input type="radio" value="Web関連" name="MMERGE3" id="mce-MMERGE3-1">Web関連</label>
					</div>
					<div class="radio">
						<label for="mce-MMERGE3-2"><input type="radio" value="学生" name="MMERGE3" id="mce-MMERGE3-2">学生</label>
					</div>
					<div class="radio">
						<label for="mce-MMERGE3-3"><input type="radio" value="その他" name="MMERGE3" id="mce-MMERGE3-3">その他</label>
					</div>
                </div>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div style="position: absolute; left: -5000px;" aria-hidden="true">
					<input type="text" name="b_9b5777bb4451fb83373411d34_bf9c92d04a" tabindex="-1" value="">
				</div>
                <p class="text-center">
					<input type="submit" value="購読する" name="subscribe" id="mc-embedded-subscribe"
                                          class="btn btn-raised btn-lg btn-primary">
				</p>
				<aside>
					※フォームを送信すると、Mailchimpというサービスに移動します。
				</aside>
            </div>
        </form>
    </div>
    <!--End mc_embed_signup-->
    <?php
    $form = ob_get_contents();
    ob_end_clean();

    return implode( "\n", array_filter( array_map( function ( $line ) {
        return trim( $line );
    }, explode( "\n", $form ) ) ) );
} );