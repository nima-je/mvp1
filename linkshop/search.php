<?php get_header(); ?>
<div class="container section">
  <h1><?php printf( esc_html__( 'نتایج برای: %s', 'linkshop' ), esc_html( get_search_query() ) ); ?></h1>
  <div class="grid grid-2">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="glass-card">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="text-muted"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; else: ?>
      <p class="text-muted">موردی یافت نشد.</p>
    <?php endif; ?>
  </div>
</div>
<?php get_footer(); ?>
