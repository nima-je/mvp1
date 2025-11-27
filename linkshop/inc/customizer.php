<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'customize_register', 'linkshop_customize_register' );
function linkshop_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'linkshop_primary_color', [
        'default' => '#ff3d71',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'linkshop_primary_color', [
        'label' => __( 'رنگ اصلی', 'linkshop' ),
        'section' => 'colors',
    ] ) );
}

add_action( 'wp_head', 'linkshop_customizer_css' );
function linkshop_customizer_css() {
    $primary = get_theme_mod( 'linkshop_primary_color', '#ff3d71' );
    echo '<style>:root{--ls-primary-color:' . esc_attr( $primary ) . ';}</style>';
}
