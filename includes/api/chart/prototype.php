<?php

namespace Fumiki\API\Chart;


use Fumiki\Pattern\Singleton;
use Fumiki\Utility\Input;

/**
 * Class Prototype
 *
 * @package Fumiki\API\Chart
 * @property-read Input
 */
abstract class Prototype extends Singleton
{

	/**
	 * @var \WP_Query
	 */
	protected $query = null;

	/**
	 * @var string
	 */
	protected $title = 'チャート';

	/**
	 * @var string
	 */
	protected $description = '実験のために作ったチャートです。';

	/**
	 * @var array
	 */
	protected $valid_query = array();

	/**
	 * @var string
	 */
	protected $chart = 'LineChart';

	/**
	 * Constructor
	 *
	 * Constuctor should not be public.
	 *
	 * @param array $argument
	 */
	protected function __construct( array $argument = array() ) {
		if( isset($argument['query']) ){
			$this->query = $argument['query'];
		}
	}

	/**
	 * Get chart URL
	 *
	 * @param bool $skip_args
	 * @return string|void
	 */
	protected function url( $skip_args = false ){
		$url = home_url('/charts/'.$this->get_query().'/');
		if( $skip_args ){
			return $url;
		}
		$args = array();
		foreach( $this->valid_query as $q ){
			if( $value = $this->input->get($q) ){
				$args[$q] = $value;
			}
		}
		return add_query_arg($args, $url);
	}

	/**
	 * Render form
	 *
	 * @return void
	 */
	abstract public function form();

	/**
	 * Render Screen
	 */
	public function render(){
		add_action('template_redirect', array($this, 'template_redirect'));
		add_action('wp_head', array($this, 'ogp'), 2);
		$page_title = $this->get_title();
		add_filter('wp_title', function($title, $sep) use ($page_title){
			return $page_title."{$sep}チャート{$sep}".$title;
		}, 10, 2);
		do_action('template_redirect');
		add_action('wp_footer', array($this, 'wp_footer'));
		include get_template_directory().'/chart.php';
		exit;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title(){
		return $this->title;
	}

	/**
	 * Get input value
	 *
	 * @param string $key
	 * @param string $default
	 *
	 * @return string
	 */
	public function value($key, $default = ''){
		return $this->input->get($key) ?: $default;
	}

	/**
	 * Output OGP
	 */
	public function ogp(){
		$title = esc_attr(wp_title('|', false, 'right').get_bloginfo('name'));
		$url = esc_url($this->url());
		$desc = $this->description;
		$type = 'article';
		$image = get_template_directory_uri().'/styles/img/graph/ogp.jpg';
		echo <<<HTML

<!-- Open Graph -->
<meta property="og:locale" content="ja_jp" />
<meta property="og:title" content="{$title}"/>
<meta property="og:url" content="{$url}" />
<meta property="og:image" content="{$image}" />
<meta property="og:description" content="{$desc}" />
<meta property="og:type" content="{$type}" />
<meta property="og:site_name" content="高橋文樹.com"/>
<meta property="fb:admins" content="1034317368" />
<!-- Twitter Card -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@takahashifumiki" />
<meta name="twitter:url" content="{$url}" />
<meta name="twitter:title" content="{$title}" />
<meta name="twitter:description" content="{$desc}" />
<meta name="twitter:image" content="{$image}" />
<meta name="description" content="{$desc}" />
HTML;
	}

	/**
	 * Executed on template_redirect
	 */
	public function template_redirect(){
		// Do something
	}

	/**
	 * Executed on wp_enqueue_scripts
	 */
	public function wp_enqueue_scripts(){
		// Enqueue something
	}

	/**
	 * Executed on wp_footer
	 */
	public function wp_footer(){
		// Do something
	}

	/**
	 * Handle Ajax request
	 */
	public function ajax(){
		try{
			$response = array(
				'success' => true,
				'data' => $this->get_json_data(),
				'link' => $this->url(),
				'options' => $this->get_options(),
				'chart' => $this->chart,
				'title' => $this->get_title(),
			);
			wp_send_json($response);
		}catch ( \Exception $e ){
			wp_send_json_error(new \WP_Error($e->getCode(), $e->getMessage()));
		}
	}

	/**
	 * Get JSON data
	 *
	 * @return array
	 * @throws \Exception
	 */
	abstract protected function get_json_data();

	protected function get_options(){
		return array(
			'title' => $this->get_title(),
		);
	}

	/**
	 * Get query arguments
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function query_arguments($args = array()){
		return array_merge(array(
			'action' => 'google_chart',
			'class' => $this->get_query(),
		), $args);
	}

	/**
	 * @return string
	 */
	protected function get_query(){
		$class_seg = explode('\\', get_called_class());
		$basename = $class_seg[count($class_seg) - 1];
		return substr(preg_replace_callback('/([A-Z])/', function($match){
			return '-'.strtolower($match[1]);
		}, $basename), 1);
	}

	/**
	 * Getter
	 *
	 * @param string $name
	 *
	 * @return null
	 */
	public function __get($name){
		switch( $name ){
			case 'input':
				return Input::get_instance();
				break;
			default:
				return null;
				break;
		}
	}

}
