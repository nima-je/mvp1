<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $linkshop_analytics_table;
$linkshop_analytics_table = 'linkshop_analytics';

add_action( 'after_switch_theme', 'linkshop_install_analytics' );
function linkshop_install_analytics() {
    global $wpdb, $linkshop_analytics_table;
    $table = $wpdb->prefix . $linkshop_analytics_table;
    $charset = $wpdb->get_charset_collate();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $sql = "CREATE TABLE {$table} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        day date NOT NULL,
        metric varchar(60) NOT NULL,
        value bigint(20) NOT NULL DEFAULT 0,
        meta text NULL,
        PRIMARY KEY (id),
        KEY day (day)
    ) $charset;";
    dbDelta( $sql );
}

add_action( 'init', 'linkshop_track_visit' );
function linkshop_track_visit() {
    if ( is_admin() ) { return; }
    $day = gmdate( 'Y-m-d' );
    $utm = [
        'source' => isset( $_GET['utm_source'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_source'] ) ) : '',
        'medium' => isset( $_GET['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) : '',
        'campaign' => isset( $_GET['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ) : '',
    ];
    if ( ! empty( array_filter( $utm ) ) ) {
        foreach ( $utm as $key => $val ) {
            if ( $val ) {
                setcookie( 'linkshop_' . $key, $val, time() + DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
            }
        }
    }
    linkshop_increment_metric( 'visits', 1, $day );
}

add_action( 'woocommerce_thankyou', function( $order_id ){
    $order = wc_get_order( $order_id );
    $day = gmdate( 'Y-m-d' );
    linkshop_increment_metric( 'orders', 1, $day, [ 'order_id' => $order_id ] );
    linkshop_increment_metric( 'sales', (int) $order->get_total(), $day );
});

add_action( 'user_register', function(){
    linkshop_increment_metric( 'new_customers', 1, gmdate( 'Y-m-d' ) );
});

function linkshop_increment_metric( $metric, $value, $day, $meta = [] ) {
    global $wpdb, $linkshop_analytics_table;
    $table = $wpdb->prefix . $linkshop_analytics_table;
    $wpdb->insert( $table, [
        'day' => $day,
        'metric' => $metric,
        'value' => $value,
        'meta' => wp_json_encode( $meta ),
    ], [ '%s', '%s', '%d', '%s' ] );
}

add_action( 'admin_menu', function(){
    add_submenu_page( 'linkshop-license', __( 'آنالیتیکس', 'linkshop' ), __( 'آنالیتیکس', 'linkshop' ), 'manage_options', 'linkshop-analytics', 'linkshop_analytics_page' );
});

function linkshop_analytics_page() {
    global $wpdb, $linkshop_analytics_table;
    $table = $wpdb->prefix . $linkshop_analytics_table;
    $rows = $wpdb->get_results( "SELECT day, metric, SUM(value) as total FROM {$table} GROUP BY day, metric ORDER BY day DESC LIMIT 30" );
    ?>
    <div class="wrap">
      <h1><?php _e( 'داشبورد تحلیلی', 'linkshop' ); ?></h1>
      <div class="linkshop-card">
        <table class="wp-list-table widefat">
          <thead><tr><th><?php _e('روز','linkshop'); ?></th><th><?php _e('شاخص','linkshop'); ?></th><th><?php _e('مقدار','linkshop'); ?></th></tr></thead>
          <tbody>
            <?php foreach ( (array) $rows as $row ) : ?>
              <tr>
                <td><?php echo esc_html( $row->day ); ?></td>
                <td><?php echo esc_html( $row->metric ); ?></td>
                <td><?php echo esc_html( $row->total ); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
}
