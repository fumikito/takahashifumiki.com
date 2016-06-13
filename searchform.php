<?php
global $wp_query;
?>
<form method="get" id="sorter" action="<?= home_url( '', 'http' ) ?>">

	<input type="hidden" name="post_type" value="any"/>

	<fieldset>
		<legend><?= number_format( $wp_query->found_posts ); ?>件が見つかりました
	</fieldset>

	<div class="row">

		<div class="col-xs-12 col-sm-4">
			<div class="form-group label-floating">
				<label class="control-label" for="archive-search">検索ワード</label>
				<input class="form-control" type="text" name="s" value="<?php the_search_query(); ?>"
				       placeholder="指定なし" id="archive-search"/>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="form-group label-floating">
				<label class="control-label" for="archive-tag">タグ</label>
				<input class="form-control" type="text" name="tag" value="<?= esc_attr( get_query_var( 'tag' ) ) ?>"
				       placeholder="指定なし" id="archive-tag"/>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="form-group label-floating">
				<label class="control-label" for="cat">カテゴリー</label>
				<?php wp_dropdown_categories( [
					'show_option_none' => 'カテゴリーを選択',
					'selected'         => (int) get_query_var( 'cat' ),
					'class'            => 'form-control',
				] ); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<div class="form-group label-floating">
				<label class="control-label" for="orderby">優先順位</label>
				<select name="orderby" id="orderby" class="form-control">
					<?php $order_by = get_query_var( 'orderby' ) ?: 'date'; ?>
					<option value="date"<?php selected( $order_by == 'date' ) ?>>公開日</option>
					<option value="modified"<?php selected( $order_by == 'modified' ) ?>>最終更新日</option>
					<option value="title"<?php selected( $order_by == 'title' ) ?>>タイトル</option>
					<option value="comment_count"<?php selected( $order_by == 'comment_count' ) ?>>コメント数</option>
				</select>
			</div>
		</div>

		<div class="col-xs-12 col-sm-4">
			<div class="form-group label-floating">
				<label class="control-label" for="order">並び順</label>
				<select name="order" id="order" class="form-control">
					<?php $order = get_query_var( 'order' ) ?: 'DESC'; ?>
					<option value="ASC"<?php selected( $order == 'ASC' ) ?>>昇順</option>
					<option value="DESC"<?php selected( $order == 'DESC' ) ?>>降順</option>
				</select>
			</div>
		</div>

		<div class="col-xs-12 col-sm-4">
			<input type="submit" class="btn btn-primary btn-raised btn-lg btn-block" value="検索する"/>
		</div>

	</div>

</form>

