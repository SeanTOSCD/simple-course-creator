<?php
/**
 * output the HTML for post listings (course container)
 */
// build the post listing based on course
$the_posts  = get_posts( array( 
	'post_type'      => 'post',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'no_found_rows'  => true,
	'orderby'        => 'date',
	'order'          => 'asc',
	'tax_query'      => array(
		array( 'taxonomy' => 'course', 'field' => 'slug', 'terms' => $course->slug )
) ) );
$course_toggle = apply_filters( 'course_toggle', __( 'full course', 'scc' ) );
$posts = 1;		
foreach ( $the_posts as $post_id ) {
	if ( $post_id == $post->ID ) {
		break;
	}
	$posts ++;
}
$array = get_option( 'taxonomy_' . $course->term_id );
$post_list_title = $array['post_list_title'];
$course_description = term_description( $course->term_id, 'course' );
$list_option = get_option( 'list_type' );
$list_container = $list_option[ 'list_style_type' ] == 'ordered' ? 'ol' : 'ul';
$no_list = $list_option[ 'list_style_type' ] == 'none' ? 'style="list-style: none;"' : '';
/**
 * To override...
 * 
 * OPTION ONE
 * 
 * Create a folder called "scc_templates" in the root of your theme 
 * and COPY this file into it. It will override the default plugin template.
 *
 * OPTION TWO
 *
 * Notice the placement of multiple do_action() functions. It may be easier
 * hook into this template rather than override it. If you'd like to do so,
 * use the following PHP in your own theme functions file.
 *
 *			function your_function_name() { ?>
 *				-- your custom content --
 *			<?php }
 *			add_action( 'hook_name', 'your_function_name' );
 *
 * To change the "full course" link without overriding the template, use the
 * following PHP in your own theme functions file.
 *
 *			function your_filter_name( $content ) {
 *				$content = str_replace( 'full course', 'complete series', $content );
 *				return $content;
 *			}
 *			add_filter( 'course_toggle', 'your_filter_name' );
 */
?>

<?php if ( is_single() && sizeof( $the_posts ) > 1 ) :
	do_action( 'scc_before_container' );
	?>
	<div id="scc-wrap" class="scc-post-list">
		<?php 
		do_action( 'scc_container_top' );
		if ( $post_list_title != '' ) : ?>
			<h3 class="scc-post-list-title"><?php echo $post_list_title; ?></h3>
			<?php 
			do_action( 'scc_below_title' );
		endif;
		if ( $course_description != '' ) :
			echo $course_description;
			do_action( 'scc_below_description' );
		endif;
		?>
		<a href="#" class="scc-toggle-post-list">
			<?php 
			do_action( 'scc_before_toggle' ); 
			echo $course_toggle; 
			do_action( 'scc_after_toggle' ); 
			?>
		</a>
		<div class="scc-post-container">
			<?php do_action( 'scc_above_list' ); ?>
			<<?php echo $list_container; ?> class="scc-posts">
				<?php foreach ( $the_posts as $key => $post_id ) : ?>
					<li <?php echo $no_list; ?>>
						<?php do_action( 'scc_list_item' ); ?>
						<span class="scc-list-item">
							<?php 
							if ( ! is_single( $post_id ) ) :
								echo '<a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
							else :
								echo '<span class="scc-current-post">' . get_the_title( $post_id ) . '</span>';
							endif;
							?>
						</span>
					</li>
				<?php endforeach;
				do_action( 'scc_below_list' ); ?>
			</<?php echo $list_container; ?>>
		</div>
		<?php do_action( 'scc_container_bottom' ); ?>
	</div>
<?php 
do_action( 'scc_after_container' );
endif;