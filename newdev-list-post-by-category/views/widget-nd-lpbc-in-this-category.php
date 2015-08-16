<?php
/**
 * List post by category Widget Functions
 *
 * Widget front end view
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

$nd_article_wrapper = current_theme_supports('html5') == true ? 'article' : 'div';

if ( ! empty( $instance['title'] ) ) {
	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
}

/**
 * @todo  Option not available in this widget, just preparing for future widget.
 */
$nd_default_tax = ! empty( $instance['default_tax'] ) ? $instance['default_tax'] : 'category';

$nd_img_size   = ! empty( $instance['img_size'] ) ? $instance['img_size'] : 'thumbnail';

$nd_max_posts  = ! empty( $instance['max_posts'] ) ? (int)$instance['max_posts'] : 3;

$nd_tax_title  = ! empty( $instance['cat_title'] ) ? $instance['cat_title'] : __( 'Other Categories', nd_lpbc()->get_plugin_slug() );

$nd_tax_exclude = ! empty( $instance['exclude_tax'] ) ? explode(',', $instance['exclude_tax']) : '';

$nd_tax_depth = ! empty( $instance['tax_depth'] ) ? $instance['tax_depth'] : 0;

$nd_tax_number = ! empty( $instance['tax_number'] ) ? $instance['tax_number'] : 0;

echo '<div class="'. self::get_widget_slug() .'_wrapper">' . "\n";

	$taxonomy = nd_lpbc()->get_the_taxonomy( get_the_ID(), $nd_default_tax );

	if ( ! empty( $taxonomy ) ) {
		$nd_curr_tax = $taxonomy[0]->term_id;

		if ( ! empty( $nd_curr_tax ) )
			$nd_tax_exclude[] = $nd_curr_tax;

		echo '<h2 class="lpbc-category-title">' . esc_html( $taxonomy[0]->name ) . '</h2>';
	}

	echo '<div class="lpbc-content">' . "\n";

		$args = array(
			//Category Parameters
			'cat'                 => $nd_curr_tax,
			//Type & Status Parameters
			'post_status'         => 'publish',
			//Order & Orderby Parameters
			'orderby'             => 'rand',
			//Ignores All Sticky Posts
			'ignore_sticky_posts' => true,
			//Pagination Parameters
			'posts_per_page'      => $nd_max_posts,
		);

		$nd_query = new WP_Query( $args );

		if ( $nd_query->have_posts() ) : while ( $nd_query->have_posts() ) : $nd_query->the_post();

			$post_id = get_the_id();

			echo '<'. $nd_article_wrapper .' class="lpbc-related-article">' . "\n";
			echo "\t" . '<a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . the_title_attribute ( array( 'echo' => false ) ) . '">' . get_the_post_thumbnail( $post_id, $nd_img_size, array( 'class' => 'lpbc-post-image' ) ) . '</a>' . "\n";
			echo "\t" . '<h3><a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . the_title_attribute ( array( 'echo' => false ) ) . '">' . get_the_title() . '</a></h3>' . "\n";
			echo '</'. $nd_article_wrapper .'>' . "\n";

		endwhile; endif; wp_reset_postdata();


		/**
		 * Lists the other taxonomies
		 */

		$nd_cat_args = array(
			'title_li'   => $nd_tax_title,
			'exclude'    => implode(',', $nd_tax_exclude),
			'echo'       => false,
			'depth'      => $nd_tax_depth,
			'number'     => $nd_tax_number,
		);

		echo '<ul class="lpbc-other-categories list-unstyled">' . "\n";

			echo wp_list_categories( $nd_cat_args );

		echo '</ul>' . "\n";

	echo '</div>' . "\n"; //.lpbc-content

echo '</div>' . "\n";
