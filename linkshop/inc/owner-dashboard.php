<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function linkshop_is_owner_user() {
    return current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' );
}

function linkshop_get_sales_metrics() {
    $today_start = strtotime( 'today', current_time( 'timestamp' ) );
    $month_start = strtotime( date( 'Y-m-01', current_time( 'timestamp' ) ) );

    return [
        'today_sales'   => linkshop_sum_orders_total( [ 'date_created' => [ 'after' => gmdate( 'Y-m-d H:i:s', $today_start ) ] ] ),
        'month_sales'   => linkshop_sum_orders_total( [ 'date_created' => [ 'after' => gmdate( 'Y-m-d H:i:s', $month_start ) ] ] ),
        'today_orders'  => linkshop_count_orders( [ 'date_created' => [ 'after' => gmdate( 'Y-m-d H:i:s', $today_start ) ] ] ),
        'month_orders'  => linkshop_count_orders( [ 'date_created' => [ 'after' => gmdate( 'Y-m-d H:i:s', $month_start ) ] ] ),
    ];
}

function linkshop_sum_orders_total( $args ) {
    $orders = wc_get_orders( wp_parse_args( $args, [ 'return' => 'ids', 'limit' => -1, 'status' => array_keys( wc_get_order_statuses() ) ] ) );
    $sum    = 0;
    foreach ( $orders as $order_id ) {
        $order = wc_get_order( $order_id );
        if ( $order ) {
            $sum += (float) $order->get_total();
        }
    }
    return $sum;
}

function linkshop_count_orders( $args ) {
    $orders = wc_get_orders( wp_parse_args( $args, [ 'return' => 'ids', 'limit' => -1, 'status' => array_keys( wc_get_order_statuses() ) ] ) );
    return is_array( $orders ) ? count( $orders ) : 0;
}

function linkshop_get_recent_orders( $limit = 6 ) {
    return wc_get_orders( [
        'limit'     => absint( $limit ),
        'orderby'   => 'date',
        'order'     => 'DESC',
        'status'    => array_keys( wc_get_order_statuses() ),
    ] );
}

function linkshop_get_low_stock_products( $limit = 6 ) {
    $products = wc_get_products( [
        'status'      => 'publish',
        'meta_key'    => '_stock',
        'orderby'     => 'meta_value_num',
        'order'       => 'ASC',
        'limit'       => absint( $limit * 2 ),
        'stock_status'=> [ 'instock', 'onbackorder' ],
    ] );
    $low_stock = [];
    foreach ( $products as $product ) {
        $threshold = wc_get_low_stock_amount( $product );
        $stock     = $product->get_stock_quantity();
        if ( null === $stock ) {
            continue;
        }
        if ( $stock <= $threshold ) {
            $low_stock[] = $product;
        }
        if ( count( $low_stock ) >= $limit ) {
            break;
        }
    }
    return $low_stock;
}

function linkshop_get_best_sellers( $limit = 6 ) {
    return wc_get_products( [
        'status'    => 'publish',
        'limit'     => absint( $limit ),
        'meta_key'  => 'total_sales',
        'orderby'   => 'meta_value_num',
        'order'     => 'DESC',
    ] );
}

function linkshop_get_customer_overview() {
    $users = count_users();
    $total = isset( $users['avail_roles']['customer'] ) ? absint( $users['avail_roles']['customer'] ) : 0;
    $recent = new WP_User_Query( [
        'role'    => 'customer',
        'orderby' => 'registered',
        'order'   => 'DESC',
        'number'  => 5,
    ] );
    $month_new = new WP_User_Query( [
        'role'       => 'customer',
        'date_query' => [
            [ 'after' => gmdate( 'Y-m-d', strtotime( '-30 days', current_time( 'timestamp' ) ) ) ],
        ],
        'fields'     => 'ID',
        'number'     => 100,
    ] );

    return [
        'total_customers' => $total,
        'new_30_days'     => is_array( $month_new->get_results() ) ? count( $month_new->get_results() ) : 0,
        'recent'          => $recent->get_results(),
    ];
}

function linkshop_get_license_status_data() {
    return [
        'status' => get_option( 'linkshop_license_status', 'unknown' ),
        'domain' => home_url(),
        'key'    => get_option( 'linkshop_license_key', '' ),
    ];
}

function linkshop_get_sms_log( $limit = 5 ) {
    $log = get_option( 'linkshop_sms_log', [] );
    if ( ! is_array( $log ) ) {
        $log = [];
    }
    return array_slice( array_reverse( $log ), 0, absint( $limit ) );
}

function linkshop_append_sms_log( $event, $data ) {
    $log   = get_option( 'linkshop_sms_log', [] );
    $log[] = [
        'event'   => $event,
        'data'    => $data,
        'time'    => current_time( 'mysql' ),
    ];
    update_option( 'linkshop_sms_log', array_slice( $log, -20 ) );
}

add_action( 'linkshop_sms_logged', 'linkshop_append_sms_log', 10, 2 );

function linkshop_owner_activity_log() {
    $log = get_option( 'linkshop_activity_log', [] );
    if ( ! is_array( $log ) ) {
        $log = [];
    }
    return array_slice( array_reverse( $log ), 0, 8 );
}

function linkshop_log_activity( $message ) {
    $log   = get_option( 'linkshop_activity_log', [] );
    $log[] = [ 'message' => $message, 'time' => current_time( 'mysql' ) ];
    update_option( 'linkshop_activity_log', array_slice( $log, -20 ) );
}

add_action( 'woocommerce_thankyou', function( $order_id ) {
    linkshop_log_activity( sprintf( __( 'سفارش #%s ایجاد شد', 'linkshop' ), absint( $order_id ) ) );
});

add_action( 'woocommerce_order_status_changed', function( $order_id, $old, $new ) {
    linkshop_log_activity( sprintf( __( 'وضعیت سفارش #%1$s از %2$s به %3$s تغییر کرد', 'linkshop' ), absint( $order_id ), esc_html( $old ), esc_html( $new ) ) );
}, 10, 3 );

add_action( 'user_register', function( $user_id ) {
    $user = get_userdata( $user_id );
    if ( $user ) {
        linkshop_log_activity( sprintf( __( 'کاربر جدید: %s', 'linkshop' ), esc_html( $user->display_name ) ) );
    }
});
