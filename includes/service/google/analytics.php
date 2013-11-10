<?php

namespace Fumiki\Service\Google;

use Fumiki\Pattern;

/**
 * Utility class fro Google Analytics
 *
 * @author Takahahsi Fumiki
 */
class Analytics extends Pattern\Singleton
{

	/**
	 * @var array
	 */
	protected static $default_arguments = array(
		'profile_id' => '',
		'domain' => '',
	);

	/**
	 * @var float
	 */
	private $init_time = 0;

	/**
	 * @var string
	 */
	private $profile_id = '';

	/**
	 * @var string
	 */
	private $domain = '';

	/**
	 * Page label for event tracking
	 * @var string
	 */
	private $page_label = '';

	/**
	 * Page action for event tracking
	 * @var string
	 */
	private $page_action = '';

	/**
	 * Constructor
	 *
	 * Argument's keys are below
	 * 'profile_id' => 'UA-********' You profile ID for Google Analytics.
	 * 'domain'     => 'example.jp'  Your domain to track
	 *
	 * @param array $arguments
	 */
	protected function __construct( array $arguments ){
		$this->profile_id = $arguments['profile_id'];
		$this->domain = $arguments['domain'];
		$this->init_time = microtime(true);
		add_action('wp_head', array($this, 'print_timer'), 1);
		add_action('wp_head', array($this, 'print_scripts'), 10000);
		add_action('wp_footer', array($this, 'print_footer'), 99999);
	}

	/**
	 * Returns passed seconds from initialization
	 *
	 * @return float
	 */
	private function passed_time(){
		return microtime(true) - $this->init_time;
	}

	/**
	 * Returns user role for custom dimension 1
	 *
	 * @return string
	 */
	protected function user_role(){
		if(current_user_can('edit_others_posts')){
			return 'editor';
		}elseif(is_user_logged_in()){
			return 'subscriber';
		}else{
			return 'anonymous';
		}
	}

	/**
 	 * Print timer for GA time tracking
	 */
	public function print_timer(){
		?>
		<script type="text/javascript">
			GAM = window.GAM || {};
			GAM.timer = 0;
			setInterval(function(){
				GAM.timer += 0.01;
			}, 10);
		</script>
		<?php
	}

	/**
 	 * Print GA tracking code on header
	 *
	 */
	public function print_scripts(){
		$this->set_labels();
		?>
		<script>
			GAM = window.GAM || {};
			GAM.pageAction = '<?= esc_js($this->page_action) ?>';
			GAM.pageLabel = '<?= esc_js($this->page_label) ?>';
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			window.google_analytics_uacct = "<?= esc_js($this->profile_id) ?>";
			ga('create', '<?= esc_js($this->profile_id) ?>', '<?= esc_js($this->domain) ?>'
				<? if(is_user_logged_in()): ?>
				,{
					clientId: <?= get_current_user_id() ?>
				}
				<? endif; ?>
			);
			ga('set', 'dimension1', '<?= esc_js($this->user_role()) ?>');
			ga('send', 'pageview');
		</script>
	<?php
	}

	/**
	 * Print performance value on wp_footer
	 *
	 */
	public function print_footer(){
		?>
		<script type="text/javascript">
			try{
				ga('send', {
					hitType: 'event',
					eventCategory: 'performance',
					eventAction: GAM.pageAction,
					eventLabel: GAM.pageLabel,
					eventValue: <?= $this->passed_time(); ?>,
					nonInteraction: true
				});
			}catch(e){};
		</script>
		<?php
	}

	/**
	 * Register page labels
	 *
	 * @global \WP_Query $wp_query
	 */
	private function set_labels(){
		/** @var $wp_query \WP_Query */
		global $wp_query;
		$action = 'other';
		$label = 'undefined';
		if($wp_query->is_front_page()){
			$action = 'front';
			$label = 'front';
		}elseif($wp_query->is_home()){
			$action = 'home';
			$label = max(1, (int)$wp_query->get('paged'));
		}elseif($wp_query->is_date()){
			$year = (int) $wp_query->get('year');
			$month = (int) $wp_query->get('monthnum');
			$day = (int) $wp_query->get('day');
			$label = sprintf('%04d-%02d-%02d', $year, $month, $day);
		}elseif($wp_query->is_category){
			$action = 'category';
			$label = $wp_query->get('category_name');
		}elseif($wp_query->is_tag()){
			$action = 'tag';
			$label = $wp_query->get('tag');
		}elseif($wp_query->is_tax()){
			$action =  $wp_query->get('taxonomy');
			$label = $wp_query->get($action);
		}elseif($wp_query->is_post_type_archive()){
			$action = 'archive';
			$label = $wp_query->get('post_type');
		}elseif($wp_query->is_author()){
			$action = 'author';
			$label = $wp_query->get('author_name');
		}elseif($wp_query->is_search()){
			$action = 'search';
			$label = $wp_query->get('s');
		}elseif($wp_query->is_page()){
			$action = 'page';
			$label  = $wp_query->get('pagename');
		}elseif($wp_query->is_singular('post')){
			$action = 'post';
			$label = $wp_query->get('p');
		}elseif($wp_query->is_singular()){
			$action = $wp_query->get('post_type');
			$label = $wp_query->get($wp_query->get('post_type'));
		}elseif($wp_query->is_404()){
			$action = '404';
			$label = '';
		}
		$this->page_action = $action;
		$this->page_label = $label;
	}
}
