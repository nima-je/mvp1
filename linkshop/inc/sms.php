<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function linkshop_send_sms( $event, $data ) {
    $message = sprintf( '[LinkShop %s] %s', $event, wp_json_encode( $data ) );
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( $message );
    }
    // Placeholder for provider call:
    // wp_remote_post( 'https://sms-provider.test/send', [ 'body' => [ 'to' => $data['phone'], 'message' => $data['message'] ] ] );
}

// Hooks
add_action( 'woocommerce_thankyou', function( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( $order ) {
        linkshop_send_sms( 'order_created', [
            'phone' => $order->get_billing_phone(),
            'order_id' => $order_id,
            'message' => sprintf( 'سفارش #%s ثبت شد', $order_id ),
        ] );
    }
});

add_action( 'woocommerce_order_status_changed', function( $order_id, $old, $new ) {
    $order = wc_get_order( $order_id );
    linkshop_send_sms( 'order_status_changed', [
        'phone' => $order ? $order->get_billing_phone() : '',
        'order_id' => $order_id,
        'message' => sprintf( 'وضعیت سفارش #%s به %s تغییر کرد', $order_id, $new ),
    ] );
}, 10, 3 );

add_action( 'user_register', function( $user_id ) {
    $user = get_userdata( $user_id );
    linkshop_send_sms( 'user_registered', [
        'phone' => $user ? get_user_meta( $user_id, 'phone', true ) : '',
        'message' => 'ثبت‌نام موفق',
    ] );
});
