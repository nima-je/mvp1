<?php
/**
 * Theme setup and assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', 'linkshop_setup' );
function linkshop_setup() {
    load_theme_textdomain( 'linkshop', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', [ 'height' => 60, 'flex-height' => true, 'flex-width' => true ] );
    add_theme_support( 'woocommerce' );
    register_nav_menus( [
        'primary' => __( 'منوی اصلی', 'linkshop' ),
        'footer'  => __( 'منوی فوتر', 'linkshop' ),
    ] );
}

add_action( 'wp_enqueue_scripts', 'linkshop_assets' );
function linkshop_assets() {
    $theme_version = LINKSHOP_VERSION;
    wp_enqueue_style( 'linkshop-style', get_stylesheet_uri(), [], $theme_version );
    wp_enqueue_script( 'linkshop-main', get_template_directory_uri() . '/assets/js/main.js', [ 'jquery' ], $theme_version, true );
    wp_localize_script( 'linkshop-main', 'linkshopData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'i18n'    => [ 'addToCart' => __( 'افزودن به سبد', 'linkshop' ) ],
    ] );

    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        wp_enqueue_style( 'linkshop-owner-dashboard', get_template_directory_uri() . '/assets/css/admin-dashboard.css', [ 'linkshop-style' ], $theme_version );
    }
}

add_action( 'admin_enqueue_scripts', 'linkshop_admin_assets' );
function linkshop_admin_assets() {
    wp_enqueue_style( 'linkshop-admin', get_template_directory_uri() . '/assets/css/admin.css', [], LINKSHOP_VERSION );
    wp_enqueue_script( 'linkshop-admin', get_template_directory_uri() . '/assets/js/admin.js', [ 'jquery' ], LINKSHOP_VERSION, true );
}

// Breadcrumb helper.
function linkshop_breadcrumbs() {
    echo '<div class="breadcrumbs">';
    echo '<a href="' . esc_url( home_url() ) . '">' . esc_html__( 'خانه', 'linkshop' ) . '</a> / ';
    if ( is_singular() ) {
        the_title();
    } elseif ( is_archive() ) {
        the_archive_title();
    } elseif ( is_search() ) {
        printf( esc_html__( 'نتایج جستجو برای %s', 'linkshop' ), esc_html( get_search_query() ) );
    }
    echo '</div>';
}
