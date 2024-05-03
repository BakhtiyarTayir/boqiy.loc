<?php
/**
 * Elementor Master WordPress Plugin
 *
 * @package ElementorMaster
 *
 * Plugin Name: Elementor Master
 * Description: Simple Elementor plugin example
 * Plugin URI:  https://www.eson.uz/
 * Version:     1.0.0
 * Author:      Eson.uz
 * Author URI:  https://eson.uz
 * Text Domain: elementor-master
 */

define( 'ELEMENTOR_MASTER', __FILE__ );

/**
 * Include the Elementor_Master class.
 */
require plugin_dir_path( ELEMENTOR_MASTER ) . 'class-elementor-master.php';
