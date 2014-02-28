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
$posts = 1;		
foreach ( $the_posts as $post_id ) :
	if ( $post_id == $post->ID ) :
		break;
	endif;
	$posts ++;
endforeach;
$array = get_option( 'taxonomy_' . $course->term_id );
$post_list_title = $array['post_list_title'];
$course_description = term_description( $course->term_id, 'course' );
$list_option = get_option( 'list_type' );
$list_container = $list_option[ 'list_style_type' ] == 'ordered' ? 'ol' : 'ul';
$no_list = $list_option[ 'list_style_type' ] == 'none' ? 'style="list-style: none;"' : '';
/**
 * To edit, create a folder called "scc_templates" in the root of your theme 
 * and COPY this file into it. It will override the default plugin template.
 *
 * Your edits should only take place in the HTML below unless you know magic.
 */
?>

<?php if ( is_single() && sizeof( $the_posts ) > 1 ) : ?>
	<div id="scc-wrap" class="scc-post-list">
		<?php if ( $post_list_title != '' ) : ?>
			<h3 class="scc-post-list-title"><?php echo $post_list_title; ?></h3>
		<?php endif; ?>
		<?php if ( $course_description != '' ) : ?>
			<?php echo $course_description; ?>
		<?php endif; ?>				
		<a href="#" class="scc-show-post-list"><?php _e( 'full course', 'scc' ); ?></a>
		<div class="scc-post-container">
			<<?php echo $list_container; ?> class="scc-posts">
				<?php foreach ( $the_posts as $key => $post_id ) : ?>
					<li <?php echo $no_list; ?>>
						<span class="scc-list-item">
							<?php 
							if ( ! is_single( $post_id ) ) { 
								echo '<a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
							} else {
								echo '<span class="scc-current-post">' . get_the_title( $post_id ) . '</span>';
							}	
							?>
						</span>
					</li>
				<?php endforeach; ?>
			</<?php echo $list_container; ?>>
		</div>
	</div>
<?php endif; ?>