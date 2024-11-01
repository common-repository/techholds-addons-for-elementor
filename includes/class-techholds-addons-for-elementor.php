<?php

/**
 * Class to handle widget registration and helping function.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Include the AJAX functions file.
require_once THAFE_TECHHOLDS_PLUGIN_PATH . 'includes/ajax-functions.php';

class THAFE_TechHolds_Addons_For_Elementor {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        // Register widget scripts and styles.
        add_action( 'wp_enqueue_scripts', [ $this, 'thafe_techholds_enqueue_scripts' ] );

        // Register admin scripts and styles.
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'thafe_techholds_admin_enqueue_scripts' ] );

        // Register the widget(s).
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'thafe_techholds_register_widgets' ] );

        // AJAX actions for the 5-star rating widget.
        add_action( 'wp_ajax_thafe_techholds_update_rating', 'thafe_techholds_update_rating' );
        add_action( 'wp_ajax_nopriv_thafe_techholds_update_rating', 'thafe_techholds_update_rating' );
    }

    public function thafe_techholds_enqueue_scripts() {
        wp_enqueue_style( 'techholds-ea-style', THAFE_TECHHOLDS_PLUGIN_URL . 'assets/css/style.css', [], THAFE_TECHHOLDS_VERSION  );
        wp_enqueue_script( 'techholds-ea-script', THAFE_TECHHOLDS_PLUGIN_URL . 'assets/js/scripts.js', [ 'jquery' ], THAFE_TECHHOLDS_VERSION , true );
        wp_localize_script( 'techholds-ea-script', 'techholdsFrontendScript', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'techholds_nonce' )
        ));
    }

    public function thafe_techholds_admin_enqueue_scripts( $hook ) {
        // Enqueue the dynamic CSS for the Elementor editor
        wp_enqueue_style( 'techholds-ea-icon-styles', THAFE_TECHHOLDS_PLUGIN_URL . 'assets/css/techhold-icon-style.css', [], THAFE_TECHHOLDS_VERSION);
    }

    public function thafe_techholds_register_widgets() {
        // Ensure Elementor is active.
        if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
            require_once THAFE_TECHHOLDS_PLUGIN_PATH . 'includes/elementor-widgets/star-rating/class-5-star-rating-widget.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \THAFE_TechHolds_5_Star_Rating_Widget() );
        }
    }
}
