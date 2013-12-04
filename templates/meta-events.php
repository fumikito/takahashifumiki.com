<table>
	<tbody>
		<tr>
			<th><i class="fa-calendar"></i>開催日時</th>
			<td class="mono">
				<? if(lwp_is_oneday_event()): ?>
					<?= lwp_event_starts('Y.n.j (D) H:i').'〜'.lwp_event_ends('H:i'); ?>
				<? else: ?>
					<? printf('開始: %s<br />終了: %s', lwp_event_starts('Y.n.j (D) H:i'), lwp_event_ends('Y.n.j (D) H:i')); ?>
				<? endif; ?>
				<? if(lwp_is_outdated_event()): ?>
					<br /><strong>このイベントは終了しました</strong>
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th><i class="fa-time"></i>申込〆切</th>
			<td class="mono">
				<?= lwp_selling_limit('Y.n.j (D)'); ?>
			</td>
		</tr>
		<tr>
			<th><i class="fa-remove-circle"></i>キャンセル条件</th>
			<td>
				<? if(lwp_is_cancelable()): ?>
					<?
						function _fumiki_cancel_condition($limit, $days_before, $ratio){
							$limit = date_i18n(get_option('Y/m/d (D)'), strtotime($limit) - ($days_before * 60 * 60 * 24));
							echo '<li>'.$limit.'までは'.$ratio.'%返金</li>';
						}
						lwp_list_cancel_condition('callback=_fumiki_cancel_condition');
					?>
				<? else: ?>
					できません
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th><i class="fa-check"></i>申込状況</th>
			<td>
				<? if(lwp_is_participating()): ?>
					あなたはすでに申し込み済みです。キャンセルする場合は<a href="<?= lwp_cancel_url();?>">こちら</a>から。
					<p><a class="button" href="<?= lwp_ticket_url(); ?>">チケットを表示する</a></p>
				<? elseif(is_user_logged_in()): ?>
					<a href="#ticket-list">チケット一覧</a>から申し込んでください。
				<? else: ?>
					<a href="<?= wp_login_url(get_permalink());?>">ログイン</a>して申し込んでください。
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th><i class="fa-group"></i>参加人数</th>
			<td>
				<? if(($number = lwp_participants_number())): ?>
					<?= number_format($number); ?>名参加
				<? else: ?>
					<strong>誰も参加表明していません！</strong>
				<? endif; ?>
			</td>
		</tr>
		<? if(user_can_edit_post(get_current_user_id(), get_the_ID())): ?>
		<tr>
			<th><i class="fa-key"></i>主催者管理</th>
			<td>
				<p><? lwp_token_chekcer();?></p>
			</td>
		</tr>
		<? endif; ?>
	</tbody>
</table>			
