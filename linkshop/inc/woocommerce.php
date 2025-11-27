<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Wrap content for styling
add_action( 'woocommerce_before_main_content', function(){
    echo '<div class="container section">';
}, 5 );
add_action( 'woocommerce_after_main_content', function(){
    echo '</div>';
}, 50 );

// Products per row
add_filter( 'loop_shop_columns', function(){ return 3; } );

// Add custom breadcrumb wrapper
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
    $defaults['wrap_before'] = '<nav class="breadcrumbs">';
    $defaults['wrap_after']  = '</nav>';
    return $defaults;
});

// Mini countdown meta placeholder
add_action( 'woocommerce_single_product_summary', function(){
    $deadline = get_post_meta( get_the_ID(), '_linkshop_flash_deadline', true );
    if ( $deadline ) {
        echo '<div class="glass-card" style="margin:12px 0;" data-countdown="' . esc_attr( $deadline ) . '">' . esc_html__( 'زمان باقی‌مانده', 'linkshop' ) . '</div>';
    }
}, 6 );

// Enqueue styles for Woo templates
add_action( 'wp_enqueue_scripts', function(){
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'linkshop-woocommerce', get_template_directory_uri() . '/assets/css/main.css', [ 'linkshop-style' ], LINKSHOP_VERSION );
    }
});
