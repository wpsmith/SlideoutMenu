<?php
/**
 * SlideoutMenu Class
 *
 * Enables a slideout menu.
 *
 * You may copy, distribute and modify the software as long as you track changes/dates in source files.
 * Any modifications to or software including (via compiler) GPL-licensed code must also be made
 * available under the GPL along with build & install instructions.
 *
 * @package    WPS\WP\Themes\ChildTheme
 * @author     Travis Smith <t@wpsmith.net>
 * @copyright  2015-2019 Travis Smith
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @link       https://github.com/wpsmith/WPS
 * @version    1.0.0
 * @since      0.1.0
 */

namespace WPS\WP\Themes\ChildTheme;

use WPS\Core\Singleton;
use WPS\Templates\TemplateLoader;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\SlideoutMenu' ) ) {
	/**
	 * SlideoutMenu Class
	 *
	 * Assists in fixing Genesis custom header styles.
	 *
	 * @package WPS\WP\Themes\ChildTheme
	 * @author  Travis Smith <t@wpsmith.net>
	 */
	class SlideoutMenu extends Singleton {

		public $menu_str = 'Menu';

		protected function __construct() {

			parent::__construct();
			add_action( 'init', [ $this, 'wp_enqueue_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
			add_action( 'genesis_before', [ $this, 'slideout_menu' ] );

		}

		public function wp_register_scripts() {
			if ( is_admin() ) {
				return;
			}

			$suffix = wp_scripts_get_suffix();

			wp_register_script(
				'slideout',
				plugin_dir_url( __FILE__ ) . "assets/js/slideout{$suffix}.js",
				array(),
				filemtime( plugin_dir_path( __FILE__ ) . "assets/js/slideout{$suffix}.js" )
			);
			wp_register_script(
				'slideout-init',
				plugin_dir_url( __FILE__ ) . "assets/js/jquery.slideout-init{$suffix}.js",
				array( 'jquery', 'slideout' ),
				filemtime( plugin_dir_path( __FILE__ ) . "assets/js/jquery.slideout-init{$suffix}.js" )
			);

			wp_register_style(
				'slideout',
				plugin_dir_url( __FILE__ ) . "assets/css/slideout{$suffix}.css",
				null,
				filemtime( plugin_dir_path( __FILE__ ) . "assets/css/slideout{$suffix}.css" )
			);

		}

		/**
		 * Adds `.side-menu` above `.site-container`.
		 */
		function slideout_menu() {
			$loader = new TemplateLoader(array(
				'filter_prefix'            => 'wps_hours',
				'plugin_directory'         => __DIR__,
			));


			$loader->get_template_part( 'menu', 'slideout', true );

		}


		public function wp_enqueue_scripts() {

			wp_enqueue_style('slideout' );
			wp_enqueue_script( 'slideout-init' );

		}
	}
}
