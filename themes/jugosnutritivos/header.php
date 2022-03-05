<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title( '-', true, 'right' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link class="favicon" rel="favicon" href="<?php bloginfo('template_url')?>/images/favicon.png" type="image/png">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<meta name="google-site-verification" content="ULQXSvNQKmKonyS19542NLsRYWgcXiiKw-N2UTZUwNU" />
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7951204980569782",
    enable_page_level_ads: true
  });
</script>
<meta property="fb:app_id" content="el id de tu aplicacion"/>
<?php if(is_single() || is_page()) { ?>
<meta property="og:image" content="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), large, false, '' ); echo $src[0]; ?>" />
<meta property="og:type" content="article" />
<meta property="og:description" content="<?php
while(have_posts()):the_post();
$out_excerpt = str_replace(array("", "", ""), "", get_the_excerpt());
echo apply_filters('the_excerpt_rss', $out_excerpt);
endwhile; ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:site_name" content="Jugos Nutritivos" />
<meta property="og:title" content="<?php the_title(); ?>" />

<?php } ?>




</head>
<?php wp_head();?>
<body>
<div class="sub-menu">
  <div class="wrapper">
	  
	   <?php if (!function_exists('dynamic_sidebar')|| !dynamic_sidebar('Search')): endif;?>
  </div>
</div>
<header class="header">
<div class="wrapper">
      <div class="header__content">
        <img class="header__logo" src="<?php bloginfo('template_url')?>/images/jugos-nutritivos.png" alt="" />
        <a class="logo-title" href="#">Jugos Nutritivos</a>
        
        <input type="checkbox" id="menu-btn" class="menu-btn">
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
        <?php wp_nav_menu(
          array(
              'container' => false,
              'items_wrap' => '<li class="menu-item"> %3$s </li>',
              'theme_location' => "top_menu"
          ));?>
        </ul>
      </div>
      </div>
  </header>
 