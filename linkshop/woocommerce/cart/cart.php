<?php
/**
 * Cart Page
 */
defined( 'ABSPATH' ) || exit;
wc_print_notices();
?>
<div class="glass-card">
  <h2><?php _e( 'سبد خرید', 'linkshop' ); ?></h2>
  <?php do_action( 'woocommerce_before_cart' ); ?>
  <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>
    <table class="shop_table shop_table_responsive cart table-like" cellspacing="0">
      <thead>
        <tr>
          <th><?php _e( 'محصول', 'linkshop' ); ?></th>
          <th><?php _e( 'قیمت', 'linkshop' ); ?></th>
          <th><?php _e( 'تعداد', 'linkshop' ); ?></th>
          <th><?php _e( 'جمع', 'linkshop' ); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>
        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
          if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
            $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
            ?>
            <tr>
              <td><?php echo $_product->get_image( 'thumbnail' ); ?> <?php echo wp_kses_post( $_product->get_name() ); ?></td>
              <td><?php echo WC()->cart->get_product_price( $_product ); ?></td>
              <td><?php
                echo woocommerce_quantity_input( [
                  'input_name'  => "cart[{$cart_item_key}][qty]",
                  'input_value' => $cart_item['quantity'],
                  'min_value'   => 0,
                  'max_value'   => $_product->get_max_purchase_quantity(),
                ], $_product, false );
              ?></td>
              <td><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></td>
            </tr>
          <?php endif; endforeach; ?>
        <?php do_action( 'woocommerce_cart_contents' ); ?>
      </tbody>
    </table>
    <button type="submit" class="btn btn-secondary" name="update_cart" value="<?php esc_attr_e( 'به‌روزرسانی', 'linkshop' ); ?>"><?php esc_html_e( 'به‌روزرسانی', 'linkshop' ); ?></button>
    <?php do_action( 'woocommerce_cart_actions' ); wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
  </form>
  <?php do_action( 'woocommerce_after_cart_table' ); ?>
</div>
<div class="cart-collaterals glass-card" style="margin-top:16px;">
  <?php woocommerce_cart_totals(); ?>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
