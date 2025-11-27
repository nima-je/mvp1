<?php get_header(); ?>
<div class="container section">
  <?php linkshop_breadcrumbs(); ?>
  <h1><?php the_archive_title(); ?></h1>
  <div class="grid grid-2">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="glass-card">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="text-muted"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; endif; ?>
  </div>
</div>
<?php get_footer(); ?>
