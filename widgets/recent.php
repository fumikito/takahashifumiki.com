<?php
class Recent_Widget extends WP_Widget{
	
	
	function __construct(){
		parent::__construct(false, '投稿タイプ別最新投稿', array('description' => '投稿タイプ別に最新の投稿を表示します。'));
	}
	
	function widget($args, $instance) {
		extract($args);
		extract($instance);
		$query = new WP_Query("post_status=publish&post_type={$post_type}&posts_per_page={$number}");
		if($query->have_posts()){
			echo $before_widget;
			if(!empty($title)){
				printf('<h3><i class="fa-star"></i> %s</h3>', $title);
			}
			echo '<ol class="post-list">';
			while($query->have_posts()){
				$query->the_post();
				get_template_part('templates/loop', get_post_type());
			}
			wp_reset_postdata();
			echo '</ol>';
			echo $after_widget;
		}
	}
	
	
	function update($newinstance, $oldinstance){
		return $newinstance;
	}
	
	function form($instance){
		$atts = shortcode_atts(array(
			'title' => '最新の投稿',
			'post_type' => 'post',
			'number' => 10,
		), $instance);
		extract($atts);
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					タイトル<br />
					<input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('post_type'); ?>">
					投稿タイプ<br />
					<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
						<?php foreach(get_post_types(array('public' => true), 'objects') as $type) :  ?>
							<option value="<?php echo $type->name; ?>"<?php if($post_type == $type->name) echo ' selected="selected"';?>><?php echo $type->labels->name; ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('number'); ?>">
					件数<br />
					<input name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" value="<?php echo (int) $number; ?>" />
				</label>
			</p>
		<?php
	}
}
register_widget('Recent_Widget');