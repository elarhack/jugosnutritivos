<?php


function adsb30_categories_text_settings_page() {

	global $category_text_settings;

	ob_start(); ?>
<div class="top-banner" style="padding-top: 2em !important;">
<img class="ninja" style="width:50px!important" src="<?php echo plugins_url('assets/ninja3_.png',__FILE__); ?>" alt="">
      <div>
         <h2>
            <?php _e('KABUTO','adsensei-b30'); ?>
         </h2>
         <h4>
            <?php _e('Texto en tus categorías a golpe de katana','adsensei-b30'); ?>
         </h4>
      </div>
</div>
<div class="wrap rm_wrap m160" style="width:100%!important;">
  <div class="rm_opts">
    <form id="adsenseib30_form2" method="post" action="options.php">
        <?php settings_fields('category_text_settings_group'); ?>

          <?php
          $categories = get_categories(array('hide_empty' => false));
          //$catIds = array_map(create_function('$o', 'return $o->cat_ID;'), $categories);
          $catIds = array_map(function($o){return $o->cat_ID;}, $categories);
          $catNames = array_map(function($o){return $o->name;}, $categories);

          $i=0;
          foreach($catIds as $catId) {
            adsenseib30_get_tab2($i, $catIds[$i], $catNames[$i]);
            $i++;
          }
          ?>

      </form>
      <div class="saveResult"></div>
  </div>
</div>

<?php

    AdSenseiUtils::getDonationBox();
    AdSenseiUtils::getAuthorsSignature();
  ?>

<script type="text/javascript">
  jQuery(document).ready(function() {
     jQuery('#adsenseib30_form2').submit(function() {

         jQuery(this).find("textarea").each(
           function( index ) {
             textareaId = jQuery(this).attr("id");
             jQuery(this).html(adbs30_get_tinymce_content(index, textareaId))
         });

           jQuery(this).ajaxSubmit({
             success: function(){
                jQuery('.saveResult').html("<div class='saveMessage successModal'></div>");
                jQuery('.saveMessage').append("<p><?php echo htmlentities(__('Todos los ajustes han sido guardados','adsensei-b30'),ENT_QUOTES); ?></p>").slideDown(250);
             },
             error: function(){
               debugger;
             },
             timeout: 3200
          });
          setTimeout("jQuery('.saveMessage').fadeOut(400);", 3200);
          return false;
       })
  });

  function adbs30_get_tinymce_content(index, textareaId){
    if (jQuery("#wp-"+textareaId+"-wrap").hasClass("tmce-active")){
        return tinyMCE.editors[index].getContent();
    } else {
        return jQuery(jQuery('textarea')[index]).val()
    }
  }

</script>

	<?php echo ob_get_clean(); }

function adsenseib30_get_tab2($numAd, $catIds, $catNames){

      $category_text_settings = get_option('category_text_settings');

      $category = $category_text_settings['adCategory'];
      $category_text_id = "category_text_settings[".$catNames."]";
      $category_text = $category_text_settings[$catNames];

      $categoryValues = $catIds;
      $categoryDisplayvalues = $catNames;

      ob_start(); ?>

      <div class="rm_title yellow" style="margin-top:10px">
        <h3>
          <span><?php _e('Categoría','adsensei-b30'); ?> <?php echo $catNames ?></span>
        </h3>
      </div>

      <?php wp_editor( $category_text, "e".$catIds, array( 'textarea_id' => $category_text_id, 'textarea_name' => $category_text_id, 'textarea_rows' => 20) ); ?>

        <p class="submit">
          <input type="submit" class="button -yellow" value="<?php _e('Guardar opciones', 'adsensei-b30'); ?>" />
          <div class="saveResult"></div>
        </p>
	    <?php
	    echo ob_get_clean();
  }
