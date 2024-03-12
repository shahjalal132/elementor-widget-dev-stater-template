<?php

/*
 * Plugin Name:       Jalal Elementor Widgets
 * Plugin URI:        #
 * Description:       Jalal Elementor Widgets
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shah jalal
 * Author URI:        #
 * License:           GPL v2 or later
 * Text Domain:       jalal-elementor-widgets
 * Domain Path:       /languages
 */

namespace Jalal\Jalal_Widgets;

use Jalal\Jalal_Widgets\Widgets\Jalal_Nav_Menu;

defined( "ABSPATH" ) || exit( "Direct Access Not Allowed" );

// Define plugin path
if ( !defined( 'JALAL_PLUGIN_PATH' ) ) {
    define( 'JALAL_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Define plugin url
if ( !defined( 'JALAL_PLUGIN_URI' ) ) {
    define( 'JALAL_PLUGIN_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
}

// Define plugin textdomain
define( 'TEXT_DOMAIN', 'jalal-elementor-widgets' );

final class JalalElementorWidgets {

    const VERSION                   = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION       = '7.2';

    private static $_instance = null;

    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'create_new_category' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }

    public function i18n() {
        load_plugin_textdomain( TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function init_plugin() {
        // Check PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            // PHP version is below the minimum required
            wp_die(
                sprintf(
                    __( 'Jalal Elementor Widgets requires PHP version %s or higher. Please update PHP to use this plugin.', TEXT_DOMAIN ),
                    self::MINIMUM_PHP_VERSION
                )
            );
        }

        // Check Elementor version
        if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '<' ) ) {
            // Elementor version is below the minimum required
            wp_die(
                sprintf(
                    __( 'Jalal Elementor Widgets requires Elementor version %s or higher. Please update Elementor to use this plugin.', TEXT_DOMAIN ),
                    self::MINIMUM_ELEMENTOR_VERSION
                )
            );
        }

        // Now bring the widgets classes
        $this->init_widgets();
    }

    public function init_controls() {

    }

    public function init_widgets() {
        // Register the function to run after Elementor is fully loaded
        add_action( 'elementor/init', function () {
            // Require widget files
            require_once JALAL_PLUGIN_PATH . '/widgets/jalal-nav-menu.php';

            // Register widget with Elementor
            \Elementor\Plugin::instance()->widgets_manager->register( new Jalal_Nav_Menu() );
        } );
    }


    public static function get_instance() {
        if ( null == self::$_instance ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function create_new_category( $element_manager ) {

        $element_manager->add_category(
            'jalal_elements',
            [
                'title' => __( 'Jalal Elements', TEXT_DOMAIN ),
                'icon'  => 'fa fa-plug',
            ]
        );

    }
}

JalalElementorWidgets::get_instance();