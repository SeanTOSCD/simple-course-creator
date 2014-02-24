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
				
				<?php if ( $active_tab == 'simple_course_creator' ) : ?>
					<form method="post" action="options.php">
						<?php settings_fields( '' ); ?>
						<?php do_settings_sections( '' ); ?>
						<?php echo "Settings"; ?>
					</form>
				<?php elseif ( $active_tab == 'simple_course_creator_info' ) : ?>
					<form method="post" action="options.php">
						<?php settings_fields( '' ); ?>
						<?php do_settings_sections( '' ); ?>
						<?php echo "Information"; ?>
					</form>
				<?php endif; ?>
			</div>
		<?php
	}
}

new SCC_Settings_Page();