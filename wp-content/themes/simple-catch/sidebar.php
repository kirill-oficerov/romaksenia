<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.0
 */
 
	global $post;
	if( $post )
		$layout = get_post_meta( $post->ID,'simplecatch-sidebarlayout', true ); 
		
	if( empty( $layout ) || ( !is_page() && !is_single() ) )
		$layout='default';
		
	global $simplecatch_options_settings;
    $options = $simplecatch_options_settings;
	
	$themeoption_layout = $options['sidebar_layout'];
	
	if( $layout=='left-sidebar' ||( $layout=='default' && $themeoption_layout == 'left-sidebar') ) {
		echo '<div id="sidebar" class="col4 no-margin-left">';
	} else {
		echo '<div id="sidebar" class="col4">';
	} 

	if ( function_exists( 'dynamic_sidebar' ) ) {
		//displays 'sidebar' for all pages
		dynamic_sidebar( 'sidebar' ); 
	}






$defaults = array( 'title' => __('Example', 'example'), 'name' => __('Bilal Shaheen', 'example'), 'show_info' => true );
$instance = wp_parse_args( (array) $instance, $defaults );
	?>








<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Your Name:', 'example'); ?></label>
	<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
</p>
<p>
	<input class="checkbox" type="checkbox" <?php checked( $instance['show_info'], true ); ?> id="<?php echo $this->get_field_id( 'show_info' ); ?>" name="<?php echo $this->get_field_name( 'show_info' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_info' ); ?>"><?php _e('Display info publicly?', 'example'); ?></label>
</p>










	</div><!-- #sidebar -->
	
	<?php 
	if(!( $layout=='left-sidebar' ||( $layout=='default' && $themeoption_layout == 'left-sidebar') ) ) {
		echo '<div class="row-end"></div>';
	}