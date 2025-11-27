<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' ); ?>
<div class="shop-toolbar glass-card">
  <div><?php woocommerce_result_count(); ?></div>
  <div><?php woocommerce_catalog_ordering(); ?></div>
</div>
<?php if ( woocommerce_product_loop() ) : ?>
  <?php woocommerce_product_loop_start(); ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <?php wc_get_template_part( 'content', 'product' ); ?>
  <?php endwhile; ?>
  <?php woocommerce_product_loop_end(); ?>
  <?php do_action( 'woocommerce_after_shop_loop' ); ?>
<?php else : ?>
  <?php do_action( 'woocommerce_no_products_found' ); ?>
<?php endif; ?>
<?php get_footer( 'shop' ); ?>
