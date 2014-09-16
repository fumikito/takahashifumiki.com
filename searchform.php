<form method="get" id="sorter" action="<?= home_url('', 'http') ?>">

    <input type="hidden" name="post_type" value="any" />

    <p class="sort-title">
        <?php global $wp_query;  echo number_format($wp_query->found_posts); ?>件が見つかりました
        <a id="sorter-toggle" class="button"><i class="fa fa-search"></i>詳細検索</a>
    </p>

    <div id="sort-fields" class="clearfix">

        <label>
            <span>検索ワード</span>
            <input type="text" name="s" value="<? the_search_query(); ?>" placeholder="指定なし" />
        </label>

        <label>
            <span>タグ</span>
            <input type="text" name="tag" value="<?= esc_attr(get_query_var('tag')) ?>" placeholder="指定なし" />
        </label>

        <label>
            <span>カテゴリー</span>
            <?php wp_dropdown_categories('show_option_none=カテゴリーを選択&selected='.(int)get_query_var('cat')); ?>
        </label>

        <label>
            <span>優先順位</span>
            <select name="orderby">
                <?php $order_by = get_query_var('orderby') ?: 'date'; ?>
                <option value="date"<? selected($order_by == 'date') ?>>公開日</option>
                <option value="modified"<? selected($order_by == 'modified') ?>>最終更新日</option>
                <option value="title"<? selected($order_by == 'title') ?>>タイトル</option>
                <option value="comment_count"<? selected($order_by == 'comment_count') ?>>コメント数</option>
            </select>
        </label>

        <label>
            <span>並び順</span>
            <select name="order">
                <?php $order = get_query_var('order') ?: 'DESC'; ?>
                <option value="ASC"<?php selected( $order == 'ASC') ?>>昇順</option>
                <option value="DESC"<?php selected( $order == 'DESC') ?>>降順</option>
            </select>
        </label>

	</div><!-- //#sort-fields -->

    <p class="sort-submit">
        <input type="submit" class="submit" value="絞り込み" />
    </p>
</form>

