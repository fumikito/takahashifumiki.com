<?php

namespace Fumiki\Service\Google;


use Fumiki\Pattern\Singleton;

/**
 * Chart Handler
 *
 * @package Fumiki\Service\Google
 */
class Chart extends Singleton
{

	/**
	 * Constructor
	 *
	 * Constructor should not be public.
	 *
	 * @param array $argument
	 */
	protected function __construct( array $argument = array() ) {
		add_filter('rewrite_rules_array', array($this, 'rewrite_rules'));
		add_filter('query_vars', function($vars){
			$vars[] = 'chart';
			return $vars;
		});
		add_action('pre_get_posts', array($this, 'pre_get_posts'));
		if( is_admin() && defined('DOING_AJAX') && DOING_AJAX ){
			add_action('wp_ajax_google_chart', array($this, 'ajax'));
			add_action('wp_ajax_nopriv_google_chart', array($this, 'ajax'));
		}
	}

	/**
	 * Filter rewrite rules
	 *
	 * @param array $rules
	 *
	 * @return array
	 */
	public function rewrite_rules( $rules = array() ){
		return array_merge(array(
			'^charts/([^/]+)/?' => 'index.php?chart=$matches[1]'
		), $rules);
	}

	/**
	 * Add Endpoint
	 *
	 * @param \WP_Query $wp_query
	 */
	public function pre_get_posts( \WP_Query &$wp_query ){
		if( $chart_class = $wp_query->get('chart') ){
			if( $chart_class = $this->build_class_name($chart_class) ){
				$instance = $chart_class::get_instance(array(
					'query' => $wp_query
				));
				add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
				$instance->render();
			}else{
				$wp_query->set_404();
			}
		}
	}

	/**
	 * Handle Ajax request
	 */
	public function ajax(){
		if( !isset($_REQUEST['class']) || !($chart_class = $this->build_class_name($_REQUEST['class'])) ){
			wp_die('指定されたチャートは存在しません。', 'Error', array(
				'response' => 404,
			));
		}
		$instance = $chart_class::get_instance();
		$instance->ajax();
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue_scripts(){
		wp_enqueue_script('fumiki-google-chart', get_template_directory_uri().'/styles/js/chart.min.js', array('jquery-form', 'google-js-api'), fumiki_theme_version(), true);
		wp_enqueue_style('fumiki-google-chart', get_template_directory_uri().'/styles/stylesheets/chart.css', null, fumiki_theme_version());
	}

	/**
	 * Detect class exists
	 *
	 * @param string $query
	 *
	 * @return bool|string
	 */
	protected function build_class_name($query){
		$absolute_name = 'Fumiki\\API\\Chart\\'.ucfirst(preg_replace_callback('/(-)([a-z])/', function($match){
				return strtoupper($match[2]);
			}, $query));
		if( class_exists($absolute_name) && ($refl = new \ReflectionClass($absolute_name)) && $refl->isSubclassOf('Fumiki\\API\\Chart\\Prototype') ){
			return $absolute_name;
		}else{
			return false;
		}
	}

}
