<?php
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
		$options = get_option( 'display_position' );
		
		if ( 'post' !== $post->post_type || ! is_main_query() )
			return $content;
			
		$course = $this->retrieve_course( $post->ID );
		
		if ( ! $course )
			return $content;
			
		wp_enqueue_script( 'scc-post-list-js' );
		
		ob_start(); 	
			
		// include the appropriate template file
		$this->get_template( 'scc-output.php', array( 
			'course'			=> $course, 
			'description'		=> $course_description,
			'course_posts'		=> $the_posts,
			'posts'				=> $posts
		) );
		
		$post_listing = ob_get_clean();	
		
		// display full course based on display settings
		switch ( $options['list_position'] ) :
			case 'below':
				$content = $content . $post_listing;
				break;
			case 'both':
				$content = $post_listing . $content . $post_listing;
				break;
			case 'hide':
				$content = $content;
				break;
			default:
				$content = $post_listing . $content;
		endswitch;
				
		return $content;
	}
	

	/**
	 * get and include template files
	 *
	 * @since 1.0.0
	 */
	public function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array($args) )
			extract( $args );

		include( $this->locate_template( $template_name, $template_path, $default_path ) );
	}
	

	/**
	 * locate a template and return the path for inclusion
	 *
	 * @since 1.0.0
	 */
	public function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path )
			$template_path = 'scc_templates';
		if ( ! $default_path )
			$default_path  = SCC_DIR . 'inc/scc_templates/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name
			)
		);

		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;

		// Return what we found
		return $template;
	}
	

	/**
	 * setup stylesheet and script for post listing 
	 * 
	 * @credits stylesheet hierarchy approach by Easy Digital Downloads
	 * @since 1.0.0
	 */
	public function frontend_styles(  ) {
		wp_register_script( 'scc-post-list-js', SCC_URL . 'inc/assets/js/scc-post-listing.js', array( 'jquery' ), SCC_VERSION, true );

		$child_theme_scc_style = trailingslashit( get_stylesheet_directory() ) . 'scc_templates/scc.css';
		$parent_theme_scc_style = trailingslashit( get_template_directory() ) . 'scc_templates/scc.css';
		
		if ( file_exists( $child_theme_scc_style ) ) :
			$primary_style = trailingslashit( get_stylesheet_directory_uri() ) . 'scc_templates/scc.css';
		elseif ( file_exists( $parent_theme_scc_style ) ) :
			$primary_style = trailingslashit( get_template_directory_uri() ) . 'scc_templates/scc.css';
		else :
			$primary_style = SCC_URL . 'inc/scc_templates/scc.css';
		endif;
		
		wp_register_style( 'scc-post-listing-css', $primary_style );
		wp_enqueue_style( 'scc-post-listing-css' );
	}
}
new SCC_Post_Listing();