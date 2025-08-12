<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'lw-wp-floating-css', LW_WP_URL . 'assets/css/floating-button.css' );
    wp_enqueue_script( 'lw-wp-floating-js', LW_WP_URL . 'assets/js/floating-button.js', array(), null, true );
});

add_action( 'wp_footer', function() {
    $settings = get_option( 'lw_wp_settings', array() );

    if ( empty( $settings['floating_number'] ) ) return;

    $current_post_type = get_post_type();
    if ( empty( $settings['floating_locations'][$current_post_type] ) ) return;

    $number = sanitize_text_field( $settings['floating_number'] );
    $message = sanitize_text_field( $settings['floating_message'] ?? '' );

    echo '<a href="https://wa.me/' . esc_attr( $number ) . '?text=' . rawurlencode( $message ) . '" target="_blank" class="lw-wp-floating-btn pulse-anim"><img src="'. LW_WP_URL .'assets/img/icon.svg" alt="Botón WhatsApp"/></a>';
});
