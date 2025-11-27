<?php
defined( 'ABSPATH' ) || exit;
wc_print_notices();
?>
<div class="checkout-steps">
  <div class="step">1. آدرس</div>
  <div class="step">2. پرداخت</div>
  <div class="step">3. تایید</div>
</div>
<div class="glass-card">
  <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
  <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
    <div class="grid grid-2">
      <div>
        <h3><?php _e( 'اطلاعات خریدار', 'linkshop' ); ?></h3>
        <?php do_action( 'woocommerce_checkout_billing' ); ?>
      </div>
      <div>
        <h3><?php _e( 'سفارش شما', 'linkshop' ); ?></h3>
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
      </div>
    </div>
  </form>
  <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
