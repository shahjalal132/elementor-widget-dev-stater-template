<?php

namespace Jalal\Jalal_Widgets\Widgets;

// Ensure Elementor is loaded
if ( !class_exists( '\Elementor\Widget_Base' ) ) {
    return;
}

use \Elementor\Widget_Base;

/**
 * Jalal Nav Menu Widget
 */

class Jalal_Nav_Menu extends Widget_Base {

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        // Load Widget CSS
        wp_enqueue_style( 'jalal-nav-menu-style', JALAL_PLUGIN_URI . '/assets/css/menu.css' );

        // Load Widget Javascript
        wp_enqueue_script( 'jalal-nav-menu-script', JALAL_PLUGIN_URI . '/assets/js/scripts.js', [ 'jquery' ], false, true );
    }

    // set a name/id for our widget
    public function get_name() {
        return __( 'jalal-nav-menu', TEXT_DOMAIN );
    }

    // set a title for our widget
    public function get_title() {
        return __( 'Jalal Nav Menu', TEXT_DOMAIN );
    }

    // set an icon for our widget
    public function get_icon() {
        return 'eicon-nav-menu';
    }

    // Available categories and create a new category
    public function get_categories() {

        return [ 'jalal_elements' ];

        /**
         * Available categories
         * basic, pro-elements, woocommerce-elements, general
         */
    }

    protected function _register_controls() {

    }

    // Enqueue Styles
    public function get_style_depends() {
        return [ 'jalal-nav-menu-style' ];
    }

    // Enqueue Scripts
    public function get_script_depends() {
        return [ 'jalal-nav-menu-script' ];
    }

    // Front-end rendering for our widget.
    protected function render() {

        echo wp_nav_menu( [
            'container'  => '',
            'menu_class' => 'jalal-nav-menu',
        ] );

        // Content to render front-end
    }

    // Back-end Controls for our widget.
    protected function _content_template() {

        echo wp_nav_menu( [
            'container'  => '',
            'menu_class' => 'jalal-nav-menu',
        ] );

        // Content to render back-end and can be controls
    }

}
