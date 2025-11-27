<?php
defined( 'ABSPATH' ) || exit;
global $product;
if ( empty( $product ) || ! $product->is_visible() ) { return; }
?>
<li <?php wc_product_class( 'product-card glass-card', $product ); ?>>
  <a href="<?php the_permalink(); ?>">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'woocommerce_thumbnail' ); } else { echo '<div style="height:180px;background:rgba(255,255,255,0.05);border-radius:var(--ls-border-radius);"></div>'; } ?>
  </a>
  <h2 class="woocommerce-loop-product__title" style="font-size:1.1rem;"><?php the_title(); ?></h2>
  <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
  <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-primary" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"><?php esc_html_e( 'افزودن به سبد', 'linkshop' ); ?></a>
</li>
