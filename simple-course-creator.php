<?php
/**
 * Plugin Name: Simple Course Creator
 * Plugin URI: http://buildwpyourself.com/downloads/simple-course-creator/
 * Description: Allows you to easily create and manage courses in your WordPress website.
 * Version: 1.1
 * Author: Sean Davis
 * Author URI: http://seandavis.co
 * License: GPL2
 * Requires at least: 3.8
 * Tested up to: 3.8
 * Text Domain: scc
 * Domain Path: /inc/languages/
 * 
 * This plugin is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see http://www.gnu.org/licenses/.
 *
 * The basic foundation of this plugin was highly influenced by Mike 
 * Jolley's WP Post Series plugin. Special thanks to him. Check out 
 * his website - http://mikejolley.com -
 *
 * @package Simple Course Creator
 * @category Core
 * @author Sean Davis
 * @license GNU GENERAL PUBLIC LICENSE Version 2 - /license.txt
 */


// No accessing this file directly
if ( ! defined( 'ABSPATH' ) ) exit;

	
/**
 * Primary class for Simple Course Creator
 *
 * @since 1.0.0
 */
class Simple_Course_Creator {

		
	/**
	 * Constructor for Simple_Course_Creator class
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// define plugin name
		define( 'SCC_NAME', __( 'Simple Course Creator', 'scc' ) );
		
		// define plugin version
		define( 'SCC_VERSION', '1.1' );
		
		// define plugin directory
		define( 'SCC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		
		// define plugin root file
		define( 'SCC_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// load text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );
	
		// load admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
		
		// require additional plugin files
		$this->includes();
	}
	

	/**
	 * Load SCC textdomain
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'scc', false, SCC_DIR . "inc/languages" );
	}


	/** 
	 * Enqueue back-end scripts and styles
	 *
	 * @since 1.0.0
	 */
	public function admin_assets() {
		
		// admin page CSS
		wp_register_style( 'scc_admin_style', SCC_URL . 'inc/assets/css/admin-style.css' );
		
		// only load styles on SCC admin pages
		if ( 'settings_page_simple_course_creator' == get_current_screen()->id ) {
			wp_enqueue_style( 'scc_admin_style' );
		}
	}
	
	
	/**
	 * require additional plugin files
	 *
	 * @since 1.0.0
	 */
	private function includes() {
		require_once( SCC_DIR . 'inc/admin/class-scc-settings-page.php' );		// main settings page
		require_once( SCC_DIR . 'inc/admin/class-scc-custom-taxonomy.php' );	// setup course taxonomy
		require_once( SCC_DIR . 'inc/display/class-scc-post-listing.php' );		// display post listing
	}
}
new Simple_Course_Creator();