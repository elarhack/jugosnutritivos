<?php

/*
  Plugin Name: AdSensei B30
  Plugin URI: http://blogger3cero.com/nuevo-adsensei-b30
  Description: Inserta de manera fácil, rápida y flexible anuncios de AdSense por todo tu blog
  Version: 1.9.9.9
  Author: <a href="https://blogger3cero.com/nuevo-adsensei-b30" target="_blank">Alberto Del Águila, Jaime Sempere, Dean Romero</a>
  Author2: <a href="https://seomify.com" target="_blank">Seomify,</a>
  License: GPLv2 or later
  Text Domain: adsensei-b30
  Domain Path: /languages
 */

/******************************
 * global variables
******************************/

class DeanSensei {
	/** Singleton *************************************************************/
	/**
	 */
	private static $instance;
  private static $shortcodes_being_used = array(false, false, false, false, false, false, false, false, false, false, false);
  private static $no_ads_shortcode = false;

  public $detect = null;

  public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new DeanSensei;
			self::$instance->includes();
			self::$instance->init();
		}
		return self::$instance;
	}

	private function includes() {
    include_once( dirname( __FILE__ ) . '/includes/libs/Mobile_Detect.php' );
		include_once( dirname( __FILE__ ) . '/includes/utils.php' );
		include_once( dirname( __FILE__ ) . '/TextInHome.php' );
		include_once( dirname( __FILE__ ) . '/CategoryText.php' );
		include_once( dirname( __FILE__ ) . '/includes/categories_text_admin.php' );
		include_once( dirname( __FILE__ ) . '/includes/adsb30_admin_page.php' );
		include_once( dirname( __FILE__ ) . '/includes/home_text_admin.php' );
		include_once( dirname( __FILE__ ) . '/includes/ninjas_page.php' );
	}

	/** Filters & Actions **/
	private function init() {

    $this->detect = new Mobile_Detect;

    add_action('admin_init', array($this, 'myPlugin_admin_scripts' ));
    add_action('admin_init', 'AdSenseiUtils::register_settings');
    add_action('admin_menu', array($this, 'admin_menu_function'));
    add_action('admin_enqueue_scripts', array($this, 'adsb30_load_scripts'));

    add_shortcode( 'sin_anuncios_b30', array($this,'do_nothing_shortcode'));
    add_shortcode( 'anuncio_b30', array($this,'show_add_shortcode'));
    add_filter('category_description', array($this,'addCategoryText'), 13);
    add_filter('the_content', array($this, 'core_method'), 10);
    add_action('plugins_loaded', array($this,'adsensei_init'), 8);
    //add_filter( 'load_textdomain_mofile', 'adsensei_load_textdomain', 10, 2); // adsensei-b30
    //Remueve las dos barras de la siguiente línea si en tu theme sale un título para las categorías
      //tipo "Categorías: blabla":
    //add_filter('get_the_archive_title','CategoryText::removeCategoryTitle') ;
    //add_action('plugins_loaded', array($this, 'wan_load_textdomain'));
    add_action( 'loop_start', 'TextInHome::outputText' );
    /*
    add_filter('tiny_mce_before_init', function($init) {
     // $init['wpautop'] = false;
      return $init;
    });
    */
    //avoiding remove of </p>:
    //remove_filter('the_content','wpautop');
    add_filter('extra_plugin_headers', array($this,  'add_extra_headers'));
    add_filter('plugin_row_meta', array($this, 'filter_authors_row_meta'), 1, 4);
  }

  public function adsensei_init() {
    load_plugin_textdomain('adsensei-b30', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
  }

  public function adsensei_load_textdomain( $mofile, $domain) 
  {
    if ( 'adsensei-b30' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
  }

  public function add_extra_headers(){
    return array('Author2');
  }
  
  public function filter_authors_row_meta($plugin_meta, $plugin_file, $plugin_data, $status ){
  
  if(empty($plugin_data['Author'])){
      return $plugin_meta;
  }
  
  
  if ( !empty( $plugin_data['Author2'] ) ) {
      $plugin_meta[1] = $plugin_meta[1] . ', ' . $plugin_data['Author2'];
  }
  
  
  return $plugin_meta;
  }

  public function addCategoryText($description) {

    if ( CategoryText::isCallFrom_All_in_One_SEO_Pack() ) {
      return $description;
    }
    return CategoryText::addCategoryText();
  }

  public function wan_load_textdomain() {
    load_plugin_textdomain( 'adsensei-b30', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
  }

  private function isMobile() {
    $result = $this->detect->isMobile();
    if(!$_SESSION['isMobile'])
    {
      $_SESSION['isMobile'] = $result;
    }
    return $result;
  }

  public function myPlugin_admin_scripts() {
      if (( isset($_GET['page']) && $_GET['page'] == 'adsensei-admin' )
      || ( isset($_GET['page']) && $_GET['page'] == 'category-text' )
      || ( isset($_GET['page']) && $_GET['page'] == 'home-text' )){
        wp_enqueue_script( 'jquery-form', array( 'jquery' ) );
      }
  }

  public function do_nothing_shortcode() {
      self::$no_ads_shortcode = true;
      return;
  }

  public function show_add_shortcode( $atts, $content ) {
      $ad_shortcode = shortcode_atts(array(
        'id' => 1
      ), $atts);

      $numberOfAd = ($ad_shortcode['id']);

      self::$shortcodes_being_used[$numberOfAd] = true;

      $adsenseib30_settings = get_option('adsenseib30_settings');

      //filter by device:
      $device = $adsenseib30_settings['adDevice'.$numberOfAd];
      if ($device == 'desktop') {if ($this->isMobile())  return ''; };
      if ($device == 'mobile') { if (!$this->isMobile()) return ''; };

      $myad = $adsenseib30_settings['adCode'.$numberOfAd];
      $myad = $this->wrap_ad_into_div($myad, $adsenseib30_settings, $numberOfAd);

      return $myad;
  }


  public function core_method($content) {

    if (has_shortcode($content, 'sin_anuncios_b30')) return $content;

    if (!(is_page() || (is_single()))) return $content;


    $content = preg_replace('/(<p.(!<)*?<span.*?id="more.*?<\\/p>)/U', '', $content,1);

    $adsenseib30_settings = get_option('adsenseib30_settings');
    $content = $this->load_all_ads( $content, $adsenseib30_settings);


    return $content." <style> ins.adsbygoogle { background: transparent !important; } </style>";
  }

  private function load_all_ads($content, $adsenseib30_settings){

    for ($numberOfAd = 1; $numberOfAd <= 10; $numberOfAd++) {
        if (self::$shortcodes_being_used[$numberOfAd] == false){
          $content = $this->addAdAfterParagraphOrAfterH2H3($content, $adsenseib30_settings, $numberOfAd);
        }
    }
    return $content;
  }

  private function addAdAfterParagraphOrAfterH2H3($content, $adsenseib30_settings, $numberOfAd){
    //filter by device:
    $device = $adsenseib30_settings['adDevice'.$numberOfAd];

    $categorySetting = $adsenseib30_settings['adCategory'.$numberOfAd];
    $currentCats = get_the_category();
    $categoryFilter = 'return';

    $showOn = $adsenseib30_settings['showOn'.$numberOfAd];
    /*
    if ($showOn == 'post_page_and_custom_post_type'){
      $categoryFilter = 'no return';
    }
    */

    if ($categorySetting!=null) {
      foreach($currentCats as $currentCat){
        if ($categorySetting == $currentCat->cat_ID) $categoryFilter = 'no return';
        if ($categorySetting == -1) $categoryFilter = 'no return';
      }
    }

    if (!is_page()){
      if ($categoryFilter == 'return') return $content;
    }

    if ($device == 'desktop') { if ($this->isMobile()) return $content; };
    if ($device == 'mobile') { if (!$this->isMobile()) return $content; };

    if ($showOn == 'shortcode') return $content;
    if ($showOn == 'posts') if (is_page()) return $content;
    if ($showOn == 'pages') if (is_single()) return $content;

    $enabled = $adsenseib30_settings['adEnabled'.$numberOfAd];
    if ($enabled == 'false') return $content;

    $myad = $adsenseib30_settings['adCode'.$numberOfAd];
    if (strlen(trim($myad)) == 0) return $content;

    $myad = $this->wrap_ad_into_div($myad, $adsenseib30_settings, $numberOfAd);

    $adPosition = $adsenseib30_settings['adPosition'.$numberOfAd];

    if (strpos($adPosition, 'H') === false) {
      return $this->addAdAfterParagraph($content, $myad, $adPosition);
    }
    else {
      return $this->replaceH2H3($content, $myad, $adPosition);
    }
  }

  private function replaceH2H3($content, $myad, $adPosition){

    if (strpos($adPosition, 'first') !== false) $realAdPosition = 1;
    if (strpos($adPosition, 'second') !== false) $realAdPosition = 2;
    if (strpos($adPosition, 'third') !== false) $realAdPosition = 3;

    if (strpos($adPosition, 'H2') !== false) {
      return preg_replace('/(<h2.*<\\/h2>.*){'.$realAdPosition.'}/Us', '${0}'.$myad, $content,1);
    }
    if (strpos($adPosition, 'H3') !== false) {
      return preg_replace('/(<h3.*<\\/h3>.*){'.$realAdPosition.'}/Us', '${0}'.$myad, $content,1);
    }
    return $content;
  }

  private function addAdAfterParagraph($content, $myad, $adPosition){

-   $paragraphs = preg_match_all('/<p.*<\\/p>.*/isU', $content, $output_array);

    $realAdPosition = $this->get_real_ad_position($adPosition, ($paragraphs));
    return preg_replace('/(<p.*<\\/p>.*){'.$realAdPosition.'}/sU', '${0}'.$myad, $content,1);

    return $content;
  }


  private function wrap_ad_into_div($myad, $adsenseib30_settings, $numberOfAd){
    $margin = $adsenseib30_settings['adMargin'.$numberOfAd];
    $align = $adsenseib30_settings['adAlign'.$numberOfAd];
    $overflowx = '';
    if (($align == 'wrapleft') ){
        return '<div class="adsb30" style="'.$overflowx.' margin:'.$margin.'px; margin-left:0px; float:left">'.$myad.'</div>';
    }
    if (($align == 'left')){
        return '<div class="adsb30" style="'.$overflowx.' margin:'.$margin.'px; margin-left:0px; text-align:left">'.$myad.'</div>';
    }
    if (($align == 'wrapright')){
        return '<div class="adsb30" style="'.$overflowx.' margin:'.$margin.'px; margin-right:0px; float:right">'.$myad.'</div>';
    }
    if (($align == 'right')){
        return '<div class="adsb30" style="'.$overflowx.' margin:'.$margin.'px; margin-right:0px; text-align:right">'.$myad.'</div>';
    }
    return '<div class="adsb30" style="'.$overflowx.' margin:'.$margin.'px; text-align:'.$align.'">'.$myad.'</div>';
  }

  private function get_real_ad_position($ad1Position, $paragrahpsNum){
    if ($ad1Position == 'beginning') return 0;
    if ($ad1Position == 'middle') return ((floor($paragrahpsNum/2)));
    if ($ad1Position == 'end') return $paragrahpsNum;
    if ($ad1Position == 'before end') return ($paragrahpsNum - 1);
    if ($ad1Position > $paragrahpsNum) return $paragrahpsNum;
    return $ad1Position;
  }

  public function adsb30_load_scripts($hook) {
    if($this->isAdminPage($hook)) {
      wp_enqueue_style( 'dashicons' );
      wp_enqueue_style('adsb30-admin-styles', plugin_dir_url( __FILE__ ) . 'includes/css/adsB30AdminPanel.css');
      wp_enqueue_style('adsb30-new-admin-styles', plugin_dir_url( __FILE__ ) . 'includes/css/adsB30NewAdminPanel.css');
      wp_enqueue_script('adsb30-admin-scripts', plugin_dir_url( __FILE__ ) . 'includes/js/admin_javascript.js');
      wp_localize_script('adsb30-admin-scripts', 'objectL10n', array(
        'newAdName' => __('Introduce un nuevo nombre para este anuncio','adsensei-b30'),
      ));
    }
  }
  public function isAdminPage($hook){
    if ($hook == 'toplevel_page_ninjas-admin') return true;
    if ($hook == 'adsenseib30_page_adsensei-admin') return true;
    if ($hook == 'adsenseib30_page_home-text') return true;
    if ($hook == 'adsenseib30_page_category-text') return true;
    return false;
  }

  public function admin_menu_function(){
    add_menu_page ( 'AdSenseiB30', 'AdSenseiB30', 'edit_pages', 'ninjas-admin', 'adsenseib30_ninjas_page',plugins_url('includes/assets/logo-icon-gris.png',__FILE__));
    add_submenu_page ( 'ninjas-admin', __('Inicio','adsensei-b30'), __('Inicio','adsensei-b30'), 'edit_pages', 'ninjas-admin', 'adsenseib30_ninjas_page');
    add_submenu_page ( 'ninjas-admin', __('Adsense/Contenido entre parrafos','adsensei-b30'), __('Coloca tus Anuncios','adsensei-b30'), 'edit_pages', 'adsensei-admin', 'adsenseib30_settings_page');
    add_submenu_page ( 'ninjas-admin', __('Texto en Home','adsensei-b30'), __('Texto en Home','adsensei-b30'), 'edit_pages', 'home-text', 'adsb30_home_text_settings_page');
    add_submenu_page ( 'ninjas-admin', __('Texto en Categorías','adsensei-b30'), __('Texto en Categorías','adsensei-b30'), 'edit_pages', 'category-text', 'adsb30_categories_text_settings_page');
  }

}


/** SINGLETON INVOCATION **/
function adSensei_load() {
	return DeanSensei::instance();
}

adSensei_load();

