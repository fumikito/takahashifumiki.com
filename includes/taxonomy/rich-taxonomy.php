<?php

namespace Fumiki\Taxonomy;

use \Fumiki\Pattern\Singleton;

/**
 * Class Rich_Taxonomy
 *
 * @package Fumiki\Taxonomy
 * @property-read \wpdb $wpdb
 */
class Rich_Taxonomy extends Singleton
{

	/**
	 * Taxonomies
	 *
	 * @var array
	 */
	private $taxonomies = array();

	/**
	 * @var string
	 */
	private $meta_key = '_rich_tax';


	/**
	 * Constructor
	 *
	 * Constuctor should not be public.
	 *
	 * @param array $argument Taxonomies
	 */
	protected function __construct( array $argument = array() ) {
		$this->taxonomies = $argument;

		if( !empty($this->taxonomies) ){
			foreach( $this->taxonomies as $taxonomy ){
				if( taxonomy_exists($taxonomy) ){
					add_action( "{$taxonomy}_edit_form_fields", array($this, 'form_field'), 10, 2);
				}
			}
		}
	}

	/**
	 * Rich taxonomy field
	 *
	 * @param \stdClass $tag
	 * @param string $taxonomy
	 */
	public function form_field($tag, $taxonomy){
		$post_id = $this->rich_post_id($tag->term_taxonomy_id);
		$content = '';
		if( $post = get_post($post_id) ){
			$content = $post->post_content;
		}
		?>
		<tr>
			<th><label for="rich_tax_eyecatch">リッチビジュアル</label></th>
			<td>

			</td>
		</tr>
		<tr>
			<th><label for="rich_tax_eyecatch">アイキャッチ</label></th>
			<td>

			</td>
		</tr>
		<tr>
			<th><label for="rich_tax_content">本文</label></th>
			<td>
				<?php wp_editor($content, 'rich_tax_content', array(
					'media_buttons' => true,
					'quicktags' => false,
				)) ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get rich post id
	 *
	 * @param $term_taxonomy_id
	 *
	 * @return int
	 */
	protected function rich_post_id($term_taxonomy_id){
		$query = <<<SQL
			SELECT post_id FROM {$this->db->postmeta}
			WHERE meta_key = '{$this->meta_key}'
			  AND meta_value = %d
SQL;
		return (int) $this->db->get_var($this->db->prepare($query, $term_taxonomy_id));
	}

	public function __get($name){
		switch( $name ){
			case 'db':
				global $wpdb;
				return $wpdb;
				break;
			default:
				return null;
				break;
		}
	}
}