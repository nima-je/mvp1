<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Endpoint for invoice
add_action( 'init', function(){
    add_rewrite_endpoint( 'linkshop-invoice', EP_ALL );
});

add_filter( 'query_vars', function( $vars ){
    $vars[] = 'linkshop-invoice';
    return $vars;
});

add_action( 'template_redirect', function(){
    global $wp_query;
    if ( isset( $wp_query->query_vars['linkshop-invoice'] ) ) {
        $order_id = absint( get_query_var( 'linkshop-invoice' ) );
        $order = wc_get_order( $order_id );
        if ( $order ) {
            header( 'Content-Type: text/html; charset=utf-8' );
            echo linkshop_invoice_html( $order );
            exit;
        }
    }
});

function linkshop_invoice_html( $order ) {
    ob_start();
    ?>
    <style>
      body { font-family: Tahoma, sans-serif; direction: rtl; background: #f4f4f5; }
      .invoice { max-width: 720px; margin:20px auto; background:#fff; padding:20px; border-radius:12px; }
      .invoice h2 { margin-top:0; }
      table { width:100%; border-collapse: collapse; }
      th, td { padding:8px; border-bottom:1px solid #e5e7eb; text-align:right; }
    </style>
    <div class="invoice">
      <h2>فاکتور سفارش #<?php echo esc_html( $order->get_id() ); ?></h2>
      <p><?php echo esc_html( $order->get_formatted_billing_full_name() ); ?> | <?php echo esc_html( $order->get_billing_phone() ); ?></p>
      <table>
        <thead><tr><th>محصول</th><th>تعداد</th><th>مبلغ</th></tr></thead>
        <tbody>
          <?php foreach ( $order->get_items() as $item ) : ?>
            <tr>
              <td><?php echo esc_html( $item->get_name() ); ?></td>
              <td><?php echo esc_html( $item->get_quantity() ); ?></td>
              <td><?php echo wc_price( $item->get_total() ); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p><strong>جمع کل: </strong><?php echo wc_price( $order->get_total() ); ?></p>
      <p class="text-muted">تبدیل به PDF: TODO با کتابخانه HTML به PDF.</p>
    </div>
    <?php
    return ob_get_clean();
}

// Add link in My Account orders
add_filter( 'woocommerce_my_account_my_orders_actions', function( $actions, $order ){
    $actions['invoice'] = [
        'url' => add_query_arg( 'linkshop-invoice', $order->get_id(), wc_get_account_endpoint_url( 'orders' ) ),
        'name' => __( 'دانلود فاکتور', 'linkshop' )
    ];
    return $actions;
}, 10, 2 );
