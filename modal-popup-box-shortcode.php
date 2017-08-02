<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_shortcode('MPBOX', 'awl_modal_popup_box_shortcode');
function awl_modal_popup_box_shortcode($post_id) {
	ob_start();
	//print_r($post_id);
	wp_enqueue_style('mbp-bootstrap-css', MPB_PLUGIN_URL . 'css/bootstrap.css');
	wp_enqueue_style('mbp-animate-css', MPB_PLUGIN_URL.'css/animate.css' );
	wp_enqueue_style('mbp-modal-box-css', MPB_PLUGIN_URL.'css/modal-box.css' );
	// modal box js and css
	wp_enqueue_style( 'mbp-component-css', MPB_PLUGIN_URL.'css/component-update.css' );
	wp_enqueue_script('mbp-modernizr-custom-js', MPB_PLUGIN_URL .'js/modal/modernizr.custom.js', array('jquery'), '', false);	// before body load
	wp_enqueue_script('mbp-classie-js', MPB_PLUGIN_URL .'js/modal/classie.js', array('jquery'), '' , true);
	wp_enqueue_script('mbp-cssParser-js', MPB_PLUGIN_URL .'js/modal/cssParser.js', array('jquery'), '' , true);
	
	//unserialize
	$modal_popup_box_settings = unserialize(base64_decode(get_post_meta( $post_id['id'], 'awl_mpb_settings_'.$post_id['id'], true)));
	$modal_popup_box_id = $post_id['id'];
	//print_r($modal_popup_box_settings);
	
	//Main Button
	if(isset($modal_popup_box_settings['mpb_show_modal'])) $mpb_show_modal = $modal_popup_box_settings['mpb_show_modal']; else $mpb_show_modal = "onclick";
	if(isset($modal_popup_box_settings['mpb_main_button_text'])) $mpb_main_button_text = $modal_popup_box_settings['mpb_main_button_text']; else $mpb_main_button_text = "Click Me";
	if(isset($modal_popup_box_settings['mpb_main_button_size'])) $mpb_main_button_size = $modal_popup_box_settings['mpb_main_button_size']; else $mpb_main_button_size = "btn btn-lg";
	if(isset($modal_popup_box_settings['mpb_main_button_color'])) $mpb_main_button_color = $modal_popup_box_settings['mpb_main_button_color']; else $mpb_main_button_color = "#008EC2";
	if(isset($modal_popup_box_settings['mpb_main_button_text_color'])) $mpb_main_button_text_color = $modal_popup_box_settings['mpb_main_button_text_color']; else $mpb_main_button_text_color = "#ffffff";

	//General Settings	
	//Animation Effect
	if(isset($modal_popup_box_settings['mpb_animation_effect_open_btn'])) $mpb_animation_effect_open_btn = $modal_popup_box_settings['mpb_animation_effect_open_btn']; else $mpb_animation_effect_open_btn = "md-effect-1" ;
	//Modal Box Height And Width
	if(isset($modal_popup_box_settings['mpb_width'])) $mpb_width = $modal_popup_box_settings['mpb_width']; else $mpb_width = 35;
	if(isset($modal_popup_box_settings['mpb_height'])) $mpb_height = $modal_popup_box_settings['mpb_height']; else $mpb_height = 350;
	//Custom CSS
	if(isset($modal_popup_box_settings['mpb_custom_css'])) $mpb_custom_css = $modal_popup_box_settings['mpb_custom_css']; else $mpb_custom_css = "";
	?>
	<style>	
	.md-content .mbox-title {
		margin: 0 !important;
		padding:20px !important;
		font-weight: bolder !important;
		background: rgba(0,0,0,0.1) !important;
	}
	.mpb-shotcode-buttons{
		margin-left: 4% !important;
	}
	.md-modal {
		width:<?php echo $mpb_width; ?>% !important; 
	}
	.md-content {
		height:<?php echo $mpb_height; ?>px !important;
	}
	.btn-bg-<?php echo $modal_popup_box_id; ?> {
		background-color:<?php echo $mpb_main_button_color; ?>;
		color:<?php echo $mpb_main_button_text_color; ?>;
	}
	.btn-default{
		cursor:pointer !important;
	}
	<?php echo $mpb_custom_css; ?>
	</style>
	<?php
	require('modal-popup-box-output.php');
	return ob_get_clean();
}
?>