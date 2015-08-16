<?php
/**
 * List post by category Widget Functions
 *
 * Widget back end form
 *
 * @author    NewDev <hello@newdev.co>
 * @package   List posts by category/widgets
 * @license   GPL-2.0+
 * @link      http://newdev.co
 * @copyright NewDev
 * @version   1.0
 * @todo      Add more options to the post query
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

$nd_title = ! empty( $instance['title'] ) ? $instance['title'] : "";
$nd_img_size = ! empty( $instance['img_size'] ) ? $instance['img_size'] : 'thumbnail';
$nd_max_posts = ! empty( $instance['max_posts'] ) ? (int)$instance['max_posts'] : 3;

$nd_tax_title  = ! empty( $instance['cat_title'] ) ? $instance['cat_title'] : __( 'Other Categories', nd_lpbc()->get_plugin_slug() );

$nd_tax_exclude = ! empty( $instance['exclude_tax'] ) ? $instance['exclude_tax'] : '';

$nd_tax_depth = ! empty( $instance['tax_depth'] ) ? $instance['tax_depth'] : 0;

$nd_tax_number = ! empty( $instance['tax_number'] ) ? $instance['tax_number'] : 0;

$sizes = get_intermediate_image_sizes();

$widget_form = '';
$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'title' ) . '">' . __( 'Title:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'title' ) . '" name="' . parent::get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $nd_title ) . '">' . "\n";
$widget_form .= '</p>' . "\n";
$widget_form .= "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'img_size' ) . '">' . __( 'Thumbnail Size:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<select id="' . parent::get_field_id( 'img_size' ) . '" name="' . parent::get_field_name('img_size') . '" >' . "\r\n";
$widget_form .= '<option value="0" selected="selected">Choose</option>' . "\r\n";
foreach ( $sizes as $size ) {
    if ( $nd_img_size == $size ) :
        $widget_form .= '<option value="' . $size . '" selected="selected">' . $size . '</option>' . "\r\n";
    else :
        $widget_form .= '<option value="' . $size . '">' . $size . '</option>' . "\r\n";
    endif;
}
$widget_form .= '</select>' . "\r\n";
$widget_form .= '</p>' . "\n";
$widget_form .= "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'max_posts' ) . '">' . __( 'Post Limit:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'max_posts' ) . '" name="' . parent::get_field_name( 'max_posts' ) . '" type="number" min="0" value="' . esc_attr( $nd_max_posts ) . '">' . "\n";
$widget_form .= '</p>' . "\n";

$widget_form .= '<strong>Other Categories Options</strong>' . "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'cat_title' ) . '">' . __( 'Other Categories Title:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'cat_title' ) . '" name="' . parent::get_field_name( 'cat_title' ) . '" type="text" value="' . esc_attr( $nd_tax_title ) . '">' . "\n";
$widget_form .= '</p>' . "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'exclude_tax' ) . '">' . __( 'Categories to exclude:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'exclude_tax' ) . '" name="' . parent::get_field_name( 'exclude_tax' ) . '" type="text" value="' . esc_attr( $nd_tax_exclude ) . '">' . "\n";
$widget_form .= '<small>Add comma a comma-separated list of category ids. e.g. <tt>1,2,3</tt></small>' . "\n";
$widget_form .= '</p>' . "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'tax_depth' ) . '">' . __( 'Categories List Depth:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'tax_depth' ) . '" name="' . parent::get_field_name( 'tax_depth' ) . '" type="number" min="-1" value="' . esc_attr( $nd_tax_depth ) . '">' . "\n";
$widget_form .= '</p>' . "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . parent::get_field_id( 'tax_number' ) . '">' . __( 'Categories Limit:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . parent::get_field_id( 'tax_number' ) . '" name="' . parent::get_field_name( 'tax_number' ) . '" type="number" min="0" value="' . esc_attr( $nd_tax_number ) . '">' . "\n";
$widget_form .= '</p>' . "\n";

echo $widget_form;
