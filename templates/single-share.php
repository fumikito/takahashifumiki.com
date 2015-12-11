<div class="google-share clearfix">
    <div class="share">
        <?php fumiki_share(get_the_title()." | ".get_bloginfo('name'), get_permalink()); ?>
    </div>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- 高橋文樹スマートフォン上 -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-0087037684083564"
         data-ad-slot="9969902841"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <?php if( is_singular('post') ) :  ?>
    <div class="single-content-detail">
        <i class="fa fa-info"></i>
        <p>
            この記事は<?php the_category(', ') ?>にカテゴライズされています。タグは<?php the_tags('', ', ') ?>です。
            そこら辺を見ると、似たような記事が見つかるかもしれません。
        </p>
    </div>
    <?php endif; ?>
</div><!-- //.google-share -->
