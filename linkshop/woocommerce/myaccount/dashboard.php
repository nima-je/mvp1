<?php defined( 'ABSPATH' ) || exit; ?>
<?php
$current_user = wp_get_current_user();
if ( function_exists( 'linkshop_is_owner_user' ) && linkshop_is_owner_user() ) : ?>
    <?php
    $metrics     = linkshop_get_sales_metrics();
    $recent      = linkshop_get_recent_orders( 6 );
    $low_stock   = linkshop_get_low_stock_products( 5 );
    $best        = linkshop_get_best_sellers( 5 );
    $customers   = linkshop_get_customer_overview();
    $license     = linkshop_get_license_status_data();
    $sms_log     = linkshop_get_sms_log( 5 );
    $activities  = linkshop_owner_activity_log();
    ?>
    <div class="owner-dashboard">
        <h2><?php _e( 'داشبورد مالک فروشگاه', 'linkshop' ); ?></h2>
        <div class="owner-grid">
            <div class="owner-card">
                <h4><?php _e( 'فروش امروز', 'linkshop' ); ?></h4>
                <div class="owner-stat"><?php echo wp_kses_post( wc_price( $metrics['today_sales'] ) ); ?></div>
            </div>
            <div class="owner-card">
                <h4><?php _e( 'فروش ماه جاری', 'linkshop' ); ?></h4>
                <div class="owner-stat"><?php echo wp_kses_post( wc_price( $metrics['month_sales'] ) ); ?></div>
            </div>
            <div class="owner-card">
                <h4><?php _e( 'تعداد سفارش‌های امروز', 'linkshop' ); ?></h4>
                <div class="owner-stat"><?php echo esc_html( $metrics['today_orders'] ); ?></div>
            </div>
            <div class="owner-card">
                <h4><?php _e( 'تعداد سفارش‌های ماه', 'linkshop' ); ?></h4>
                <div class="owner-stat"><?php echo esc_html( $metrics['month_orders'] ); ?></div>
            </div>
        </div>

        <div class="owner-card">
            <div class="owner-section-title">
                <h3><?php _e( 'سفارش‌های اخیر', 'linkshop' ); ?></h3>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>" target="_blank"><?php _e( 'مشاهده همه', 'linkshop' ); ?></a>
            </div>
            <table class="owner-table">
                <thead><tr><th><?php _e( 'سفارش', 'linkshop' ); ?></th><th><?php _e( 'مشتری', 'linkshop' ); ?></th><th><?php _e( 'وضعیت', 'linkshop' ); ?></th><th><?php _e( 'مجموع', 'linkshop' ); ?></th><th><?php _e( 'تاریخ', 'linkshop' ); ?></th><th></th></tr></thead>
                <tbody>
                <?php if ( $recent ) : foreach ( $recent as $order ) : ?>
                    <tr>
                        <td>#<?php echo esc_html( $order->get_id() ); ?></td>
                        <td><?php echo esc_html( $order->get_formatted_billing_full_name() ?: $order->get_billing_first_name() ); ?></td>
                        <td><span class="owner-badge"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span></td>
                        <td><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                        <td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                        <td><a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->get_id() . '&action=edit' ) ); ?>" target="_blank"><?php _e( 'جزئیات', 'linkshop' ); ?></a></td>
                    </tr>
                <?php endforeach; else : ?>
                    <tr><td colspan="6"><?php _e( 'سفارشی موجود نیست.', 'linkshop' ); ?></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="owner-grid">
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'هشدار موجودی کم', 'linkshop' ); ?></h3></div>
                <ul class="owner-list">
                    <?php if ( $low_stock ) : foreach ( $low_stock as $product ) : ?>
                        <li>
                            <span><?php echo esc_html( $product->get_name() ); ?></span>
                            <span>
                                <span class="owner-badge"><?php printf( __( '%s عدد', 'linkshop' ), esc_html( $product->get_stock_quantity() ) ); ?></span>
                                <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $product->get_id() . '&action=edit' ) ); ?>" target="_blank"><?php _e( 'ویرایش', 'linkshop' ); ?></a>
                            </span>
                        </li>
                    <?php endforeach; else : ?>
                        <li><?php _e( 'محصول کم‌موجودی وجود ندارد.', 'linkshop' ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'پرفروش‌ها', 'linkshop' ); ?></h3></div>
                <ul class="owner-list">
                    <?php if ( $best ) : foreach ( $best as $product ) : ?>
                        <li>
                            <span><?php echo esc_html( $product->get_name() ); ?></span>
                            <span>
                                <span class="owner-badge"><?php printf( __( 'فروش: %s', 'linkshop' ), esc_html( $product->get_total_sales() ) ); ?></span>
                                <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $product->get_id() . '&action=edit' ) ); ?>" target="_blank"><?php _e( 'ویرایش', 'linkshop' ); ?></a>
                            </span>
                        </li>
                    <?php endforeach; else : ?>
                        <li><?php _e( 'داده‌ای برای نمایش وجود ندارد.', 'linkshop' ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="owner-grid">
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'مشتریان', 'linkshop' ); ?></h3></div>
                <p><?php printf( __( 'کل مشتریان: %s', 'linkshop' ), '<strong>' . esc_html( $customers['total_customers'] ) . '</strong>' ); ?></p>
                <p><?php printf( __( 'مشتریان جدید ۳۰ روز اخیر: %s', 'linkshop' ), '<strong>' . esc_html( $customers['new_30_days'] ) . '</strong>' ); ?></p>
                <ul class="owner-list">
                    <?php if ( $customers['recent'] ) : foreach ( $customers['recent'] as $user ) : ?>
                        <li>
                            <span><?php echo esc_html( $user->display_name ); ?></span>
                            <span class="owner-badge"><?php echo esc_html( mysql2date( 'Y/m/d', $user->user_registered ) ); ?></span>
                        </li>
                    <?php endforeach; else : ?>
                        <li><?php _e( 'هنوز مشتریی ثبت نشده است.', 'linkshop' ); ?></li>
                    <?php endif; ?>
                </ul>
                <a href="<?php echo esc_url( admin_url( 'users.php' ) ); ?>" target="_blank"><?php _e( 'مشاهده همه کاربران', 'linkshop' ); ?></a>
            </div>
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'وضعیت لایسنس', 'linkshop' ); ?></h3></div>
                <p><?php printf( __( 'وضعیت: %s', 'linkshop' ), '<strong>' . esc_html( $license['status'] ) . '</strong>' ); ?></p>
                <p><?php printf( __( 'دامنه: %s', 'linkshop' ), esc_html( $license['domain'] ) ); ?></p>
                <?php if ( ! empty( $license['key'] ) ) : ?>
                    <p><?php printf( __( 'کلید: %s', 'linkshop' ), esc_html( $license['key'] ) ); ?></p>
                <?php endif; ?>
                <a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=linkshop-license' ) ); ?>"><?php _e( 'مدیریت لایسنس', 'linkshop' ); ?></a>
            </div>
        </div>

        <div class="owner-grid">
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'آخرین رویدادهای پیامک', 'linkshop' ); ?></h3></div>
                <ul class="owner-list">
                    <?php if ( $sms_log ) : foreach ( $sms_log as $log ) : ?>
                        <li>
                            <span><?php echo esc_html( $log['event'] ); ?></span>
                            <span class="owner-badge"><?php echo esc_html( $log['time'] ); ?></span>
                        </li>
                    <?php endforeach; else : ?>
                        <li><?php _e( 'لاگی برای پیامک موجود نیست.', 'linkshop' ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="owner-card">
                <div class="owner-section-title"><h3><?php _e( 'فعالیت اخیر', 'linkshop' ); ?></h3></div>
                <ul class="owner-list">
                    <?php if ( $activities ) : foreach ( $activities as $row ) : ?>
                        <li>
                            <span><?php echo esc_html( $row['message'] ); ?></span>
                            <span class="owner-badge"><?php echo esc_html( $row['time'] ); ?></span>
                        </li>
                    <?php endforeach; else : ?>
                        <li><?php _e( 'هنوز رویدادی ثبت نشده است.', 'linkshop' ); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="owner-card">
            <div class="owner-section-title"><h3><?php _e( 'اقدامات سریع', 'linkshop' ); ?></h3></div>
            <div class="owner-actions">
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>" target="_blank"><?php _e( 'افزودن محصول جدید', 'linkshop' ); ?></a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>" target="_blank"><?php _e( 'مشاهده محصولات', 'linkshop' ); ?></a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>" target="_blank"><?php _e( 'مدیریت سفارش‌ها', 'linkshop' ); ?></a>
                <a href="<?php echo esc_url( admin_url( 'users.php' ) ); ?>" target="_blank"><?php _e( 'مدیریت مشتریان', 'linkshop' ); ?></a>
                <a href="<?php echo esc_url( admin_url() ); ?>" target="_blank"><?php _e( 'پنل مدیریت وردپرس', 'linkshop' ); ?></a>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="glass-card">
        <h2><?php _e( 'داشبورد حساب', 'linkshop' ); ?></h2>
        <p><?php printf( __( 'سلام %1$s', 'linkshop' ), '<strong>' . esc_html( $current_user->display_name ) . '</strong>' ); ?></p>
        <div class="grid grid-3">
            <div class="glass-card"><h3><?php _e( 'سفارش‌ها', 'linkshop' ); ?></h3><p><?php echo esc_html( wc_get_customer_order_count( get_current_user_id() ) ); ?></p></div>
            <div class="glass-card"><h3><?php _e( 'آدرس‌ها', 'linkshop' ); ?></h3><p><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>"><?php _e( 'ویرایش', 'linkshop' ); ?></a></p></div>
            <div class="glass-card"><h3><?php _e( 'جزئیات حساب', 'linkshop' ); ?></h3><p><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>"><?php _e( 'مدیریت', 'linkshop' ); ?></a></p></div>
        </div>
    </div>
<?php endif; ?>
<?php do_action( 'woocommerce_account_dashboard' ); ?>
