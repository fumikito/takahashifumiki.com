<?php
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
<div class="page-header-meta clearfix">
    <div class="col-xs-12 col-sm-4 text-center">
        <i class="fa fa-calendar"></i>
        <?php the_date() ?>
        <small><?php the_expiration_info(); ?></small>
    </div>
    <div class="col-xs-12 col-sm-4 text-center">
        <i class="fa fa-tachometer"></i>
        <?= number_format( $length ); ?>文字
        <small>（読了時間<?= floor( $length / 400 ); ?>分）</small>
    </div>
        <div class="col-xs-12 col-sm-4 text-center">
        <i class="fa fa-folder-open"></i>
        <?php the_category( ', ' ); ?>
    </div>
</div>
