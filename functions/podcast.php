<?php

/**
 * フィードにフィルターをかける
 */
add_action( 'ssp_before_feed', function() {
	ob_start();
}, 1 );

/**
 * フィードをカスタマイズして出力
 */
add_action( 'ssp_after_feed', function() {
	$content = ob_get_contents();
	ob_end_clean();
	try {
		$slug = get_query_var( 'podcast_series' );
		if ( ! $slug ) {
			throw new Exception( 'No Series.' );
		}

		$series  = get_term_by( 'slug', $slug, 'series' );
		if ( ! $series || is_wp_error( $series ) ) {
			throw new Exception( 'No series' );
		}

		$term_link = get_term_link( $series );

		$content = preg_replace_callback( '#<link>([^<]+)</link>#u', function( $match ) use ( $term_link ) {
			if ( home_url( '/' ) == $match[1] ) {
				$link = sprintf( '<link>%s</link>', $term_link );
			} else {
				$link = $match[0];
			}
			return $link;
		}, $content );
		echo $content;
	} catch ( Exception $e ) {
		echo $content;
		return;
	}
} );


//
add_action( 'series_edit_form_fields', function( $term ) {
	wp_nonce_field( 'sss_series', '_sssnonce', false );
	?>
	<tr>
		<th>
			<label for="sss_lead">リード</label>
		</th>
		<td>
			<input type="text" class="regular-text" name="sss_lead" id="sss_lead"
			       value="<?= esc_attr( get_term_meta( $term->term_id, 'lead', true ) ) ?>" />
		</td>
	</tr>
	<tr>
		<th>
			<label for="sss_eyecatch">画像</label>
		</th>
		<td>
			<input type="number" class="regular-text" name="sss_eyecatch" id="sss_eyecatch"
				   value="<?= esc_attr( get_term_meta( $term->term_id, 'eyecatch_id', true ) ) ?>" />
			<p class="description">
				最低1400px平方
			</p>
		</td>
	</tr>
	<tr>
		<th>
			<label for="sss_img">ポッドキャスト画像</label>
		</th>
		<td>
			<input type="number" class="regular-text" name="sss_img" id="sss_img"
				   value="<?= esc_attr( get_term_meta( $term->term_id, 'thumbnail_id', true ) ) ?>" />
			<p class="description">
				最低1400px平方
			</p>
		</td>
	</tr>
	<?php
	$category = sss_category_options();
	for ( $i = 1; $i <= 3; $i++ ) :
		$main_key = "podcast_cat_{$i}";
		$sub_key = "podcast_sub_cat_{$i}";
		$main = get_term_meta( $term->term_id, $main_key, true );
		$sub  = get_term_meta( $term->term_id, $sub_key, true );
		?>
		<tr>
			<th>
				<label for="<?= $main_key ?>">カテゴリー<?= $i ?></label>
			</th>
			<td>
				<select name="<?= $main_key ?>" id="<?= $main_key ?>">
					<?php foreach ( $category as $key => $val ) : ?>
						<option value="<?= esc_attr( $key ) ?>"<?php selected( $main == $key ) ?>><?= esc_html( $val ) ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label for="<?= $sub_key ?>">サブカテゴリー<?= $i ?></label>
			</th>
			<td>
				<select name="<?= $sub_key ?>" id="<?= $sub_key ?>">
					<?= sss_subcategory_options( $sub ) ?>
				</select>
			</td>

		</tr>

	<?php endfor;
} );

/**
 * Save series meta
 */
add_action( 'edit_terms', function( $term_id, $taxonomy ) {
	if ( 'series' != $taxonomy ) {
		return;
	}
	if ( ! isset( $_POST['_sssnonce'] ) || ! wp_verify_nonce( $_POST['_sssnonce'], 'sss_series' ) ) {
		return;
	}
	update_term_meta( $term_id, 'lead', $_POST['sss_lead'] );
	update_term_meta( $term_id, 'thumbnail_id', $_POST['sss_img'] );
	update_term_meta( $term_id, 'eyecatch_id', $_POST['sss_eyecatch'] );
	for ( $i = 1; $i <= 3; $i++ ) {
		foreach ( [ 'podcast_cat', 'podcast_sub_cat' ] as $key ) {
			$key = $key . '_' . $i;
			update_term_meta( $term_id, $key, $_POST[ $key ] );
		}
	}
}, 10, 2 );


