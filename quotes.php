<?php get_header('meta') ?>


<header class="margin header">
    <a class="single-logo" href="<?= home_url('/', 'http') ?>">
        <img alt="<? bloginfo('name'); ?>" src="<?= get_template_directory_uri(); ?>/styles/img/logo-front-page.png" width="256" height="256" />
    </a>
</header>

<div class="quotes-container">
    <?php if( is_archive() ): ?>
        <h1>名言コレクション</h1>
    <?php endif; ?>

    <?php if(have_posts()): while(have_posts()): the_post(); ?>
        <div class="quotes-loop">

           <i class="fa-quote-left"></i>

           <blockquote class="quotes-content">
               <? the_content() ?>
               <cite class="quotes-cite"><? the_title() ?></cite>
           </blockquote>

            <div class="date">
                <?php if( is_archive() ): ?>
                    <a href="<?php the_permalink() ?>"><?= mysql2date('D, d M Y H:i', $post->post_date, false) ?></a>
                <?php else: ?>
                    <span class="date"><?= mysql2date('D, d M Y H:i', $post->post_date, false) ?></span>
                <?php endif; ?>
            </div><!--- //.date -->

            <?php if( !is_archive() ): ?>
                <p class="more-quotes">
                  <a href="<?= home_url('/quotes/', 'http') ?>">NEED MORE QUOTES?</a>
                </p>
            <?php endif; ?>

        </div><!-- //.quotes-loop -->
    <?php endwhile; endif; ?>
    <?php if( is_archive() && function_exists('wp_pagenavi')){
        ob_start();
        wp_pagenavi();
        $content = ob_get_contents();
        ob_end_clean();
        echo str_replace('ページ', ' Pages', $content);
    }  ?>
    <address>
        <span>集めた人</span>
        <?= get_avatar(1, 320) ?>
        <p>
            <a rel="home" href="<?= home_url('/', 'http') ?>">僕です。</a>
        </p>
    </address>
</div><!-- //.quotes-conainer -->
<?php wp_footer(); ?>
</body>
</html>