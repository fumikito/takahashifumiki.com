<?php
$cache = get_transient( 'front_block' );

if ( false === $cache || current_user_can( 'edit_others_posts' ) ) :
	ob_start();
	?>

	<div class="container">
		<div class="row">

			<?php dynamic_sidebar( 'トップページ' ) ?>

			<?php
			$external_posts = [];
			foreach (
				[
					'hametuha' => 'https://hametuha.com/author/takahashi_fumiki/feed/',
					'hamenew'  => 'https://hametuha.com/author/takahashi_fumiki/feed/?post_type=news',
					'capitalp' => 'https://capitalp.jp/author/takahashi_fumiki/feed/',
					'gianism'  => 'https://gianism.info/author/takahashi_fumiki/feed/?lang=ja',
				] as $slug => $url
			) {
				$feed = fetch_feed( $url );
				if ( is_wp_error( $feed ) ) {
					continue;
				}
				// Set site icon
				switch ( $slug ) {
					case 'hametuha':
						$icon  = get_stylesheet_directory_uri() . '/assets/img/favicon/hametuha.png';
						$title = '破滅派';
						break;
					case 'hamenew':
						$icon  = get_stylesheet_directory_uri() . '/assets/img/favicon/minico.png';
						$title = 'はめにゅー';
						break;
					case 'capitalp':
						$icon  = $feed->get_image_url();
						$title = 'Capital P';
						break;
					case 'gianism':
						$icon  = $feed->get_image_url();
						$title = 'Gianism.info';
						break;
					default:
						$icon  = $feed->get_image_url();
						$title = $feed->get_title();
						break;
				}
				// Other elements
				foreach ( $feed->get_items( 0, 5 ) as $item ) {
					/** @var SimplePie_Item $item */
					$link                         = [
						'title'      => $item->get_title(),
						'link'       => $item->get_link(),
						'images'     => array_filter( $item->get_enclosures(), function ( $image ) {
							return isset( $image->link ) && $image->link && ( 'image' == $image->medium );
						} ),
						'desc'       => $item->get_description(),
						'date'       => $item->get_date( 'Y-m-d H:i:s' ),
						'category'   => $item->get_categories(),
						'site_title' => $title,
						'site_icon'  => $icon,
						'slug'       => $slug,
					];
					$timestamp                    = strtotime( $link['date'] );
					$external_posts[ $timestamp ] = $link;
				}
			}
			krsort( $external_posts );
			foreach ( $external_posts as $external ) {
				?>
				<div class="widget widget-front widget-front-external">
					<a href="<?= esc_url( $external['link'] ) ?>" class="card-link">
						<?php
						foreach ( $external['images'] as $image ) :
							/** @var SimplePie_Enclosure $image */
							if ( 1000 > $image->get_width() ) :
								?>
								<div class="card-image-holder">
									<img class="card-image" src="<?= esc_url( $image->get_link() ) ?>"
										 alt="<?= esc_attr( $image->get_title() ) ?>"/>
								</div>
								<?php
								break;
							endif;
						endforeach;
						?>
						<div class="card-body">
							<h2 class="card-title">
								<?= esc_html( $external['title'] ) ?>
							</h2>
							<div class="card-meta">
								<?php if ( $external['category'] ) : ?>
									<span class="card-tags">
								<i class="fa fa-tags"></i> <?= implode( ', ', array_map( function ( SimplePie_Category $cat ) {
											return $cat->term;
										}, $external['category'] ) ) ?>
							</span><br/>
								<?php endif; ?>
								<span class="card-tags">
								<i class="fa fa-calendar"></i>
									<?= get_date_from_gmt( $external['date'], 'Y年n月j日' ) ?>
							</span>
							</div>
							<div class="card-desc">
								<?= wpautop( explode( "\n", strip_tags( $external['desc'] ) )[0] ) ?>
							</div>
						</div>
						<div class="card-footer">
							<?php if ( $external['site_icon'] ) : ?>
								<img class="card-footer-icon" src="<?= esc_url( $external['site_icon'] ) ?>" alt=""
									 width="16" height="16"/>
							<?php endif; ?>
							<span class="card-footer-title">
							<?= esc_html( $external['site_title'] ) ?>
						</span>
						</div>
					</a>
				</div>
				<?php
			}
			?>

		</div>
	</div>

	<?php
	$cache = ob_get_contents();
	ob_end_clean();
	set_transient( 'front_block', $cache, 600 );
endif;
echo $cache;
?>