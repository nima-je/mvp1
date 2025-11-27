<?php get_header(); ?>
<div class="container section glass-card">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div class="text-muted mb-3"><?php echo get_the_date(); ?></div>
    <div><?php the_content(); ?></div>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
