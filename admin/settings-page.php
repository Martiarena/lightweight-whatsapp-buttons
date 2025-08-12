<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', function() {
    add_menu_page(
        'WhatsApp Buttons',
        'WhatsApp Buttons',
        'manage_options',
        'lw-wp-settings',
        'lw_wp_render_settings_page',
        'dashicons-whatsapp',
        80
    );
});

add_action( 'admin_init', function() {
    register_setting( 'lw_wp_settings_group', 'lw_wp_settings' );
    register_setting( 'lw_wp_settings_group', 'lwab_wc_button_text' );
});


function lw_wp_render_settings_page() {
    $settings = get_option( 'lw_wp_settings', array() );
    ?>
    <div class="wrap">
        <h1>Lightweight WhatsApp Buttons</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'lw_wp_settings_group' ); ?>

            <h2>Botón en Single Product (WooCommerce)</h2>
            <p style="margin-bottom:15px; color:#555;">Si tu plantilla de producto está creada con Elementor (y no usa los hooks de WooCommerce), pega este shortcode donde quieras mostrar el botón: <code>[lwab_wc_single_button]</code></p>
            <label>
                <input type="checkbox" name="lw_wp_settings[enable_wc_single]" value="1" <?php checked( ! empty( $settings['enable_wc_single'] ) ); ?>> Habilitar
            </label>
            <p><strong>Número WhatsApp:</strong> <input type="text" name="lw_wp_settings[wc_number]" placeholder="Ejem: 923766570" value="<?php echo esc_attr( $settings['wc_number'] ?? '' ); ?>"></p>
            <p><strong>Mensaje enviado:</strong> <input type="text" name="lw_wp_settings[wc_message]" placeholder="Mensaje predeterminado" value="<?php echo esc_attr( $settings['wc_message'] ?? '' ); ?>"></p>
            <p><strong>Texto del botón:</strong> <input type="text" name="lwab_wc_button_text" placeholder="Comprar por WhatsApp" value="<?php echo esc_attr( get_option( 'lwab_wc_button_text', 'Comprar por WhatsApp' ) ); ?>"></p>

            <hr>

            <h2>Botón Flotante</h2>
            <label>
                <input type="checkbox" name="lw_wp_settings[enable_floating]" value="1" <?php checked( ! empty( $settings['enable_floating'] ) ); ?>> Habilitar
            </label>
            <p><strong>Número WhatsApp:</strong> <input type="text" name="lw_wp_settings[floating_number]" placeholder="Número WhatsApp" value="<?php echo esc_attr( $settings['floating_number'] ?? '' ); ?>"></p>
            <p><strong>Mensaje enviado:</strong> <input type="text" name="lw_wp_settings[floating_message]" placeholder="Mensaje predeterminado" value="<?php echo esc_attr( $settings['floating_message'] ?? '' ); ?>"></p>

            <p>Mostrar en:</p>
            <?php
            $post_types = get_post_types( array(
                'public'   => true, 
                'show_ui'  => true), 
            'objects' );

            // Filtrar post types irrelevantes automáticamente
            foreach ( $post_types as $slug => $post_type ) {
            // Excluir adjuntos (medios), plantillas de Elementor, revisiones y otros internos
                if ( in_array( $slug, array( 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'wp_block', 'elementor_library' ) ) ) {
                    unset( $post_types[ $slug ] );
                }
            }

            foreach ( $post_types as $type ) {
                $checked = ! empty( $settings['floating_locations'][$type->name] );
                echo '<label style="display:block;"><input type="checkbox" name="lw_wp_settings[floating_locations][' . esc_attr( $type->name ) . ']" value="1" ' . checked( $checked, true, false ) . '> ' . esc_html( $type->labels->singular_name ) . '</label>';
            }
            ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}