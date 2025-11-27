<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'admin_menu', function(){
    add_menu_page( __( 'لایسنس لینک‌شاپ', 'linkshop' ), 'LinkShop', 'manage_options', 'linkshop-license', 'linkshop_license_page', 'dashicons-admin-network' );
});

function linkshop_license_page() {
    if ( isset( $_POST['linkshop_license_key'] ) && check_admin_referer( 'linkshop_license_save' ) ) {
        $key = sanitize_text_field( wp_unslash( $_POST['linkshop_license_key'] ) );
        $response = wp_remote_post( 'https://license.example.test/check', [
            'body' => [ 'domain' => home_url(), 'license_key' => $key ],
            'timeout' => 5,
        ] );
        $status = is_wp_error( $response ) ? 'invalid' : 'valid';
        update_option( 'linkshop_license_status', $status );
        update_option( 'linkshop_license_key', $key );
        echo '<div class="updated"><p>' . esc_html__( 'لایسنس ذخیره شد.', 'linkshop' ) . '</p></div>';
    }
    $saved_key = get_option( 'linkshop_license_key', '' );
    ?>
    <div class="wrap">
      <h1><?php _e( 'مدیریت لایسنس', 'linkshop' ); ?></h1>
      <form method="post">
        <?php wp_nonce_field( 'linkshop_license_save' ); ?>
        <p><input type="text" name="linkshop_license_key" class="regular-text" value="<?php echo esc_attr( $saved_key ); ?>" placeholder="XXXX-XXXX"></p>
        <?php submit_button( __( 'ذخیره', 'linkshop' ) ); ?>
      </form>
    </div>
    <?php
}

add_action( 'admin_notices', function(){
    if ( ! current_user_can( 'manage_options' ) ) return;
    $status = get_option( 'linkshop_license_status', 'invalid' );
    if ( 'valid' !== $status ) {
        echo '<div class="notice notice-error"><p>' . esc_html__( 'لطفا لایسنس معتبر وارد کنید. قالب همچنان فعال است اما هشدار نمایش داده می‌شود.', 'linkshop' ) . '</p></div>';
    }
});