/**
 * Get category options
 *
 * @return array
 */
function sss_category_options() {
	return [
		''                           => __( '-- None --', 'seriously-simple-podcasting' ),
		'Arts'                       => __( 'Arts', 'seriously-simple-podcasting' ),
		'Business'                   => __( 'Business', 'seriously-simple-podcasting' ),
		'Comedy'                     => __( 'Comedy', 'seriously-simple-podcasting' ),
		'Education'                  => __( 'Education', 'seriously-simple-podcasting' ),
		'Games & Hobbies'            => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		'Government & Organizations' => __( 'Government & Organizations', 'seriously-simple-podcasting' ),
		'Health'                     => __( 'Health', 'seriously-simple-podcasting' ),
		'Kids & Family'              => __( 'Kids & Family', 'seriously-simple-podcasting' ),
		'Music'                      => __( 'Music', 'seriously-simple-podcasting' ),
		'News & Politics'            => __( 'News & Politics', 'seriously-simple-podcasting' ),
		'Religion & Spirituality'    => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		'Science & Medicine'         => __( 'Science & Medicine', 'seriously-simple-podcasting' ),
		'Society & Culture'          => __( 'Society & Culture', 'seriously-simple-podcasting' ),
		'Sports & Recreation'        => __( 'Sports & Recreation', 'seriously-simple-podcasting' ),
		'Technology'                 => __( 'Technology', 'seriously-simple-podcasting' ),
		'TV & Film'                  => __( 'TV & Film', 'seriously-simple-podcasting' ),
	];
}

/**
 * Get subcategories
 *
 * @return string
 */
