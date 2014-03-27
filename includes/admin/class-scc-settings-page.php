<?php
/**
 * settings page class
 *
 * @since 1.0.0
 */
class SCC_Settings_Page {

		
	/**
	 * constructor for SCC_Settings_Page class
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// load settings page
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		
		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	
	/**
	 * add settings page under Setting smenu
	 *
	 * @since 1.0.0
	 */
	public function settings_menu() {
		add_options_page( SCC_NAME, __( 'Course Settings', 'scc' ), 'manage_options', 'simple_course_creator', array( $this, 'settings_page' ) );
	}
	
	
	/**
	 * register settings
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		
		// add display settings section
		add_settings_section( 'course_display_settings', __( 'Course Container Display Settings', 'scc' ), array( $this, 'course_display_settings' ), 'simple_course_creator' );
		
		// add option for choosing the display position of the course
		add_settings_field( 'display_position', __( 'Course Container Position', 'scc'), array( $this, 'course_list_position' ), 'simple_course_creator', 'course_display_settings' );
		register_setting( 'course_display_settings', 'display_position', array( $this, 'save_settings' ) ); 
		
		// add option for choosing the list style (ul, ol, none)
		add_settings_field( 'list_type', __( 'HTML List Style', 'scc'), array( $this, 'course_list_type' ), 'simple_course_creator', 'course_display_settings' );
		register_setting( 'course_display_settings', 'list_type', array( $this, 'save_settings' ) ); 
	}
	
	
	/**
	 * create the section for course display
	 *
	 * @callback_for 'course_display_settings' section
	 * @since 1.0.0
	 */
	public function course_display_settings() {
		echo '<p>' . __( 'These settings control the front-end display of the post listing container inside of posts that are part of courses.', 'scc' ) . '</p>';
	}
	
	
	/**
	 * create course position option
	 *
	 * @callback_for 'display_position' field
	 * @since 1.0.0
	 */
	public function course_list_position() {
		$options = get_option( 'display_position' );
		
		// possible course position options
		$course_container = array(
			'above'	=> array( 'value' => 'above', 'desc' => __( 'Above Content', 'scc' ) ),
			'below'	=> array( 'value' => 'below', 'desc' => __( 'Below Content', 'scc' ) ),
			'both'	=> array( 'value' => 'both', 'desc' => __( 'Above & Below Content', 'scc' ) ),
			'hide'	=> array( 'value' => 'hide', 'desc' => __( 'Hide Course Container', 'scc' ) ),
		);
		?>
	    <select id="display_position" name="display_position[list_position]">
	    	<?php foreach ( $course_container as $c ) { // display options from $course_container array ?>
		    	<option value="<?php echo $c['value']; ?>" <?php selected( $options['list_position'], $c['value'] ); ?>><?php echo $c['desc']; ?></option>
		    <?php } ?>
	    </select>
	    <label><?php _e( 'Choose where to display your course container.', 'scc' ); ?></label>
	    <?php
	}
	
	
	/**
	 * course list type option
	 *
	 * @callback_for 'list_type' field
	 * @since 1.0.0
	 */
	public function course_list_type() {
		$options = get_option( 'list_type' );
		
		// possible list style options
		$list_type = array(
			'ordered'	=> array( 'value' => 'ordered', 'desc' => __( 'Numbered List', 'scc' ) ),
			'unordered'	=> array( 'value' => 'unordered', 'desc' => __( 'Bullet Points', 'scc' ) ),
			'none'		=> array( 'value' => 'none', 'desc' => __( 'No List Indicator', 'scc' ) ),
		);
		?>
	    <select id="list_type" name="list_type[list_style_type]">
	    	<?php foreach ( $list_type as $l ) { // display options from $list_type array ?>
		    	<option value="<?php echo $l['value']; ?>" <?php selected( $options['list_style_type'], $l['value'] ); ?>><?php echo $l['desc']; ?></option>
		    <?php } ?>
	    </select>
	    <label><?php _e( 'Choose your preferred list element style.', 'scc' ); ?></label>
	    <?php
	}
	
	
	/**
	 * save position setting
	 *
	 * @used_by course_list_position() & course_list_type()
	 * @since 1.0.0
	 */
	public function save_settings( $input ) {
		
		// display full course above content by default
		$position = get_option( 'display_position' );
		if ( ! isset( $input['list_position'] ) ) {
			$input['list_position'] == 'above';
		} else {
			$input['list_position'] == $position['list_position'];
		}
		
		// display ordered list by default
		$list_type = get_option( 'list_type' );
		if ( ! isset( $input['list_style_type'] ) ) {
			$input['list_style_type'] == 'ordered';
		} else {
			$input['list_style_type'] == $list_type['list_style_type'];
		}	
		return $input;
	}
	
	
	/**
	 * plugin settings page
	 *
	 * SCC has a single menu link as a submenu under the "Settings" section
	 * of the WordPress dashboard. Within that page are tabbed settings pages.
	 * Based on which tab is selected, different settings or informaiton will
	 * show. 
	 *
	 * @since 1.0.0
	 */
	public function settings_page() {
		?>
			<div class="wrap">
				<h2><?php echo SCC_NAME . __( ' Settings', 'scc' ); ?></h2>
				<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'simple_course_creator'; ?>
				<h2 class="nav-tab-wrapper">
					<a href="?page=simple_course_creator&tab=simple_course_creator" class="nav-tab <?php echo $active_tab == 'simple_course_creator' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display', 'scc' ); ?></a>
					<a href="?page=simple_course_creator&tab=simple_course_creator_info" class="nav-tab <?php echo $active_tab == 'simple_course_creator_info' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Information', 'scc' ); ?></a>
				</h2>
				<form method="post" action="options.php">
					<?php 
					if ( $active_tab == 'simple_course_creator' ) {
						settings_fields( 'course_display_settings' );
						do_settings_sections( 'simple_course_creator' );
						submit_button();
					} elseif ( $active_tab == 'simple_course_creator_info' ) {
					?>
						<h3><?php echo SCC_NAME . __( ' Information', 'scc' ); ?></h3>
						<p class="plugin-description"><?php echo __( 'Thanks for using ', 'scc' ) . SCC_NAME . __( '. This plugin allows you to easily group your posts into series called "Courses." Courses behave similarly to categories and tags. However, courses will display a course container in the content of posts within a given course.', 'scc' ); ?></p> 
						<p class="plugin-description"><?php echo __( 'The container displays a numbered list of all posts in that course, including the current post which is the only one not linked. Using the course title and description fields when creating new courses, you can customize the copy for your course containers on a per-course basis.', 'scc' ); ?></p>
						<table class="form-table plugin-info">
							<tbody>
								<tr>
									<th scope="row"><?php _e( 'Theme Overrides', 'scc' ); ?></th>
									<td>
										<p><?php echo __( 'You are more than welcome to override the basic default styles, JavaScript, or HTML template responsible for displaying the course container.', 'scc' ); ?></p>
										<p><?php echo __( 'If you only want to edit a few CSS styles, you&rsquo;re better off using your own theme&rsquo;s stylesheet and simply writing stronger CSS.', 'scc' ); ?></p>
										<p><?php echo __( 'If you would like to override the actual files for displaying the course container, you can easily do so by creating a folder in the root of your theme called "scc_templates" and copying any of the files you&rsquo;d like from the plugin&rsquo;s "includes/scc_templates" folder into your new theme folder.', 'scc' ); ?></p>
										<p><?php echo __( 'Your theme files will now completely override the plugin files. Be sure to copy these files and not simply create new, empty ones. Even if they&rsquo;re empty, they&rsquo;ll still override.', 'scc' ); ?></p>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'Bugs & Contributions', 'scc' ); ?></th>
									<td>
										<p><?php echo __( 'If you have any issues that you know how to fix, feel free to ', 'scc' ) . '<a href="https://github.com/sdavis2702/simple-course-creator" target="_blank">' .  __( 'fork the repo on Github', 'scc' ) . '</a>' .  __( ' and submit a pull request with your corrections. The same is true of any features you feel should be added or changes that can be made. If you are not a developer and you need support, you can ', 'scc' ) . '<a href="http://buildwpyourself.com/contact/" target="_blank">' . __( 'get in contact here', 'scc' ) . '</a>.'; ?></p>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'License Information', 'scc' ); ?></th>
									<td>
										<p><?php echo __( 'This plugin, like WordPress, is licensed under the GPL.', 'scc' ); ?></p>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'Plugin Contributors', 'scc' ); ?></th>
									<td>
										<p><?php echo '<a href="https://github.com/sdavis2702/simple-course-creator/graphs/contributors" target="_blank">' . __( 'View all contributors', 'scc' ) . '</a>. ' . __( 'Fork the repo and submit a pull request if you would like to pitch in.', 'scc' ); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
					<?php }	?>
				</form>
			</div>
		<?php
	}
}
new SCC_Settings_Page();