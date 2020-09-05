<?php

class LDC_Custom_Code {

	// ------------------------------

	public static function admin_enqueue_scripts(){
		wp_enqueue_script('ace', plugin_dir_url(LDC_Custom_Code) . 'src-min/ace.js', [], '1.4.12', true);
	}

	// ------------------------------

	public static function admin_notices(){
		if(!is_plugin_active('meta-box/meta-box.php')){
			$child  = 'LDC Custom Code';
			$parent = 'Meta Box';
			printf('<div class="notice notice-warning"><p>' . esc_html('%1$s requires %2$s. Please install and/or activate %2$s before using %1$s.') . '</p></div>', '<strong>' . esc_html($child) . '</strong>', '<strong>' . esc_html($parent) . '</strong>');
		}
	}

	// ------------------------------

	public static function admin_print_footer_scripts(){ ?>
		<script>
			jQuery(document).on('ready', function(){
				if(typeof ace != 'undefined'){<?php
					foreach(['css', 'javascript'] as $mode){ ?>
						if(jQuery('#ldc_<?php echo $mode; ?>_editor').length){
							var ldc_<?php echo $mode; ?>_editor = ace.edit('ldc_<?php echo $mode; ?>_editor');
							ldc_<?php echo $mode; ?>_editor.$blockScrolling = Infinity;
							ldc_<?php echo $mode; ?>_editor.setOptions({
								maxLines: 25,
								minLines: 5
							});
							ldc_<?php echo $mode; ?>_editor.getSession().on('change', function() {
								jQuery('#ldc_<?php echo $mode; ?>_code').val(ldc_<?php echo $mode; ?>_editor.getSession().getValue()).trigger('change');
							});
							ldc_<?php echo $mode; ?>_editor.getSession().setMode('ace/mode/<?php echo $mode; ?>');
							ldc_<?php echo $mode; ?>_editor.getSession().setValue(jQuery('#ldc_<?php echo $mode; ?>_code').val());
						}<?php
					} ?>
				}
			});
		</script><?php
	}

	// ------------------------------

	public static function init(){
		foreach([
			'css' => 'CSS',
			'javascript' => 'JavaScript',
		] as $mode => $label){
			register_post_type('ldc_' . $mode . '_code', [
				'capability_type' => 'page',
				'label' => 'Custom ' . $label,
				'show_in_admin_bar' => false,
				'show_in_menu' => 'themes.php',
				'show_ui' => true,
				'supports' => ['title'],
			]);
		}
	}

	// ------------------------------

	public static function rwmb_meta_boxes($meta_boxes){
		foreach([
			'css' => 'CSS',
			'javascript' => 'JavaScript',
		] as $mode => $label){
			$meta_boxes[] = [
				'fields' => [
					[
						'id' => 'ldc_' . $mode . '_code',
						'sanitize_callback' => 'none',
						'type' => 'hidden',
					],
					[
						'id' => 'custom_html',
						'std' => '<div id="ldc_' . $mode . '_editor" style="border: 1px solid #e5e5e5; height: 0; margin-top: 6px; width: 100%;"></div>',
						'type' => 'custom_html',
					],
				],
				'post_types' => 'ldc_' . $mode . '_code',
				'title' => 'Custom ' . $label,
			];
		}
		return $meta_boxes;
	}

	// ------------------------------

	public static function wp_enqueue_scripts(){
		if(!wp_script_is('jquery')){
			wp_enqueue_script('jquery');
		}
	}

	// ------------------------------

	public static function wp_head(){
		$posts = get_posts([
			'post_type' => 'ldc_css_code',
			'posts_per_page' => -1,
		]);
		if($posts){
			echo '<style type="text/css" id="ldc-custom-css">';
			foreach($posts as $post){
				if(apply_filters('ldc_css_code', true, $post)){
					echo get_post_meta($post->ID, 'ldc_css_code', true);
				}
			}
			echo '</style>';
		}
	}

	// ------------------------------

	public static function wp_print_footer_scripts(){
		$posts = get_posts([
			'post_type' => 'ldc_javascript_code',
			'posts_per_page' => -1,
		]);
		if($posts){
			echo '<script type="text/javascript" id="ldc-custom-javascript">';
			foreach($posts as $post){
				if(apply_filters('ldc_javascript_code', true, $post)){
					echo '/* ' . $post->post_title . " */\n";
					echo trim(get_post_meta($post->ID, 'ldc_javascript_code', true)) . "\n";
				}
			}
			echo '</script>';
		}
	}

	// ------------------------------

}
