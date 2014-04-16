<?php
/**
 * settings page class
 *
 * This class creates the settings menu item as well as the settings
 * page. The menu item is added to WP Dashboard -> Settings -> Course
 * Settings.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // no accessing this file directly


class SCC_Settings_Page {

		
	/**
	 * constructor for SCC_Settings_Page class
	 */
	public function __construct() {
		
		// load settings page
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		
		// register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	
	/**
	 * add new settings page under Setting smenu
	 */
	public function settings_menu() {
		add_options_page( SCC_NAME, __( 'Course Settings', 'scc' ), 'manage_options', 'simple_course_creator', array( $this, 'settings_page' ) );
	}
	
	
	/**
	 * register settings
	 */
	public function register_settings() {
	
		// register display settings
		register_setting( 'course_display_settings', 'course_display_settings', array( $this, 'save_settings' ) );
		
		// add display settings section
		add_settings_section( 'course_display_settings', __( 'Course Container Display Settings', 'scc' ), array( $this, 'course_display_settings' ), 'simple_course_creator' );
		
		// add option for choosing the display position of the course
		add_settings_field( 'display_position', __( 'Course Container Position', 'scc'), array( $this, 'course_list_position' ), 'simple_course_creator', 'course_display_settings' );
		
		// add option for choosing the list style (ul, ol, none)
		add_settings_field( 'list_type', __( 'HTML List Style', 'scc'), array( $this, 'course_list_type' ), 'simple_course_creator', 'course_display_settings' );
		
		// add option for disabling JS
		add_settings_field( 'disable_js', __( 'Disable JavaScript', 'scc'), array( $this, 'course_disable_js' ), 'simple_course_creator', 'course_display_settings' );
		
		if ( get_option( 'course_display_settings' ) == false ) {
			update_option( 'display_position', 'above' );
			update_option( 'list_type', 'ordered' );
			update_option( 'disable_js', '0' );
		}
	}
	
	
	/**
	 * create the section for course display
	 *
	 * @callback_for 'course_display_settings' section
	 */
	public function course_display_settings() {
		echo '<p>' . __( 'These settings control the front-end display of the post listing container inside of posts that are part of courses.', 'scc' ) . '</p>';
	}
	
	
	/**
	 * create course position option
	 *
	 * @callback_for 'display_position' field
	 */
	public function course_list_position() {
		$options = get_option( 'course_display_settings' );
		
		// possible course position options
		$course_container = array(
			'above'	=> array( 'value' => 'above', 'desc' => __( 'Above Content', 'scc' ) ),
			'below'	=> array( 'value' => 'below', 'desc' => __( 'Below Content', 'scc' ) ),
			'both'	=> array( 'value' => 'both', 'desc' => __( 'Above & Below Content', 'scc' ) ),
			'hide'	=> array( 'value' => 'hide', 'desc' => __( 'Hide Course Container', 'scc' ) ),
		);
		?>
	    <select id="display_position" name="course_display_settings[display_position]">
	    	<?php foreach ( $course_container as $c ) { // display options from $course_container array ?>
		    	<option value="<?php echo $c['value']; ?>" <?php selected( $options['display_position'], $c['value'] ); ?>><?php echo $c['desc']; ?></option>
		    <?php } ?>
	    </select>
	    <label><?php _e( 'Choose where to display your course container.', 'scc' ); ?></label>
	    <?php
	}
	
	
	/**
	 * course list type option
	 *
	 * @callback_for 'list_type' field
	 */
	public function course_list_type() {
		$options = get_option( 'course_display_settings' );
		
		// possible list style options
		$list_type = array(
			'ordered'	=> array( 'value' => 'ordered', 'desc' => __( 'Numbered List', 'scc' ) ),
			'unordered'	=> array( 'value' => 'unordered', 'desc' => __( 'Bullet Points', 'scc' ) ),
			'none'		=> array( 'value' => 'none', 'desc' => __( 'No List Indicator', 'scc' ) ),
		);
		?>
	    <select id="list_type" name="course_display_settings[list_type]">
	    	<?php foreach ( $list_type as $l ) { // display options from $list_type array ?>
		    	<option value="<?php echo $l['value']; ?>" <?php selected( $options['list_type'], $l['value'] ); ?>><?php echo $l['desc']; ?></option>
		    <?php } ?>
	    </select>
	    <label><?php _e( 'Choose your preferred list element style.', 'scc' ); ?></label>
	    <?php
	}
	
	
	/**
	 * disable JS option
	 *
	 * @callback_for 'disable_js' field
	 * @since 1.0.1
	 */
	public function course_disable_js() {
		$options = get_option( 'course_display_settings' );
		?>
		<input id="disable_js" type="checkbox" name="course_display_settings[disable_js]" value="1" <?php echo checked( 1, isset( $options['disable_js'] ) ? $options['disable_js'] : 0, false ); ?>>
		<label for="disable_js"><?php _e( 'Check this box to disable JavaScript (the course list will show by default).', 'scc' ); ?></label>
		<?php	
	}
	
	
	/**
	 * save display settings
	 *
	 * @used_by course_list_position(), course_list_type(), & course_disable_js()
	 */
	public function save_settings( $input ) {
		$all_options = get_option( 'course_display_settings' );
		
		// sanitize the display position option
		if ( ! isset( $all_options['display_position'] ) ) {
			$input['display_position'] = 'above';
		} else {
			update_option( 'display_position', $all_options['display_position'] );
		}
		
		// sanitize the list style option
		if ( ! isset( $all_options['list_type'] ) ) {
			$input['list_type'] = 'ordered';
		} else {
			update_option( 'list_type', $all_options['list_type'] );
		}
		
		// sanitize the disable JS option
		$all_options['disable_js'] = ( isset( $input['disable_js'] ) && $input['disable_js'] == true ? '1' : '0' );
		
		return $input;
	}
	
	
	/**
	 * plugin settings page
	 *
	 * SCC has a single menu link as a submenu under the "Settings" section
	 * of the WordPress dashboard. Within that page are tabbed settings pages.
	 * Based on which tab is selected, different settings or informaiton will
	 * show.
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
						<table class="form-table plugin-info">
							<tbody>
								<tr>
									<th scope="row"><?php _e( 'Plugin Resources', 'scc' ); ?></th>
									<td>
										<p class="resources">
											<?php echo __( 'New courses are created ', 'scc' ) . '<a href="' . admin_url( 'edit-tags.php?taxonomy=course' ) . '">' . __( 'here', 'scc' ) . '</a>' . __( ' under the Posts menu. Once a course is created, posts can be assigned to a course through the manage posts and edit post screens. To add content to the post listing output, see the ', 'scc' ) . '<a href="https://github.com/sdavis2702/simple-course-creator#wordpress-hooks--filters" target="_blank">' . __( 'hooks & filters', 'scc' ) . '</a> ' . __( 'documentation. To completely override the output, CSS, and JS files, see the ', 'scc' ) . '<a href="https://github.com/sdavis2702/simple-course-creator#active-theme-file-overrides" target="_blank">' . __( 'override plugin files', 'scc' ) . '</a> ' . __( 'documentation.', 'scc' ); ?>
										</p>
									</td>
								</tr>
								<tr>
									<th scope="row"><?php _e( 'Plugin Contributors', 'scc' ); ?></th>
									<td>
										<?php echo $this->scc_contributors(); ?>
										<p><?php echo 'Fork <a href="https://github.com/sdavis2702/simple-course-creator" target="_blank">' . SCC_NAME . '</a> ' . __( ' on GitHub and submit a pull request if you would like to pitch in.', 'scc' ); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
					<?php }	?>
				</form>
			</div>
		<?php
	}
	
	
	/**
	 * the contributors
	 */
	public function scc_contributors() { 
		$contributors = $this->scc_get_contributors();									
		$contributor_list = '<ul class="wp-people-group">';
		
		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
			esc_url( 'https://github.com/' . $contributor->login ),
			esc_html( sprintf( __( 'View %s', 'scc' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="30" height="30" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}										
		$contributor_list .= '</ul>';
		return $contributor_list;
	}
	
	
	/** 
	 * get the repo contributors
	 */
	public function scc_get_contributors() {
		$transient_key = 'scc_contributors';
		$contributors = get_transient( $transient_key );
		if ( false !== $contributors ) {
			return $contributors;
		}
		
		$response = wp_remote_get( 'https://api.github.com/repos/sdavis2702/simple-course-creator/contributors' );
		if ( is_wp_error( $response ) ) {
			return array();
		}
		
		$contributors = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! is_array( $contributors ) ) {
			return array();
		}
		
		set_transient( $transient_key, $contributors, 3600 );
		return (array) $contributors;
	}
}
new SCC_Settings_Page();