function sss_subcategory_options( $current = '' ) {
	$sub_cats = [
		'' => __( '-- None --', 'seriously-simple-podcasting' ),

		'Design'           => array(
			'label' => __( 'Design', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),
		'Fashion & Beauty' => array(
			'label' => __( 'Fashion & Beauty', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),
		'Food'             => array(
			'label' => __( 'Food', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),
		'Literature'       => array(
			'label' => __( 'Literature', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),
		'Performing Arts'  => array(
			'label' => __( 'Performing Arts', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),
		'Visual Arts'      => array(
			'label' => __( 'Visual Arts', 'seriously-simple-podcasting' ),
			'group' => __( 'Arts', 'seriously-simple-podcasting' ),
		),

		'Business News'          => array(
			'label' => __( 'Business News', 'seriously-simple-podcasting' ),
			'group' => __( 'Business', 'seriously-simple-podcasting' ),
		),
		'Careers'                => array(
			'label' => __( 'Careers', 'seriously-simple-podcasting' ),
			'group' => __( 'Business', 'seriously-simple-podcasting' ),
		),
		'Investing'              => array(
			'label' => __( 'Investing', 'seriously-simple-podcasting' ),
			'group' => __( 'Business', 'seriously-simple-podcasting' ),
		),
		'Management & Marketing' => array(
			'label' => __( 'Management & Marketing', 'seriously-simple-podcasting' ),
			'group' => __( 'Business', 'seriously-simple-podcasting' ),
		),
		'Shopping'               => array(
			'label' => __( 'Shopping', 'seriously-simple-podcasting' ),
			'group' => __( 'Business', 'seriously-simple-podcasting' ),
		),

		'Education'            => array(
			'label' => __( 'Education', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),
		'Education Technology' => array(
			'label' => __( 'Education Technology', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),
		'Higher Education'     => array(
			'label' => __( 'Higher Education', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),
		'K-12'                 => array(
			'label' => __( 'K-12', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),
		'Language Courses'     => array(
			'label' => __( 'Language Courses', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),
		'Training'             => array(
			'label' => __( 'Training', 'seriously-simple-podcasting' ),
			'group' => __( 'Education', 'seriously-simple-podcasting' ),
		),

		'Automotive'  => array(
			'label' => __( 'Automotive', 'seriously-simple-podcasting' ),
			'group' => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		),
		'Aviation'    => array(
			'label' => __( 'Aviation', 'seriously-simple-podcasting' ),
			'group' => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		),
		'Hobbies'     => array(
			'label' => __( 'Hobbies', 'seriously-simple-podcasting' ),
			'group' => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		),
		'Other Games' => array(
			'label' => __( 'Other Games', 'seriously-simple-podcasting' ),
			'group' => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		),
		'Video Games' => array(
			'label' => __( 'Video Games', 'seriously-simple-podcasting' ),
			'group' => __( 'Games & Hobbies', 'seriously-simple-podcasting' ),
		),

		'Local'      => array(
			'label' => __( 'Local', 'seriously-simple-podcasting' ),
			'group' => __( 'Government & Organizations', 'seriously-simple-podcasting' ),
		),
		'National'   => array(
			'label' => __( 'National', 'seriously-simple-podcasting' ),
			'group' => __( 'Government & Organizations', 'seriously-simple-podcasting' ),
		),
		'Non-Profit' => array(
			'label' => __( 'Non-Profit', 'seriously-simple-podcasting' ),
			'group' => __( 'Government & Organizations', 'seriously-simple-podcasting' ),
		),
		'Regional'   => array(
			'label' => __( 'Regional', 'seriously-simple-podcasting' ),
			'group' => __( 'Government & Organizations', 'seriously-simple-podcasting' ),
		),

		'Alternative Health'  => array(
			'label' => __( 'Alternative Health', 'seriously-simple-podcasting' ),
			'group' => __( 'Health', 'seriously-simple-podcasting' ),
		),
		'Fitness & Nutrition' => array(
			'label' => __( 'Fitness & Nutrition', 'seriously-simple-podcasting' ),
			'group' => __( 'Health', 'seriously-simple-podcasting' ),
		),
		'Self-Help'           => array(
			'label' => __( 'Self-Help', 'seriously-simple-podcasting' ),
			'group' => __( 'Health', 'seriously-simple-podcasting' ),
		),
		'Sexuality'           => array(
			'label' => __( 'Sexuality', 'seriously-simple-podcasting' ),
			'group' => __( 'Health', 'seriously-simple-podcasting' ),
		),

		'Buddhism'     => array(
			'label' => __( 'Buddhism', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Christianity' => array(
			'label' => __( 'Christianity', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Hinduism'     => array(
			'label' => __( 'Hinduism', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Islam'        => array(
			'label' => __( 'Islam', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Judaism'      => array(
			'label' => __( 'Judaism', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Other'        => array(
			'label' => __( 'Other', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),
		'Spirituality' => array(
			'label' => __( 'Spirituality', 'seriously-simple-podcasting' ),
			'group' => __( 'Religion & Spirituality', 'seriously-simple-podcasting' ),
		),

		'Medicine'         => array(
			'label' => __( 'Medicine', 'seriously-simple-podcasting' ),
			'group' => __( 'Science & Medicine', 'seriously-simple-podcasting' ),
		),
		'Natural Sciences' => array(
			'label' => __( 'Natural Sciences', 'seriously-simple-podcasting' ),
			'group' => __( 'Science & Medicine', 'seriously-simple-podcasting' ),
		),
		'Social Sciences'  => array(
			'label' => __( 'Social Sciences', 'seriously-simple-podcasting' ),
			'group' => __( 'Science & Medicine', 'seriously-simple-podcasting' ),
		),

		'History'           => array(
			'label' => __( 'History', 'seriously-simple-podcasting' ),
			'group' => __( 'Society & Culture', 'seriously-simple-podcasting' ),
		),
		'Personal Journals' => array(
			'label' => __( 'Personal Journals', 'seriously-simple-podcasting' ),
			'group' => __( 'Society & Culture', 'seriously-simple-podcasting' ),
		),
		'Philosophy'        => array(
			'label' => __( 'Philosophy', 'seriously-simple-podcasting' ),
			'group' => __( 'Society & Culture', 'seriously-simple-podcasting' ),
		),
		'Places & Travel'   => array(
			'label' => __( 'Places & Travel', 'seriously-simple-podcasting' ),
			'group' => __( 'Society & Culture', 'seriously-simple-podcasting' ),
		),

		'Amateur'               => array(
			'label' => __( 'Amateur', 'seriously-simple-podcasting' ),
			'group' => __( 'Sports & Recreation', 'seriously-simple-podcasting' ),
		),
		'College & High School' => array(
			'label' => __( 'College & High School', 'seriously-simple-podcasting' ),
			'group' => __( 'Sports & Recreation', 'seriously-simple-podcasting' ),
		),
		'Outdoor'               => array(
			'label' => __( 'Outdoor', 'seriously-simple-podcasting' ),
			'group' => __( 'Sports & Recreation', 'seriously-simple-podcasting' ),
		),
		'Professional'          => array(
			'label' => __( 'Professional', 'seriously-simple-podcasting' ),
			'group' => __( 'Sports & Recreation', 'seriously-simple-podcasting' ),
		),

		'Gadgets'         => array(
			'label' => __( 'Gadgets', 'seriously-simple-podcasting' ),
			'group' => __( 'Technology', 'seriously-simple-podcasting' ),
		),
		'Tech News'       => array(
			'label' => __( 'Tech News', 'seriously-simple-podcasting' ),
			'group' => __( 'Technology', 'seriously-simple-podcasting' ),
		),
		'Podcasting'      => array(
			'label' => __( 'Podcasting', 'seriously-simple-podcasting' ),
			'group' => __( 'Technology', 'seriously-simple-podcasting' ),
		),
		'Software How-To' => array(
			'label' => __( 'Software How-To', 'seriously-simple-podcasting' ),
			'group' => __( 'Technology', 'seriously-simple-podcasting' ),
		),
	];
	$out = '';
	$groups = [];
	foreach ( $sub_cats as $key => $value ) {
		if ( is_array( $value ) ) {
			if ( ! isset( $groups[$value['group']] ) ) {
				$groups[$value['group']] = [];
			}
			$groups[$value['group']][] = sprintf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $key ),
				selected( $key == $current, true, false ),
				esc_html( $value['label'] )
			);
		} else {
			$out .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $key ), selected( $key == $current, true, false ), esc_html( $value ) );
		}
	}
	foreach ( $groups as $key => $options ) {
		$out .= sprintf( '<optgroup label="%s">', esc_attr( $key ) );
		foreach ( $options as $option ) {
			$out .= $option;
		}
		$out .= '</optgroup>';
	}
	return $out;
}

/**
 * Change template if file exists
 */
add_filter( 'template_include', function( $template_file ) {
	if ( is_post_type_archive( 'podcast' ) || is_singular( 'podcast' ) || is_tax( 'series' ) ) {
		$template_file = get_template_directory() . '/podcast.php';
	}
	return $template_file;
} );

/**
 * Get current series
 *
 * @param null|int|WP_post $post
 *
 * @return mixed|null
 */
function fumiki_current_series( $post = null ) {
	$terms = get_the_terms( get_post( $post ), 'series' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return null;
	} else {
		return current( $terms );
	}
}

/**
 * Get podcast slug
 *
 * @return string
 */
function fumiki_podcast_slug() {
	static $slug = null;
	if ( ! is_null( $slug ) ) {
		return $slug;
	}
	if ( is_post_type_archive( 'podcast' ) ) {
		$slug = 'portal';
	} elseif ( is_tax( 'series' ) ) {
		$slug = get_queried_object()->slug;
	} elseif ( is_singular( 'podcast' ) ) {
		$term = fumiki_current_series( get_queried_object() );
		$slug = $term ? $term->slug : 'unknown';
	} else {
		$slug = 'unknown';
	}
	return $slug;
}

function fumiki_get_media_type() {

}
