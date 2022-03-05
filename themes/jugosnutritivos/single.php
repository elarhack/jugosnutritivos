<?php get_header(); ?>
 
<section class="article">
    <div class="wrapper">
    <div class="article__content">
        <div class="article__content__post">

            <?php while (have_posts()): the_post(); ?>
            <?php if( has_post_thumbnail())
                {the_post_thumbnail('medium_large',array('class'=>''));} ?>
                <div class="article__content__post__detail">
                    <h1><?php the_title(); ?></h1>
                    <p class="date"><?php  the_time('F j Y'); ?></p>
                    <?php the_content(); ?><?php endwhile; wp_reset_query(); ?>
                </div>
        </div>
        <iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//rcm-eu.amazon-adsystem.com/e/cm?lt1=_blank&bc1=000000&IS2=1&bg1=FFFFFF&fc1=000000&lc1=0000FF&t=cuscoup-21&language=es_ES&o=30&p=8&l=as4&m=amazon&f=ifr&ref=as_ss_li_til&asins=B07PMJYLS6&linkId=d9c9fcef0b3d1bef4bd63a85846c8d85"></iframe>
		<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//rcm-eu.amazon-adsystem.com/e/cm?lt1=_blank&bc1=000000&IS2=1&bg1=FFFFFF&fc1=000000&lc1=0000FF&t=cuscoup-21&language=es_ES&o=30&p=8&l=as4&m=amazon&f=ifr&ref=as_ss_li_til&asins=B08344JPCZ&linkId=901af341f8d8b583ff113e7f8a1a645f"></iframe>
		<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//rcm-eu.amazon-adsystem.com/e/cm?lt1=_blank&bc1=000000&IS2=1&bg1=FFFFFF&fc1=000000&lc1=0000FF&t=cuscoup-21&language=es_ES&o=30&p=8&l=as4&m=amazon&f=ifr&ref=as_ss_li_til&asins=B07XD8814R&linkId=4ad1aa08c8ef8b152ef7e535ec9f695a"></iframe>
        
        <div class="article__content__sidebar">
            <h5>Jugos Nuevos</h5>
            <?php
            $args = array(
                'posts_per_page' => 6,
                'meta_key' => 'post_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            );
            ?>
            	<?php
                  $popular_posts = new WP_Query( $args );
                  ?><?php 
                  while ( $popular_posts->have_posts() ) : $popular_posts->the_post();?>
                    <div class="article__content__sidebar__post">
                      <a href="<?php the_permalink(); ?>">
                       <?php if( has_post_thumbnail() ){
                         the_post_thumbnail('medium','url', array('class'=>''));}
                       ?>
                       <div class="article__content__sidebar__post__detail">
                       <h3><?php the_title();?></h3>
                       <div class="date"><?php echo get_the_date(); ?></div>
                       <p><?php the_excerpt(); ?></p></a>
                </div>  
                </div>
                <?php
                endwhile; 
                wp_reset_postdata();
            ?>
        </div>
    </div>
    </div>
</section>


<?php get_footer(); ?>