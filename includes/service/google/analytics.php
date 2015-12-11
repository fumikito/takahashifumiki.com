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
	protected function __construct( array $arguments = array() ){
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
        $hit = false;
        // Webフォントの読み込みを次のページだけランダムにする
        foreach( ( false === strpos(home_url('/', 'http'), '.com') ? array(2173, 2864, 2876) : array(1266, 1403, 2173)) as $post_id){
            if( is_single($post_id) ){
                $hit = true;
            }
        }
		?>

		<script type="text/javascript">
			GAM = window.GAM || {};
			GAM.start = new Date();
			GAM.getTime = function(){
				return Math.round(new Date() - this.start);
			};
            <?php if($hit) :  ?>
            GAM.webFont =  (Math.random() <= 0.5);
            <?php else :  ?>
            GAM.webFont = true;
            <?php endif; ?>
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
			ga('create', '<?= esc_js($this->profile_id) ?>', '<?= esc_js($this->domain) ?>');
            <?php if(is_user_logged_in()) :  ?>
            ga('set', '&uid', '<?= get_current_user_id() ?>');
            <?php endif; ?>
            <?php
                // ページ種別を出力
                if( is_front_page() ){
                    $page_type = 'front';
                }else if( is_home() ){
                    $page_type = 'home';
                }else if( is_post_type_archive() ){
                    $page_type = get_post_type().'-archive';
                }else if( is_singular() ){
                    $page_type = get_post_type();
                }else if( is_category() ){
                    $page_type = 'category';
                }else if( is_tag() ){
                    $page_type = 'tag';
                }else if( is_tax() ){
                    $taxonomies = get_taxonomies();
                    $page_type = 'taxonomy';
                    foreach( $taxonomies as $tax ){
                        if( is_tax($tax) ){
                            $page_type = $tax;
                            break;
                        }
                    }
                }else if( is_search() ){
                    $page_type = 'search';
                }else{
                    $page_type = 'undefined';
                }
            ?>
            ga('set', 'dimension3', '<?= esc_js($page_type) ?>');
            ga('set', 'dimension2', (GAM.webFont ? 'With Web Font' : 'No Web Font'));
			ga('set', 'dimension1', '<?= esc_js($this->user_role()) ?>');
            ga('require', 'displayfeatures');
			ga('require', 'linkid', 'linkid.js');
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
					eventValue: <?= round(1000 * $this->passed_time()); ?>,
					nonInteraction: true
				});
			}catch(err){}
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
		}else{
            $action = 'undefined';
            $label = '';
        }
		$this->page_action = $action;
		$this->page_label = $label;
	}
}
