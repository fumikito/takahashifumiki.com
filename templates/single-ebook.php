<div class="related">
    <h2 class="related-links"><i class="fa fa-book"></i> 電子書籍も買ってくれよな！</h2>
    <ol class="post-list post-list-large">
        <?
            $ebooks = new WP_Query(array(
                'post_type' => 'ebook',
                'post_status' => 'publish',
                'posts_per_page' => 3,
            ));
        while( $ebooks->have_posts() ): $ebooks->the_post(); ?>
            <? get_template_part('templates/loop', get_post_type()); ?>
        <? endwhile; wp_reset_postdata(); ?>
    </ol>
</div><!-- //.related -->
