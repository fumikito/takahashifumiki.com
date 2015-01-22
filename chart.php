<?php
/** @var \Fumiki\API\Chart\Prototype $this */
get_header('meta');
get_header('navi');
?>

<h1 class="center chart-title">チャート：<?= esc_html($this->get_title()) ?></h1>

<div id="google-chart">

</div>

<div class="margin clearfix">
	<form action="<?= admin_url('admin-ajax.php') ?>" class="chart-form">
		<input type="hidden" name="action" value="google_chart" />
		<input type="hidden" name="class" value="<?= $this->get_query() ?>" />
		<?php $this->form() ?>
		<p class="center submit-box">
			<input type="submit" class="button button-block" value="グラフ更新" />
		</p>
	</form>
</div>

<?php ?>

<?
get_footer();
