<?
    $length = fumiki_content_length();
    $tag_list = 'なし';
    if( ($tags = get_the_tags()) ){
        $terms = array();
        foreach($tags as $tag){
            $terms[] = sprintf('<a rel="tag" href="%s">%s</a>', get_tag_link($tag), esc_html($tag->name));
        }
        $tag_list = implode(', ', $terms);
    }
?>
<ul class="title-meta">
    <li>
        <span class="label"><i class="fa-calendar"></i></span>
        <?php the_date() ?>
        <?php the_expiration_info(); ?>
    </li>
    <li>
        <span class="label"><i class="fa-tachometer"></i></span>
        <span class="mono"><?= number_format($length); ?></span>文字
        （所要時間<?= floor($length / 400); ?>分）
    </li>
    <li>
        <span class="label"><i class="fa-comments"></i></span>
        <span class="mono"><?php comments_number('0件', "1件", '%件'); ?></span>
    </li>
    <li>
        <span class="label"><i class="fa-folder-open"></i></span>
        <?php the_category(', '); ?>
    </li>
    <li>
        <span class="label"><i class="fa-tags"></i></span>
        <?= $tag_list ?>
    </li>
</ul>
