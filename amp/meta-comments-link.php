<?php
// Display related posts.
if ( function_exists( 'yarpp_get_related' ) && $posts = yarpp_get_related( [], get_the_ID() ) ) :
    ?>
    <div class="amp-wp-meta amp-related-posts">
        <h2 class="amp-related-title">関連記事</h2>
        <?php foreach ( $posts as $related ) : ?>
        <div class="amp-related-item">
            <a class="amp-related-item-link" href="<?= esc_url( get_the_permalink( $related ) ) ?>">
                <?php if ( has_post_thumbnail( $related ) ) : ?>
                    <amp-img src="<?= get_the_post_thumbnail_url( $related, 'thumbnail' ) ?>" width="60" height="60"></amp-img>
                <?php endif; ?>
                <span class="amp-related-item-title">
                    <?= esc_html( get_the_title( $related ) ) ?>
                    <small><?= get_the_time( 'Y/m/d', $related ) ?></small>
                </span>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<div class="amp-wp-meta amp-read-more">
    <h2 class="amp-read-more-title">フォローしてください</h2>
    <div class="amp-read-more-body">
        <p class="amp-read-more-lead">
            高橋文樹.comの最新情報を受け取ってください。
        </p>
        <?php foreach ([
            [ 'newsletter', 'ニュースレター', home_url( 'newsletter' ), 'envelope' ],
            [ 'facebook', 'Facebook', 'https://www.facebook.com/TakahashiFumiki.Page/', 'facebook' ],
            [ 'twitter', 'twitter', 'https://twitter.com/takahashifumiki', 'twitter' ],
            [ 'youtube', 'Youtube', 'https://www.youtube.com/channel/UCP_pT5slj41UApKnR0JknOA', 'youtube-play' ],
        ] as list ( $slug, $label, $url, $fa ) ) : ?>
        <a href="<?= esc_url( $url ) ?>" class="amp-read-more-link amp-read-more-link-<?= $slug ?>">
            <i class="fa fa-<?= $fa ?>"></i> <?= esc_html( $label ) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <a rel="home" class="amp-read-more-home" href="<?php the_permalink() ?>">
        ホームへ
    </a>
</div>

