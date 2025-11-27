<?php
/**
 * Header template
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header header">
  <div class="container">
    <div class="navbar">
      <div class="logo">
        <?php if ( has_custom_logo() ) { the_custom_logo(); } else { ?><span><?php bloginfo('name'); ?></span><?php } ?>
      </div>
      <div class="search-bar">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <input type="search" placeholder="جستجوی محصول..." value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
        </form>
      </div>
      <div class="nav-actions">
        <a class="btn btn-secondary" href="<?php echo esc_url( wc_get_cart_url() ); ?>">🛒 <?php _e('سبد خرید','linkshop'); ?></a>
        <a class="btn btn-secondary" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">👤 <?php _e('حساب کاربری','linkshop'); ?></a>
      </div>
    </div>
    <nav>
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'nav-menu'
        ]);
      ?>
    </nav>
  </div>
</header>
<main class="site-main">
