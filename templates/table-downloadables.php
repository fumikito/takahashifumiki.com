<? if(lwp_has_files()): ?>
<table class="file-list" id="download-contents">
<? $files = lwp_get_files(); ?>
	<tbody>
		<? $counter = 0; foreach($files as $f): $counter++;?>
		<tr class="<? echo ($counter % 2 == 0) ? 'even' : 'odd';?>">
			<td class="center">
				<? $ext = lwp_get_ext($f); ?>
				<img src="<? bloginfo('template_directory'); ?>/styles/img/ebook-filetypes/<?= $ext; ?>.png" alt="<?= $ext; ?>" width="75" height="75" />
				<em class="mono"><?= strtoupper($ext); ?></em>
			</td>
			<td>
				<div class="file-meta">
					<strong class="file-title "><?= $f->name; ?></strong>
					<small>（<? lwp_get_date($f); ?>）</small>
				</div>
				<div class="desc">
					<?= wpautop($f->detail); ?>
					<small>対応端末：<?= implode(', ', lwp_get_file_devices($f)); ?></small>
				</div>
			</td>
			<td class="width150 center">
				<?
					$accessibility = lwp_get_accessibility($f);
					if(
						($accessibility == "owner" && lwp_is_owner() ) //購入者限定でかつ所有権がある
						||
						($accessibility == "member" && is_user_logged_in()) //メンバーならダウンロードできるファイル
						||
						($accessibility == "any") // 誰でもダウンロードできるファイル
					):
				?>
					<a class="button button-download" href="<?= lwp_file_link($f->ID); ?>" rel="nofollow,noindex">
						<i class="fa-download"></i>
						ダウンロード
						<small><?= lwp_get_size($f); ?></small>
					</a>
					<small class="desc">クリックしてダウンロード</small>
				<? else: ?>
					<a class="button button-disabled" title="サイズ：<?= lwp_get_size($f); ?>" href="#" onclick="return false;">
						<i class="fa-times-circle-o"></i>
						利用不可
						<small><?= lwp_get_size($f); ?></small>
					</a>
					<small class="desc">
						<?
							switch($accessibility){
								case "owner":
									echo "購入後ダウンロード可能";
									break;
								case "member":
									echo '<a href="'.wp_login_url(get_permalink()).'">会員のみ</a>ダウンロード可能';
									break;
								default:
									echo "ダウンロードできません";
									break;
							}
						?>
					</small>
				<? endif; ?>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>
<? endif; ?>