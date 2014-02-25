<?php
/**
 * main settings page class
 */

/**
 * settings page class
 *
 * @since 1.0.0
 */
class SCC_Settings_Page {

		
	/**
	 * Constructor for SCC_Settings_Page class
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
		add_options_page( 
			SCC_NAME, 
			__( 'Course Settings', 'scc' ), 
			'manage_options', 
			'simple_course_creator', 
			array( $this, 'settings_page' ) 
		);
	}
	
	
	/**
	 * register settings
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		add_settings_section( 
			'course_display_settings', 
			__( 'Course Display Settings', 'scc' ), 
			array( $this, 'course_display_settings' ), 
			'simple_course_creator' 
		);
		add_settings_field( 
			'display_position', 
			__( 'Course List Position', 'scc'), 
			array( $this, 'course_list_position' ), 
			'simple_course_creator', 
			'course_display_settings' 
		);
		register_setting( 
			'course_display_settings', 
			'display_position', 
			array( $this, 'save_position' ) 
		); 
	}
	
	
	/**
	 * create the section for course display
	 *
	 * @since 1.0.0
	 */
	public function course_display_settings() {
		echo '<p>' . __( 'These settings control the front-end display of the post listing container inside of posts that are part of courses.', 'scc' ) . '</p>';
	}
	
	
	/**
	 * create course position option
	 *
	 * @since 1.0.0
	 */
	public function course_list_position() {
		$options = get_option( 'display_position' );
		?>
	    <select id="display_position" name="display_position[list_position]">
	    	<option value="above" <?php selected( $options['list_position'], 'above' ); ?>><?php _e( 'Above Content', 'scc' ); ?></option> 
	    	<option value="below" <?php selected( $options['list_position'], 'below' ); ?>><?php _e( 'Below Content', 'scc' ); ?></option>
	    	<option value="both" <?php selected( $options['list_position'], 'both' ); ?>><?php _e( 'Above & Below Content', 'scc' ); ?></option> 
	    </select>
	    <?php
	}
	
	
	/**
	 * save position setting
	 *
	 * @since 1.0.0
	 */
	public function save_position( $input ) {
		return $input;
	}
	
	
	/**
	 * output settings page
	 *
	 * @since 1.0.0
	 */
	public function settings_page() {
		?>
			<div class="wrap">
				<h2><?php _e( SCC_NAME . ' Settings', 'scc' ); ?></h2>
				
				<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'simple_course_creator'; ?>
		
				<h2 class="nav-tab-wrapper">
					<a href="?page=simple_course_creator&tab=simple_course_creator" class="nav-tab <?php echo $active_tab == 'simple_course_creator' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'scc' ); ?></a>
					<a href="?page=simple_course_creator&tab=simple_course_creator_info" class="nav-tab <?php echo $active_tab == 'simple_course_creator_info' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Info', 'scc' ); ?></a>
				</h2>
				
				<form method="post" action="options.php">
					<?php 
					if ( $active_tab == 'simple_course_creator' ) :
						settings_fields( 'course_display_settings' );
						do_settings_sections( 'simple_course_creator' );
						submit_button();
					elseif ( $active_tab == 'simple_course_creator_info' ) :
						echo '<p>Just a little bit of information.</p>';
					endif;
					?>
				</form>
			</div>
		<?php
	}
}
new SCC_Settings_Page();
