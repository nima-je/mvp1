<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' ); ?>
<div class="product-layout">
  <div class="product-gallery">
    <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
  </div>
  <div class="product-summary glass-card">
    <?php do_action( 'woocommerce_single_product_summary' ); ?>
  </div>
</div>
<div class="product-tabs">
  <div class="tab-nav">
    <button class="active" data-target="#tab-desc">توضیحات</button>
    <button data-target="#tab-spec">مشخصات</button>
    <button data-target="#tab-reviews">نظرات</button>
  </div>
  <div id="tab-desc" class="tab-panel active">
    <?php the_content(); ?>
  </div>
  <div id="tab-spec" class="tab-panel">
    <?php do_action( 'woocommerce_product_additional_information', $product ); ?>
  </div>
  <div id="tab-reviews" class="tab-panel">
    <?php comments_template(); ?>
  </div>
</div>
<div class="related-grid">
  <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
</div>
<?php get_footer( 'shop' ); ?>
