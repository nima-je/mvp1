<?php get_header(); ?>
<section class="hero container glass-card">
  <div>
    <h1><?php bloginfo('name'); ?></h1>
    <p class="text-muted"><?php bloginfo('description'); ?></p>
    <div class="cta-buttons">
      <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>" class="btn btn-primary">مشاهده محصولات</a>
      <a href="#offers" class="btn btn-secondary">پیشنهاد ویژه</a>
    </div>
  </div>
  <div class="glass-card">
    <p>جایگاه بنر یا اسلایدر</p>
    <div style="height:160px; background:rgba(255,255,255,0.04); border-radius:var(--ls-border-radius);"></div>
  </div>
</section>

<section class="section category-grid container">
  <div class="section-header">
    <h2>دسته‌بندی‌ها</h2>
    <a class="btn-ghost" href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">همه</a>
  </div>
  <div class="grid grid-4">
    <?php
    $terms = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 8 ] );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            echo '<div class="cat-card">';
            echo '<div style="width:60px;height:60px;margin:0 auto 8px;background:rgba(255,255,255,0.1);border-radius:50%;"></div>';
            echo '<div>' . esc_html( $term->name ) . '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-muted">دسته‌ای ثبت نشده است.</p>';
    }
    ?>
  </div>
</section>

<?php
$sections = [
  'bestseller' => __( 'پرفروش‌ترین‌ها', 'linkshop' ),
  'newest' => __( 'جدیدترین‌ها', 'linkshop' ),
];
foreach ( $sections as $key => $label ) :
  $args = [ 'post_type' => 'product', 'posts_per_page' => 8 ];
  if ( 'newest' === $key ) {
    $args['orderby'] = 'date';
  }
  $query = new WP_Query( $args );
  if ( $query->have_posts() ) : ?>
  <section class="section container">
    <div class="section-header">
      <h2><?php echo esc_html( $label ); ?></h2>
      <a class="btn-ghost" href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">همه</a>
    </div>
    <div class="shop-grid">
      <?php while ( $query->have_posts() ) : $query->the_post(); global $product; ?>
        <article class="product-card glass-card">
          <a href="<?php the_permalink(); ?>">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); } else { echo '<div style="height:180px;background:rgba(255,255,255,0.05);border-radius:var(--ls-border-radius);"></div>'; } ?>
          </a>
          <div>
            <h3 style="font-size:1.1rem;"><?php the_title(); ?></h3>
            <div class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
          </div>
          <div>
            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-primary" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">افزودن به سبد</a>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
  <?php endif; endforeach; ?>

<section id="offers" class="section container">
  <div class="section-header">
    <h2>پیشنهاد ویژه</h2>
    <span class="text-muted" data-countdown="<?php echo esc_attr( date( 'Y-m-d H:i:s', strtotime('+5 hours') ) ); ?>">در حال محاسبه...</span>
  </div>
  <div class="shop-grid">
    <?php
    $sale_query = new WP_Query([
      'post_type' => 'product',
      'posts_per_page' => 4,
      'meta_query' => [
        [ 'key' => '_sale_price', 'value' => 0, 'compare' => '>' ]
      ]
    ]);
    if ( $sale_query->have_posts() ) {
      while ( $sale_query->have_posts() ) { $sale_query->the_post(); global $product; ?>
        <article class="product-card glass-card">
          <span class="badge">تخفیف</span>
          <a href="<?php the_permalink(); ?>">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); } else { echo '<div style="height:180px;background:rgba(255,255,255,0.05);border-radius:var(--ls-border-radius);"></div>'; } ?>
          </a>
          <h3 style="font-size:1.1rem;"><?php the_title(); ?></h3>
          <div class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
          <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-primary">افزودن به سبد</a>
        </article>
    <?php }
    } else {
      echo '<p class="text-muted">پیشنهاد ویژه‌ای موجود نیست.</p>';
    }
    wp_reset_postdata();
    ?>
  </div>
</section>

<section class="section container promo-banners">
  <div class="banner">
    <h3>ارسال سریع</h3>
    <p class="text-muted">تحویل در کوتاه‌ترین زمان</p>
  </div>
  <div class="banner">
    <h3>ضمانت اصالت کالا</h3>
    <p class="text-muted">کالاهای اصل و معتبر</p>
  </div>
  <div class="banner">
    <h3>پشتیبانی ۲۴/۷</h3>
    <p class="text-muted">همیشه در دسترس</p>
  </div>
</section>

<?php get_footer(); ?>
