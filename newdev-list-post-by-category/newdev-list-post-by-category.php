<?php
/**
 *
 * @package   newdev-list-post-by-category
 * @author    Your Name <hello@newdev.co>
 * @license   GPL-2.0+
 * @link      http://newdev.co
 * @copyright NewDev
 *
 * @wordpress-plugin
 * Plugin Name:       List posts by category
 * Plugin URI:        http://code.newdev.co/nd-list-posts-by-category
 * Description:       Lists posts by the main category on the single.php view
 * Version:           3.0.0
 * Author:            NewDev
 * Author URI:        http://newdev.co
 * Text Domain:       nd-lpbc
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 * GitHub Plugin URI: https://github.com/crissoca/newdev-list-post-by-category
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ND_List_Post_by_Category' ) ) :

	final class ND_List_Post_by_Category {

		/**
		 * @since    1.0.0
		 *
		 * @var      string
		 */
		public $plugin_slug = 'nd-lpbc';

		/**
		 * @var The single instance of the class
		 * @since 2.1
		 */
		protected static $_instance = null;

		/**
		 * Main Instance
		 *
		 * Ensures only one instance is loaded or can be loaded.
		 *
		 * @since 2.1
		 * @static
		 * @see nd_lpbc()
		 * @return Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/*--------------------------------------------------*/
		/* Constructor
		/*--------------------------------------------------*/

		/**
		 * Specifies the classname and description, instantiates the widget,
		 * loads localization files, and includes necessary stylesheets and JavaScript.
		 */
		public function __construct() {

			// load plugin text domain
			add_action( 'init', array( $this, 'nd_lpbc_lang' ) );
			$this->includes();

			// Hooks fired when the Widget is activated and deactivated
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		} // end constructor

		/**
		 * Return the widget slug.
		 *
		 * @since    1.0.0
		 *
		 * @return    Plugin slug variable.
		 */
		public function get_plugin_slug() {
			return $this->plugin_slug;
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/*--------------------------------------------------*/
		/* Public Functions
		/*--------------------------------------------------*/

		/**
		 * Loads the Widget's text domain for localization and translation.
		 */
		public function nd_lpbc_lang() {

			// TODO be sure to change 'nd-lpbc' to the name of *your* plugin
			load_plugin_textdomain( $this->get_plugin_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

		} // end nd_lpbc_lang

		/**
		 * Fired when the plugin is activated.
		 *
		 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
		 */
		public function activate( $network_wide ) {
			// TODO define activation functionality here
		} // end activate

		/**
		 * Fired when the plugin is deactivated.
		 *
		 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
		 */
		public function deactivate( $network_wide ) {
			// TODO define deactivation functionality here
		} // end deactivate

		/**
		 * Include required frontend files.
		 */
		public function includes() {
			include_once( 'includes/nd-lpbc-widgets.php' );
			//include_once( 'includes/class-nd-lpbc-shortcodes.php' );
		}

		/**
		 * Include required frontend files.
		 */
		public function get_the_taxonomy( $id = false, $taxonomy = 'category' ) {

			$taxonomies = get_the_terms( $id, $taxonomy );

			if ( ! $taxonomies || is_wp_error( $taxonomies ) )
				$taxonomies = array();

			$taxonomies = array_values( $taxonomies );

			return apply_filters( 'get_the_taxonomy', $taxonomies );

		}

		/**
		 * Looks for a template inside a theme if it's not there it fallsback on the plugin default template
		 */
		public function nd_template_loader( $file_name ) {

			$check_dirs = array(
				trailingslashit( get_stylesheet_directory() ) . $this->get_plugin_slug(),
				trailingslashit( get_template_directory() ) . $this->get_plugin_slug(),
				trailingslashit( get_stylesheet_directory() ),
				trailingslashit( get_template_directory() ),
				trailingslashit( $this->plugin_path() ) . 'views/'
			);

			foreach ( $check_dirs as $dir ) {
				if ( file_exists( trailingslashit( $dir ) . $file_name ) ) {
					return trailingslashit( $dir ) . $file_name;
				}
			}

		}

	}

endif;

function nd_lpbc() {
	return ND_List_Post_by_Category::instance();
}

$GLOBALS['ND_List_Post_by_Category'] = nd_lpbc();