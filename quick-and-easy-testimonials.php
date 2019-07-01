<?php
/**
 *
 * @link              http://inspirythemes.com/
 * @since             1.0.0
 * @package           Quick_And_Easy_Testimonials
 *
 * @wordpress-plugin
 * Plugin Name:       Quick and Easy Testimonials
 * Plugin URI:        https://github.com/InspiryThemes/quick-and-easy-testimonials
 * Description:       This plugin provides a quick and easy way to add testimonials to your site.
 * Version:           1.0.6
 * Author:            Inspiry Themes
 * Author URI:        http://inspirythemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qe-testimonials
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'QE_TESTIMONIALS_BASE', plugin_basename(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quick-and-easy-testimonials-activator.php
 */
function activate_quick_and_easy_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials-activator.php';
	Quick_And_Easy_Testimonials_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quick-and-easy-testimonials-deactivator.php
 */
function deactivate_quick_and_easy_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials-deactivator.php';
	Quick_And_Easy_Testimonials_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quick_and_easy_testimonials' );
register_deactivation_hook( __FILE__, 'deactivate_quick_and_easy_testimonials' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quick-and-easy-testimonials.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Quick_And_Easy_Testimonials();
	$plugin->run();

}
run_plugin_name();
