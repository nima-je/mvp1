<?php defined( 'ABSPATH' ) || exit; ?>
<div class="glass-card">
  <h2><?php _e( 'داشبورد حساب', 'linkshop' ); ?></h2>
  <p><?php printf( __( 'سلام %1$s', 'linkshop' ), '<strong>' . esc_html( $current_user->display_name ) . '</strong>' ); ?></p>
  <div class="grid grid-3">
    <div class="glass-card"><h3>سفارش‌ها</h3><p><?php echo wc_get_customer_order_count( get_current_user_id() ); ?></p></div>
    <div class="glass-card"><h3>آدرس‌ها</h3><p><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>">ویرایش</a></p></div>
    <div class="glass-card"><h3>جزئیات حساب</h3><p><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>">مدیریت</a></p></div>
  </div>
</div>
<?php do_action( 'woocommerce_account_dashboard' ); ?>
