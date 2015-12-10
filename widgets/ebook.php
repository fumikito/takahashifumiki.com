<?php
/**
 * ウィジェットにいいねを追加する
 * @package WordPress
 */
class Fumiki_eBook extends WP_Widget{
	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, '電子書籍最新' , array('description' => '最新の電子書籍を表示します'));
	}

	/**
	 *
	 * @global wpdb $wpdb
	 * @param array $args
	 * @param array $instance 
	 */
	function widget( $args, $instance ) {
		global $wpdb;
		// Widget output
		extract($args);
		extract($instance);
		echo $before_widget;
		echo $before_title . $title . $after_title;
		?>
		<ul class="widgets-ebook">
		<?php
			$query_string = array(
				"post_type" => "ebook",
				"post_status" => "publish",
				"posts_per_page" => $number,
				"orderby" => "rand"
			);
			if(is_singular('ebook')){
				$query_string["post__not_in"] = array(get_the_ID());
			}
			$query = new WP_Query($query_string);
			$counter = 0;
			if($query->have_posts()): while($query->have_posts()): $query->the_post(); $counter++;
				$class = '';
				if(lwp_is_free()){
					$class = ' ebook-free';
				}elseif(lwp_on_sale()){
					$class = ' ebook-on-sale';
				}
				$attachment = get_children("post_parent=".get_the_ID()."&post_type=attachment&post_mime_type=image&orderby=menu_order&order=ASC&numberposts=1");
		?>
			<li class="clearfix widgets-ebook-content ebook-list<?php echo $counter.$class; ?>">
				<a href="<?php the_permalink(); ?>">
					<?php if(!empty($attachment)): ?>
						<?php echo wp_get_attachment_image(current($attachment)->ID, 'pinky-cover'); ?>
					<?php else: ?>
						<img class="attachment-pinky-cover" src="<?php bloginfo('template_directory'); ?>/styles/img/archive_nophoto_ebook.png" width="90" height="120" alt="<?php the_title();  ?>" />
					<?php endif; ?>
				</a>
				<h4>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<strong class="price old"><?php echo lwp_the_price();?></strong>
				</h4>
				<p class="excerpt">
					<?php echo fumiki_trim(get_the_excerpt(), 40); ?>
				</p>
				<?php if(lwp_on_sale()): ?>
					<img class="sale-icon" src="<?php bloginfo('template_directory'); ?>/styles/img/icon-sale-32.png" width="32" height="32" alt="Sale" />
				<?php elseif(lwp_is_free()):?>
					<img class="sale-icon" src="<?php bloginfo('template_directory'); ?>/styles/img/icon-free-32.png" width="32" height="32" alt="Free" />
				<?php endif;?>
			</li>
		<?php endwhile; endif; wp_reset_query();?>
		</ul>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		return $new_instance;
	}

	/**
	 * フォームを出力する
	 * @param array $instance
	 * @reutrn void
	 */
	function form( $instance ) {
		extract(shortcode_atts(array(
			'title' => '電子書籍',
			'number' => 5,
			'duration' => 3000
		), $instance));
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">タイトル</label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">表示数</label> 
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('duration'); ?>">表示時間<small>（ミリ秒）</small></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('duration'); ?>" name="<?php echo $this->get_field_name('duration'); ?>" type="text" value="<?php echo $duration; ?>" />
		</p>
		<?php
	}
}