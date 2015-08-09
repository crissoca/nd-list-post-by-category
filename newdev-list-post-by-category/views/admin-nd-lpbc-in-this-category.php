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

$title = ! empty( $instance['title'] ) ? $instance['title'] : "";
$img_size = ! empty( $instance['img_size'] ) ? $instance['img_size'] : 'thumbnail';
$max_posts = ! empty( $instance['max_posts'] ) ? (int)$instance['max_posts'] : 3;
$sizes = get_intermediate_image_sizes();

$widget_form = '';
$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '">' . "\n";
$widget_form .= '</p>' . "\n";
$widget_form .= "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . $this->get_field_id( 'img_size' ) . '">' . __( 'Thumbnail Size:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<select id="' . $this->get_field_id( 'img_size' ) . '" name="' . $this->get_field_name('img_size') . '" >' . "\r\n";
$widget_form .= '<option value="0" selected="selected">Choose</option>' . "\r\n";
foreach ( $sizes as $size ) {
    if ( $instance['img_size'] == $size ) :
        $widget_form .= '<option value="' . $size . '" selected="selected">' . $size . '</option>' . "\r\n";
    else :
        $widget_form .= '<option value="' . $size . '">' . $size . '</option>' . "\r\n";
    endif;
}
$widget_form .= '</select>' . "\r\n";
$widget_form .= '</p>' . "\n";
$widget_form .= "\n";

$widget_form .= '<p>' . "\n";
$widget_form .= '<label for="' . $this->get_field_id( 'max_posts' ) . '">' . __( 'Post Limit:', nd_lpbc()->get_plugin_slug() ) . '</label>' . "\n";
$widget_form .= '<input class="widefat" id="' . $this->get_field_id( 'max_posts' ) . '" name="' . $this->get_field_name( 'max_posts' ) . '" type="number" value="' . esc_attr( $max_posts ) . '">' . "\n";
$widget_form .= '</p>' . "\n";

echo $widget_form;
