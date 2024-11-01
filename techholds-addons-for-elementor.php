<?php
/**
 * Plugin Name: TechHolds Addons For Elementor
 * Description: A custom Elementor addons by TechHolds for adding widgets like 5-star rating to posts.
 * Version: 1.0.0
 * Author: TechHolds
 * Author URI: https://techholds.com
 * Plugin URI: https://techholds.com/elementor-addons/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: techholds-addons-for-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define Constants
define( 'THAFE_TECHHOLDS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'THAFE_TECHHOLDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'THAFE_TECHHOLDS_VERSION', '1.0.0' );

/**
 * Check if Elementor is installed and activated.
 */
function thafe_tholds_check_elementor_status() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'thafe_tholds_admin_notice_missing_elementor' );
        return false;
    }
    return true;
}

/**
 * Admin notice for missing Elementor plugin.
 */
function thafe_tholds_admin_notice_missing_elementor() {
    ?>
    <div class="error">
        <p><?php esc_html_e( 'TechHolds Addons For Elementor requires Elementor to be installed and activated.', 'techholds-addons-for-elementor' ); ?></p>
    </div>
    <?php
}

/**
 * Initialize the plugin.
 */
function thafe_tholds_init() {
    if ( thafe_tholds_check_elementor_status() ) {
        require_once THAFE_TECHHOLDS_PLUGIN_PATH . 'includes/class-techholds-addons-for-elementor.php';
        \THAFE_TechHolds_Addons_For_Elementor::instance();
    }
}
add_action( 'plugins_loaded', 'thafe_tholds_init' );
