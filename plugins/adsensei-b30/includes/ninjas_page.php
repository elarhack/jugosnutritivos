<?php

function adsenseib30_ninjas_page() {


ob_start(); ?>

<style>

}
</style>



  <div id="main_wrapper" class="items-container">
    <div class="logo" style="background-image: url('<?php echo plugins_url('assets/adsensei.png',__FILE__); ?>')">
    </div>
    <div class="card-grid-container">
      <div class="card">
        <img src="<?php echo plugins_url('assets/ninja1_.png',__FILE__); ?>">
        <h1><?php _e('Kabuza','adsensei-b30'); ?></h1>
        <p><?php _e('Rápido y eficaz. Coloca anuncios de Adsensei, Amazon o cualquier tipo de código HTML por toda tu web','adsensei-b30'); ?></p>
        <a class="blue" href="<?php echo admin_url('admin.php?page=adsensei-admin');?>">
          <?php _e('Coloca tus Anuncios','adsensei-b30'); ?>
        </a>
      </div>
      <div class="card">
        <img src="<?php echo plugins_url('assets/ninja2.png',__FILE__); ?>">
        <h1><?php _e('Hinaka', 'adsensei-b30'); ?></h1>
        <p><?php _e('Coloca texto en tu página Home a la vez que mantienes tus últimas entradas/posts. Haz una página optimizada para SEO','adsensei-b30'); ?></p>
        <a class="darkRed" href="<?php echo admin_url('admin.php?page=home-text');?>">
          <?php _e('Texto en Home', 'adsensei-b30'); ?>
        </a>
      </div>
      <div class="card">
        <img src="<?php echo plugins_url('assets/ninja3_.png',__FILE__); ?>" alt="Blogger 3.0">
        <h1><?php _e('Kabuto','adsensei-b30'); ?></h1>
        <p><?php _e('Coloca textos en tus categorías prar poder rankearlas con mayor facilidad en los buscadores','adsensei-b30'); ?></p>
        <a class="yellow" href="<?php echo admin_url('admin.php?page=category-text');?>">
          <?php _e('Texto en Categorías','adsensei-b30'); ?>
        </a>
      </div>
    </div>
  </div>

<?php AdSenseiUtils::getAuthorsSignature(); ?>


<?php

//php echo admin_url('admin.php?page=bsf-google-font-manager')
  echo ob_get_clean();
}

