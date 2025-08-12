<?php
/*
Plugin Name: Lightweight WhatsApp Buttons
Plugin URI: https://raulmartiarena.com
Description: Botones de WhatsApp para productos WooCommerce y páginas de WordPress. Modular, rápido y sin código innecesario.
Version: 1.0.0
Author: Raúl Martiarena
Author URI: https://raulmartiarena.com
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'LW_WP_DIR', plugin_dir_path( __FILE__ ) );
define( 'LW_WP_URL', plugin_dir_url( __FILE__ ) );

// Incluir página de configuración
require_once LW_WP_DIR . 'admin/settings-page.php';

// Cargar módulos según ajustes
$options = get_option( 'lw_wp_settings', array() );

if ( ! empty( $options['enable_wc_single'] ) ) {
    require_once LW_WP_DIR . 'modules/wc-single-button.php';
}

if ( ! empty( $options['enable_floating'] ) ) {
    require_once LW_WP_DIR . 'modules/floating-button.php';
}
