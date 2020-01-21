<?php

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'Theme_Widget_Popular_Posts' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


class Theme_Widget_Popular_Posts extends WP_Widget {

	function __construct() {

		$widget_ops = array(
			'classname'   => 'widget--popular-posts',
			'description' => 'displays popular posts',
		);
		parent::__construct( 'popular_posts', 'Popular Posts', $widget_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );
		$title  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number = $instance['number'];
		$cat    = $instance['cat'];

		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$args                        = array();
		$args['posts_per_page']      = 4;
		$args['meta_key']      = 'modula_post_views_count';
		$args['orderby']      = 'meta_value_num';
		$args['order']           = 'desc';


		$query                       = new WP_Query( $args );

		ob_start();
		?>

			<ul>

			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>

					<li>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						<?php get_template_part( 'partials/post-details' ); ?>
					</li>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

			</ul>

		<?php
		$output = ob_get_clean();

		echo $output;

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		//sanitize the arguments
		$instance           = $old_instance;
		$instance['title']  = isset( $new_instance['title'] ) ? esc_attr( $new_instance['title'] ) : 'Popular Posts';


		return $instance;
	}

	function form( $instance ) {

		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Popular Posts';


		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

		<?php
	}
}

new Theme_Widget_Popular_Posts();


