<?php
/**
 * Plugin Name:       Ix Woocommerce Descriptions Archives
 * Plugin URI:        #
 * Description:       Дополнительное описание для страниц архива woo
 * Author:
 * Author URI:
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ix-woocommerce-descriptions-archives
 * Domain Path:       /languages/
 *
 * Version:           1.0.0
 *
 * WC requires at least: 5.2.0
 * WC tested up to: 6.1
 *
 * RequiresWP: 5.5
 * RequiresPHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'IXWDA_PLUGIN_DIR', __DIR__ );
define( 'IXWDA_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'IXWDA_PLUGIN_FILE', plugin_basename( __FILE__ ) );

define( 'IXWDA_PLUGIN_NAME', 'Ix Woocommerce Descriptions Archives' );

require IXWDA_PLUGIN_DIR . '/vendor/autoload.php';

add_action( 'plugins_loaded', array( 'IXWDA\Main', 'init' ) );




