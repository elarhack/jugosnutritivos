<?php
/**
* A  Category Template
*/
 ?>

<?php get_header(); ?> 
<div  class="category">
  <section class="wrapper">
    <div class="category__content">
      <?php while ( have_posts() ) : the_post(); //El Loop ?>
      <div class="category__content__publication">
      <a href="<?php the_permalink(); ?>">
        <?php if( has_post_thumbnail() ){
                                the_post_thumbnail('medium','url','lazy', array('class'=>''));}?>
          <div class="category__content__publication__detail">
            <h2><?php the_title(); ?></h2>
            <div class="date"><?php the_time('F jS, Y') ?> |</div>
			  <?php $post_views = get_post_views(get_the_ID());?><img class="view" src="<?php bloginfo('template_url')?>/images/eye.svg" alt="" /><span class="view-count"><?php echo sprintf( _n( '%s vez', '%s ', $post_views, 'your_textdomain' ), $post_views );?></span>
            <p><?php the_excerpt(); ?></p></a>
          </div>

      </div>
      <?php endwhile; wp_reset_query(); ?>
    </div>
  </section>
</div>


<?php get_footer(); ?>