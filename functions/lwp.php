<?php
/*
 * LWPに対応したファイル
 */

/**
 * 
 * @global Literally_WordPress $lwp
 * @global wpdb $wpdb
 * @param int $transaction_id
 */
function _fumiki_lwp_transaction($transaction_id){
	global $lwp, $wpdb;
	$transaction = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$lwp->transaction} WHERE ID = %d AND status = %s",
			$transaction_id, LWP_Payment_Status::WAITING_CANCELLATION));
	if($transaction && ($userdata = get_userdata($transaction->user_id))){
		$message = <<<EOS

 キャンセル待ち受け付けメッセージ

EOS;
		wp_mail($userdata->user_email, '高橋文樹.com::キャンセル待ちを受け付けました', $message, "From: 高橋文樹.com <info@takahashifumiki.com>");
	}
}
//add_action('lwp_create_transaction', '_fumiki_lwp_transaction');

/**
 * 
 * @global Literally_WordPress $lwp
 * @param int $parent_id 
 */
function _fumiki_tickets($parent_id){
	global $lwp;
	?>
<tr>
<th scope="row"><?php the_title(); ?></th>
<td><?php lwp_the_price();?></td>
<td>
	<?php lwp_the_ticket_stock(); ?>
</td>
<td><?php the_content(); ?></td>
<td>
	<?php if(lwp_get_ticket_stock() <= 0) :  ?>
		<?php if(lwp_has_cancel_list()) :  ?>
			<?php if(lwp_is_user_waiting()) :  ?>
				キャンセル待ち申込済み<br />
				<small>（<a href="<?= esc_attr(lwp_cancel_list_dequeue_url()); ?>" onclick="if(!confirm('キャンセル待ちを解除してよろしいですか？')) return false;">申込み解除</a>）</small>
			<?php else :  ?>
				<a rel="noindex,nofollow" href="<?= lwp_cancel_list_url(); ?>" onclick="if(!confirm('<?= esc_js(get_the_title($parent_id)." ".get_the_title()); ?>にキャンセル待ちを申し込みます。よろしいですか？\n※キャンセル待ちに申し込むと在庫を増やした時にメールを受け取ることができますが優先的に購入できるものではありません。')) return false;">キャンセル待ち</a>
			<?php endif; ?>
		<?php else :  ?>
			売り切れ
		<?php endif; ?>
	<?php elseif(time() >= lwp_selling_limit('U', $parent_id)) :  ?>
		募集終了
	<?php else :  ?>
		<a class="lwp-buynow" href="<?= esc_url(lwp_buy_url());?>">注文</a>
	<?php endif; ?>
</td>
</tr>
	<?php
}


