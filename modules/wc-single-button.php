<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function lwab_enqueue_wc_single_assets() {
    if ( is_product() ) {
        wp_enqueue_style( 'lwab-wc-single-css', plugin_dir_url( __FILE__ ) . '../assets/css/single-button.css', array(), '1.0' );
        wp_enqueue_script( 'lwab-wc-single-js', plugin_dir_url( __FILE__ ) . '../assets/js/single-button.js', array( 'jquery' ), '1.0', true );

        wp_localize_script( 'lwab-wc-single-js', 'lwab_wc_data', array(
            'phone' => get_option( 'lwab_wc_phone_number', '' ),
            'default_message' => get_option( 'lwab_wc_default_message', 'Hola, estoy interesado en el producto:' ),
        ));
    }
}
add_action( 'wp_enqueue_scripts', 'lwab_enqueue_wc_single_assets' );


add_shortcode( 'lw_wp_wc_button', function() {
    global $product;
    if ( ! is_product() || ! $product ) return '';

    $settings = get_option( 'lw_wp_settings', array() );
    $number = isset( $settings['wc_number'] ) ? sanitize_text_field( $settings['wc_number'] ) : '';
    $message = isset( $settings['wc_message'] ) ? sanitize_text_field( $settings['wc_message'] ) : 'Buenos días/noches, estoy interesado en este producto:';
    $button_text = get_option( 'lwab_wc_button_text', 'Comprar por WhatsApp' );
    $product_name = $product->get_name();
    
    // Construimos la URL inicial (sin variación aún)
    $wa_url = "https://wa.me/{$number}?text=" . rawurlencode("{$message} {$product_name}");

    ob_start();

    ?>
    <a href="<?php echo esc_url( $wa_url ); ?>" 
       target="_blank" 
       id="lw-wp-wc-btn" 
       class="button" 
       data-base-url="<?php echo esc_url( "https://wa.me/{$number}?text=" ); ?>" 
       data-message="<?php echo esc_attr( $message ); ?>" 
       data-product-name="<?php echo esc_attr( $product_name ); ?>">
       <?php echo esc_html( $button_text ); ?>
    </a>

    <?php
    return ob_get_clean();
});
