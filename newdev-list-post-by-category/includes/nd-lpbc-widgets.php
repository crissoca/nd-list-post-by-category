<?php
/**
 * NewDev Widget Functions
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

// Include widget classes
include_once( 'widgets/class-nd-lpbc-in-this-category.php' );

/**
 * Register Widgets
 *
 * @since 1.0
 */
function nd_register_widgets() {

	register_widget( 'ND_LPBC_Category_Posts' );

}
add_action( 'widgets_init', 'nd_register_widgets' );
