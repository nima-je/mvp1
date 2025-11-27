<?php
/** Footer template */
?>
</main>
<footer class="site-footer footer">
  <div class="container footer-grid">
    <div>
      <div class="logo"><?php if ( has_custom_logo() ) { the_custom_logo(); } else { bloginfo('name'); } ?></div>
      <p class="text-muted">فروشگاه اختصاصی با طراحی مدرن و تمرکز بر تجربه کاربری.</p>
    </div>
    <div>
      <h4><?php _e('ارتباط با ما','linkshop'); ?></h4>
      <p class="text-muted">021-12345678<br>info@example.com<br>تهران، ایران</p>
    </div>
    <div>
      <h4><?php _e('لینک‌های مفید','linkshop'); ?></h4>
      <ul class="footer-menu">
        <li><a href="#">درباره ما</a></li>
        <li><a href="#">تماس</a></li>
        <li><a href="#">سوالات متداول</a></li>
        <li><a href="#">وبلاگ</a></li>
        <li><a href="#">قوانین</a></li>
      </ul>
    </div>
    <div>
      <h4><?php _e('نماد اعتماد','linkshop'); ?></h4>
      <div class="glass-card">ENAMAD</div>
    </div>
  </div>
  <div class="container" style="margin-top:16px; text-align:center; color:var(--ls-muted);">
    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
