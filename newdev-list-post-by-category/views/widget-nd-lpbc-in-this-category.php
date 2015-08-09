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

$article_wrapper = current_theme_supports('html5') == true ? 'article' : 'div';

if ( ! empty( $instance['title'] ) ) {
	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
}

$img_size = $instance['img_size'] ? $instance['img_size'] : 'thumbnail';

$nd_max_posts = $instance['max_posts'] ? (int)$instance['max_posts'] : 3;

echo '<div class="'. $this->get_widget_slug() .'_wrapper">' . "\n";

	$categories = get_the_category();

	if ( ! empty( $categories ) ) {
		$curr_cat = $categories[0]->term_id;
		echo '<h2 class="lpbc-category-title">' . esc_html( $categories[0]->name ) . '</h2>';
	}

	echo '<div class="lpbc-content">' . "\n";

		$args = array(
			//Category Parameters
			'cat'                 => $curr_cat,
			//Type & Status Parameters
			'post_status'         => 'publish',
			//Order & Orderby Parameters
			'orderby'             => 'rand',
			'ignore_sticky_posts' => true,
			//Pagination Parameters
			'posts_per_page'      => $nd_max_posts,
		);

		$nd_query = new WP_Query( $args );

		if ( $nd_query->have_posts() ) : while ( $nd_query->have_posts() ) : $nd_query->the_post();

			echo '<'. $article_wrapper .' class="lpbc-related-article">' . "\n";
			echo "\t" . '<a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . the_title_attribute ( array( 'echo' => false ) ) . '">' . get_the_post_thumbnail( $post_id, $img_size, array( 'class' => 'lpbc-post-image' ) ) . '</a>' . "\n";
			echo "\t" . '<h1><a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . the_title_attribute ( array( 'echo' => false ) ) . '">' . get_the_title() . '</a></h1>' . "\n";
			echo '</'. $article_wrapper .'>' . "\n";

		endwhile; endif; wp_reset_postdata();

		$cat_args = array(
			'title_li' => __( 'Other Channels', nd_lpbc()->get_plugin_slug() ),
			'exclude'  => $curr_cat,
			'echo'     => false,
		);

		echo '<ul class="lpbc-other-categories">' . "\n";

			echo wp_list_categories( $cat_args );

		echo '</ul>' . "\n";

	echo '</div>' . "\n"; //.lpbc-content

echo '</div>' . "\n";
