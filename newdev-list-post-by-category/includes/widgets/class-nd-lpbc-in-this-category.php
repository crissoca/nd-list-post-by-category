<?php
/**
 * List post by category Widget Functions
 *
 * Widget related functions and widget registration
 *
 * @author    NewDev <hello@newdev.co>
 * @package   List posts by category/widgets
 * @license   GPL-2.0+
 * @link      http://newdev.co
 * @copyright NewDev
 * @version   1.0
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

class ND_LPBC_Category_Posts extends WP_Widget {

    /**
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0
     *
     * @var      string
     */
    static $widget_slug = 'lpbc-in-this-category';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		$this->widget_cssclass    = self::get_widget_slug() . '-class';
		$this->widget_description = __( 'List related posts by category.', self::get_widget_slug() );
		$this->widget_name        = __( 'List related posts by category', self::get_widget_slug() );

		parent::__construct(

			self::get_widget_slug(),
			$this->widget_name,
			array(
				'classname'   => $this->widget_cssclass,
				'description' => $this->widget_description
			)
		);

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor

	/**
	 * Return the widget slug.
	 *
	 * @since    1.0
	 *
	 * @return    Widget slug variable.
	 */
	static function get_widget_slug() {
	    return self::$widget_slug;
	}

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {


		// Check if there is a cached output
		$cache = wp_cache_get( self::get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( isset ( $cache[ self::get_widget_slug() ] ) )
			return print $cache[ self::get_widget_slug() ];

		// go on with your widget logic, put everything into a string and …

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		ob_start();
		include( nd_lpbc()->nd_template_loader( 'widget-nd-lpbc-in-this-category.php' ) );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ self::get_widget_slug() ] = $widget_string;

		wp_cache_set( self::get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget


	public function flush_widget_cache() {

    	wp_cache_delete( self::get_widget_slug(), 'widget' );

	}
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array_map('strip_tags', $new_instance);

		$this->flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');

		if ( isset( $alloptions[self::get_widget_slug()] ) ) {

			delete_option(self::get_widget_slug());

		}

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		// TODO: Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance
		);

		// TODO: Store the values of the widget in their own variable

		// Display the admin form
		include( trailingslashit( nd_lpbc()->plugin_path() ) . 'views/admin-nd-lpbc-in-this-category.php' );

	} // end form

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( self::get_widget_slug().'-widget-styles', plugins_url( 'css/widget-nd-lpbc-in-this-category.css', dirname( dirname(__FILE__) ) ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		//wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', dirname( dirname(__FILE__) ) ), array('jquery') );

	} // end register_widget_scripts

} // end class