<?php
/**
 * display post list class
 */

/**
 * SCC_Post_Listing class
 *
 * @since 1.0.0
 */
class SCC_Post_Listing {

		
	/**
	 * Constructor for SCC_Post_Listing class
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// display post listing in content
		add_filter( 'the_content', array( $this, 'post_listing' ) );
		
		// load default post listing stylesheet
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
	}
	

	/**
	 * Determine a post's Course
	 *
	 * @since 1.0.0
	 */
	public function retrieve_course( $post_id ) {
		$course = wp_get_post_terms( $post_id, 'course' );
		if ( ! is_wp_error( $course ) && ! empty( $course ) && is_array( $course ) ) {
			$course = current( $course );
		} else {
			$course = false;
		}
		return $course;
	}
	

	/**
	 * add post listing to content
	 *
	 * @since 1.0.0
	 */
	public function post_listing( $content ) {
		global $post;
		if ( 'post' !== $post->post_type || ! is_main_query() )
			return $content;
		$course = $this->retrieve_course( $post->ID );
		if ( ! $course )
			return $content;
		wp_enqueue_script( 'scc-post-list-js' );

		// build the post listing based on course
		$args = array( 
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'asc',
			'tax_query'      => array(
				array(
					'taxonomy' => 'course',
					'field'    => 'slug',
					'terms'    => $course->slug
				)
			)
		);
		$the_posts  = get_posts( $args );
		$posts = 1;
		foreach ( $the_posts as $post_id ) {
			if ( $post_id == $post->ID ) {
				break;
			}
			$posts ++;
		}
		ob_start(); 
		if ( is_single() && sizeof( $the_posts ) > 1 ) :
			$array = get_option( 'taxonomy_' . $course->term_id );
			$post_list_title = $array['post_list_title'];
			$course_description = term_description( $course->term_id, 'course' );
			$full_course_text = apply_filters( 'full_course_text', __( 'full course', 'scc' ) );
			?>
			<div id="scc-wrap" class="scc-post-list">
				<?php if ( '' != $post_list_title ) : ?>
					<h3><?php echo $post_list_title; ?></h3>
				<?php endif; ?>
				<?php if ( $course_description != '' ) : ?>
					<?php echo $course_description; ?>
					<a href="#" class="scc-show-post-list"><?php echo $full_course_text; ?></a>
				<?php endif; ?>				
				<div class="scc-post-container">
					<ol>
						<?php foreach ( $the_posts as $key => $post_id ) : ?>
							<li>
								<?php 
								if ( ! is_single( $post_id ) ) { 
									echo '<a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
								} else {
									echo '<span class="scc-current-post">' . get_the_title( $post_id ) . '</span>';
								}	
								?>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
			</div>
		<?php endif;
		$post_listing = ob_get_clean();		
		$content = $post_listing . $content . $post_listing;
		return $content;
	}
	

	/**
	 * setup stylesheet and script for post listing 
	 *
	 * @since 1.0.0
	 */
	public function frontend_styles() {
		wp_register_script( 'scc-post-list-js', SCC_URL . 'inc/assets/js/scc-post-listing.js', array( 'jquery' ), SCC_VERSION, true );
		wp_register_style( 'scc-post-listing-css', SCC_URL . 'inc/assets/css/scc-post-listing.css' );
		wp_enqueue_style( 'scc-post-listing-css' );
	}
}

new SCC_Post_Listing();