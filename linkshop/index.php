<?php get_header(); ?>
<div class="container section">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article class="glass-card mb-3">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="text-muted"><?php the_excerpt(); ?></div>
    </article>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
