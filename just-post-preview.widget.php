<?php


/**
 * JPP_Widget_Post_Preview widget class
 * 
 * Show post preview with different layouts with post link
 * 
 */
class JPP_Widget_Post_Preview extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
				'jpp_widget_post_preview',  // Base ID
				__('Just Post Preview'),	// Title
				array( 'description' => __( "Post preview with different layouts") )
			);
	}

	public static function admin_scripts(){
		// exit if we not on widget pages or post edit
		if( strpos($_SERVER['SCRIPT_NAME'], 'widgets.php') === FALSE &&
				strpos($_SERVER['SCRIPT_NAME'], 'post.php') === FALSE &&
				strpos($_SERVER['SCRIPT_NAME'], 'post-new.php') === FALSE
			){
			return;
		}
		
		wp_register_script( 'jpp_post_preview_widget_js', JPP_URL . 'assets/post_preview_widget.js', array('jquery','jquery-ui-autocomplete') );
		wp_enqueue_script('jpp_post_preview_widget_js');

		wp_register_style( 'jpp_post_preview_widget_css', JPP_URL . 'assets/post_preview_widget.css');
		wp_enqueue_style('jpp_post_preview_widget_css');
	}
	
	public function widget($args, $instance) {
		// apply defaults
		$instance = array_merge(array(
			'title' => '',
			'post_type' => 'post',
			'post_id' => 0,
			'widget_layout' => 'hero',
			'css_class' => 'jpp_widget',
		), $instance);

		$post = get_post($instance['post_id']);

		// print start widget
		echo $args['before_widget'];
		echo strtr('<div class="widget jpp_post_preview jpp_post_preview_{postid} jpp_layout_{layout} {extra_class}">', array(
			'{postid}' => $instance['post_id'],
			'{layout}' => $instance['widget_layout'],
			'{extra_class}' => $instance['css_class'],
		));
		
		// print layout
		$theme_dir = get_stylesheet_directory() . '/just-post-preview/';
		$plugin_dir = JPP_PATH . '/layouts/';
		
		$layout_file = 'jpp_layout_' . $instance['widget_layout'] . '.php';
		if( is_file($theme_dir . $layout_file) ){
			include($theme_dir . $layout_file);
		}
		elseif( is_file($plugin_dir . $layout_file) ){
			include($plugin_dir . $layout_file);
		}
		else{
			echo '<b>Fatal error: </b> Layout template file missing: ' . $theme_dir . $layout_file;
		}
		
		// print end widget
		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_type	= isset( $instance['post_type'] ) ? $instance['post_type'] : '';
		$post_title		= isset( $instance['post_title'] ) ? esc_attr( $instance['post_title'] ) : '';
		$post_id		= isset( $instance['post_id'] ) ? esc_attr( $instance['post_id'] ) : '';
		$widget_layout	= isset( $instance['widget_layout'] ) ? $instance['widget_layout'] : '';
		$css_class	= isset( $instance['css_class'] ) ? esc_attr( $instance['css_class'] ) : '';
?>
	<div class="jpp_form_controls">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Internal Title:' ); ?></label>
			<input readonly class="widefat jpp_post_preview_widget_title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:' ); ?></label>
			<select required class="widefat jpp_post_preview_post_type noinit" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php $this->html_options( $this->get_post_types_options(), $post_type ); ?>
			</select>
		</p>
				
		<p>
			<label for="<?php echo $this->get_field_id( 'post_title' ); ?>"><?php _e( 'Post title:' ); ?></label>
			<input required placeholder="Start type post title or insert post URL" class="widefat jpp_post_preview_post_title noinit" id="<?php echo $this->get_field_id( 'post_title' ); ?>" name="<?php echo $this->get_field_name( 'post_title' ); ?>" type="text" value="<?php echo $post_title; ?>" />
			<input type="hidden" class="jpp_post_preview_post_id" id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>" value="<?php echo $post_id; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_layout' ); ?>"><?php _e( 'Widget layout:' ); ?></label>
			<select required class="widefat" id="<?php echo $this->get_field_id( 'widget_layout' ); ?>" name="<?php echo $this->get_field_name( 'widget_layout' ); ?>">
				<?php $this->html_options( $this->get_available_layouts(), $widget_layout ); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'css_class' ); ?>"><?php _e( 'Additional CSS class:' ); ?></label>
			<input required class="widefat" id="<?php echo $this->get_field_id( 'css_class' ); ?>" name="<?php echo $this->get_field_name( 'css_class' ); ?>" type="text" value="<?php echo $css_class ?>" />
		</p>
	</div>
<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['post_id'] = strip_tags($new_instance['post_id']);
		$instance['post_title'] = strip_tags($new_instance['post_title']);
		$instance['widget_layout'] = strip_tags($new_instance['widget_layout']);
		$instance['css_class'] = strip_tags($new_instance['css_class']);
		
		return $instance;
	}
	
	protected function html_options( $options, $selected ){
		if( !is_array($options) ) return '';
		foreach( $options as $value => $label) {
			print strtr('<option value="{value}" {selected}>{label}</option>', array(
				'{value}' => esc_attr($value),
				'{selected}' => selected($selected, $value, false),
				'{label}' => esc_html($label),
			));
		}
	}
	
	protected function get_post_types_options(){
		$args = array( 'public' => true );
		$post_types = get_post_types($args, 'objects');
		$options = array();
		foreach($post_types as $pt){
			$label = $pt->labels->name;
			$value = $pt->name;
			
			$options[$value] = $label;
		}
		$options = apply_filters('jpp_post_preview_post_types', $options);
		return $options;
	}
	
	protected function get_available_layouts(){
		$layouts = array(
			'hero' => 'Hero post (Featured image as Background)',
			'left_image' => 'Excerpt with left aligned image',
			'right_image' => 'Excerpt with right aligned image',
		);
		
		$layouts = apply_filters('jpp_post_preview_layouts', $layouts);
		return $layouts;
	}

	
	public static function ajax_post_autocomplete(){
		$term = $_POST['term'];
		$post_type = $_POST['post_type'];
		if(empty($term)) die('');
		
		global $wpdb;

		$safe_post_type = mysql_escape_string($post_type);
		$safe_term = mysql_escape_string($term);

		// search by URL
		if( strpos($term, 'http') !== FALSE ){
			$post_name = basename( parse_url($term, PHP_URL_PATH) );
			$safe_term = mysql_escape_string($post_name);
			$query = "SELECT ID, post_title, post_type FROM $wpdb->posts WHERE post_status = 'publish' AND post_name LIKE '%$safe_term%' ORDER BY post_title LIMIT 10";
		}
		else{
			$query = "SELECT ID, post_title, post_type	FROM $wpdb->posts WHERE post_type = '$safe_post_type' AND post_status = 'publish' AND post_title LIKE '%$safe_term%' ORDER BY post_title LIMIT 10";
		}

		$posts = $wpdb->get_results($query);

		$response = array();
		foreach($posts as $post){
			$response[] = array(
				'label' => $post->post_title,
				'value' =>  $post->post_title,
				'post_type' => $post->post_type,
				'post_id' => $post->ID,
			);
		}

		$json = json_encode($response);
		header( "Content-Type: application/json" );

		echo $json;
		exit();
	}
	
}
