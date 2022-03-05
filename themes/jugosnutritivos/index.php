<?php get_header(); ?>
<?php
/*
Template Name: blog - inicio
*/
?>
<section class="hero">
    <div class="wrapper">
      <div class="hero__content">
        <?php
            $args = array(
                'posts_per_page' =>6,
                'meta_key' => 'post_views',
                'orderby' => 'post_date',
                'order' => 'DESC'
            );
            ?>
            	<?php
                  $popular_posts = new WP_Query( $args );
                  ?><?php 
                  while ( $popular_posts->have_posts() ) : $popular_posts->the_post();?>

                    <div class="hero__content__post">
                    <a href="<?php the_permalink(); ?>">
                       <?php if( has_post_thumbnail() ){
                         the_post_thumbnail('medium_large','url','loading', array('class'=>''));}
                       ?>
                        <div class="hero__content__post__sumary">
                        <h2 class="title"><?php the_title();?></h2>
                        <p><?php the_category(', ') ?>
                        <p><?php echo get_the_date(); ?></p>
                        
                        </a>
                <?php   ?>
                </div></div>
            <?php
                endwhile; 
                wp_reset_postdata();
          ?>
      </div>
    </div>
</section>
<section class="home-title">
  <div class="wrapper">
    <div class="home-title-background">
      <h1>JUGOS NUTRITIVOS</h1> 
      <p>Nuestro sistema inmunológico necesita diferentes vitaminas y minerales, los jugos nutritivos los aportaran, son jugos medicinales muy 
        buenos para mejorar nuestra salud, te ayudara también en perder peso, estimulara la digestión, mejorara nuestra salud con estos 
        jugos nutritivos así tendremos una vida mas saludable.</p>    
    </div>
  </div>
</section>

<section class="backend">
  <div class="wrapper">
    <h2>JUGOS RECIENTES</h2>
  <div class="backend__content">
  <div class="backend__content__new">
        <?php
            $args = array(
                'posts_per_page' =>12,
                'meta_key' => 'post_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            );
            ?>
            	<?php
                  $popular_posts = new WP_Query( $args );
                  ?><?php 
                  while ( $popular_posts->have_posts() ) : $popular_posts->the_post();?>

                    <div class="backend__content__new__post">
                      <a href="<?php the_permalink(); ?>">
                       <?php if( has_post_thumbnail() ){
                         the_post_thumbnail('medium_large','url', array('class'=>''));}
                       ?>
                        <div class="backend__content__new__post__sumary">
                        <h3 class="title"><?php the_title();?></h3>
                        <p class="date"><?php echo get_the_date(); ?></p>
                        <p><?php the_excerpt(); ?></p>
                        
                        </a>
                <?php   ?>
                </div></div>
            <?php
                endwhile; 
                wp_reset_postdata();
          ?>
      </div>
                
  <div class="backend__content__sidebar">
  <h5>Lo más popular</h5>
      <?php
            $args = array(
                'posts_per_page' =>4,
                'meta_key' => 'post_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            );
            ?>
            	<?php
                  $popular_posts = new WP_Query( $args );
                  ?><?php 
                  while ( $popular_posts->have_posts() ) : $popular_posts->the_post();?>
                    <div class="backend__content__sidebar__post">
                      <a href="<?php the_permalink(); ?>">
                       <?php if( has_post_thumbnail() ){
                         the_post_thumbnail('medium','url','lazy', array('class'=>''));}
                       ?>
                       <div class="backend__content__sidebar__post__detail">
                       <h4 class="title"><?php the_title();?></h4>
                       <p><?php the_excerpt(); ?></p></a>
                </div>
            <?php
                endwhile; 
                wp_reset_postdata();
        ?>
      </div>
      </div>
  </div>
  </div>
  </section>



 


  



<?php get_footer(); ?>