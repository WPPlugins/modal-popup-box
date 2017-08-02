<?php
/**
Plugin Name: Modal Popup Box
Plugin URI: http://awplife.com/
Description: A set of experimental modal window appearance effects with CSS transitions and animations.An Easy And Powerful modal popup box plugin for wordpress.
Version: 0.1.5
Author: A WP Life
Author URI: http://awplife.com/
License: GPLv2 or later
Text Domain: awl-modal-popup-box
Domain Path: /languages

*/

if ( ! class_exists( 'Modal_Popup_Box' ) ) {

	class Modal_Popup_Box {
		
		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'MPB_PLUGIN_VER', '0.1.4' );
			
			//Plugin Text Domain
			define("MPB_TXTDM","awl-modal-popup-box" );

			//Plugin Name
			define( 'MPB_PLUGIN_NAME', __( 'Modal Popup Box', 'MPB_TXTDM' ) );

			//Plugin Slug
			define( 'MPB_PLUGIN_SLUG', 'modalpopupbox' );

			//Plugin Directory Path
			define( 'MPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'MPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'MPB_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_srgallery_menu' ), 101 );
			
			//Create Image Gallery Custom Post
			add_action( 'init', array( $this, 'codex_modalpopupbox_init' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, '_admin_add_meta_box' ) );
			
			//save setting 
			add_action('save_post', array(&$this, '_mpb_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');

		} // end of hook function
		
		public function _load_textdomain() {
			load_plugin_textdomain( 'sr_txt_dm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function _srgallery_menu() {
			$featured_plugin_menu = add_submenu_page( 'edit.php?post_type='.MPB_PLUGIN_SLUG, __( 'Featured-Plugin', 'sr_txt_dm' ), __( 'Featured Plugin', 'sr_txt_dm' ), 'administrator', 'sr-featured-plugin-page', array( $this, '_featured_plugin_page') );
			$buy_plugin_page = add_submenu_page( 'edit.php?post_type='.MPB_PLUGIN_SLUG, __( 'Upgrade Plugin', 'sr_txt_dm' ), __( 'Upgrade Plugin', 'sr_txt_dm' ), 'administrator', 'sr-upgrade-mpb-page', array( $this, '_buy_mpb_page') );
		}
		
	
		// Modal Popup Box Custom Post Type
		function codex_modalpopupbox_init() {
			$labels = array(
				'name'               => _x( 'Modal Popup Box', 'post type general name', 'your-plugin-textdomain' ),
				'singular_name'      => _x( 'Modal Popup Box', 'post type singular name', 'your-plugin-textdomain' ),
				'menu_name'          => _x( 'Modal Popup Box', 'admin menu', 'your-plugin-textdomain' ),
				'name_admin_bar'     => _x( 'Modal Popup Box', 'add new on admin bar', 'your-plugin-textdomain' ),
				'add_new'            => _x( 'Add New', 'Modal Popup Box', 'your-plugin-textdomain' ),
				'add_new_item'       => __( 'Add New Modal Popup Box', 'your-plugin-textdomain' ),
				'new_item'           => __( 'New Modal Popup Box', 'your-plugin-textdomain' ),
				'edit_item'          => __( 'Edit Modal Popup Box', 'your-plugin-textdomain' ),
				'view_item'          => __( 'View Modal Popup Box', 'your-plugin-textdomain' ),
				'all_items'          => __( 'All Modal Popup Box', 'your-plugin-textdomain' ),
				'search_items'       => __( 'Search Modal Popup Box', 'your-plugin-textdomain' ),
				'parent_item_colon'  => __( 'Parent Modal Popup Box:', 'your-plugin-textdomain' ),
				'not_found'          => __( 'No Modal Popup Box found.', 'your-plugin-textdomain' ),
				'not_found_in_trash' => __( 'No Modal Popup Box found in Trash.', 'your-plugin-textdomain' )
				
			);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Description.', 'your-plugin-textdomain' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'modalpopupbox' ),
				'capability_type'    => 'page',
				'menu_icon'           => 'dashicons-archive',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title','editor')
				
			);

			register_post_type( 'modalpopupbox', $args );
		}
		
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Modal Box Settings', MPB_TXTDM), array(&$this, 'mpb_metabox_function'), 'modalpopupbox', 'normal', 'default' );
		}
		
		public function mpb_metabox_function($post) { 
			wp_enqueue_script('jquery');
			
			//css
			wp_enqueue_style('mbp-bootstrap-css', MPB_PLUGIN_URL . 'css/bootstrap.css');
			wp_enqueue_style('mbp-font-awesome-css', MPB_PLUGIN_URL . 'css/font-awesome.css');
			wp_enqueue_style('mbp-animate-css', MPB_PLUGIN_URL.'css/animate.css' );			
			wp_enqueue_style('mbp-styles-css', MPB_PLUGIN_URL.'css/styles.css' );			
			
			//js
			wp_enqueue_style('wp-color-picker' );
			wp_enqueue_script('mbp-bootstrap-js', MPB_PLUGIN_URL .'js/bootstrap.js', array('jquery'), '' , true);
			wp_enqueue_script('mbp-color-picker-js', MPB_PLUGIN_URL .'js/mb-color-picker.js', array( 'wp-color-picker' ), false, true );
			?>
			<h1><?php _e('Copy Modal Popup Box Shortcode', MPB_TXTDM); ?></h1>
			<hr>
			<p class="input-text-wrap">
				<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your Modal popup box on site.', MPB_TXTDM); ?><br></p>
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[MPBOX id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" >
			</p>
			<br>
			<br>
			<h1><?php _e('Modal Popup Box Setting', MPB_TXTDM); ?></h1>
			<hr>
			<?php
			require_once("modal-popup-box-settings.php");
		} // end of upload multiple image
		
		public function _mpb_save_settings($post_id) {
			if(isset($_POST['mpb_save_nonce'])) {
				if ( !isset( $_POST['mpb_save_nonce'] ) || !wp_verify_nonce( $_POST['mpb_save_nonce'], 'mpb_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					$awl_modal_popup_box_shortcode_setting = "awl_mpb_settings_".$post_id;
					update_post_meta($post_id, $awl_modal_popup_box_shortcode_setting, base64_encode(serialize($_POST)));
				}	
			}
		}// end save setting
	
		public function _featured_plugin_page() {
			require_once('featured-plugins/featured-plugins.php');
		}
		public function _buy_mpb_page() {
			require_once('buy-mpb-premium.php');
		}
	
	} // end of class

	/**
	 * Instantiates the Class
	 * @since     3.0
	 * @global    object	$ig_gallery_object
	 */
	$mpbox_object = new Modal_Popup_Box();
	require_once('modal-popup-box-shortcode.php');
	
} // end of class exists
?>