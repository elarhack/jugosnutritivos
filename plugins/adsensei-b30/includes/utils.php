<?php

class AdSenseiUtils {

  private function __construct() {}

  public static function register_settings() {
    register_setting('adsenseib30_settings_group', 'adsenseib30_settings');
    register_setting('category_text_settings_group', 'category_text_settings');
    register_setting('home_text_settings_group', 'home_text_settings');
  }

  public static function getDonationBox() {
  echo '';
  }

  public static function getAuthorsSignature() {
    echo'
<style>
div.bottom-author {
  padding-top: 40px;
}
div.bottom-author > div.banners-container {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-template-rows: 1fr;
  gap: 0em 4em;
  grid-template-areas:
    ". . .";
  width: 100%;
}

div.bottom-author > div.banners-container > div.banner {
  width: 100%;
  display: inline;
  transition: 400ms linear all;
}

div.bottom-author > div.banners-container > div.banner:hover,
div.bottom-author > div.banners-container > div.banner:focus {
  padding-top: 15px;
  padding-bottom: 15px;
  -webkit-box-shadow: 0px 0px 11px 0px rgba(50, 50, 50, 0.75);
-moz-box-shadow:    0px 0px 11px 0px rgba(50, 50, 50, 0.75);
box-shadow:         0px 0px 11px 0px rgba(50, 50, 50, 0.75);
border-radius: 10px;
}

div.bottom-author > div.banners-container > div.banner > a {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

div.bottom-author > div.banners-container > div.banner > a > img {
  height: 83px;
}

div.bottom-author > div.banners-container > div.banner > a > span {
  display:block;
  width: 100%;
  text-align: center;
  margin-left: 0px!important;
  text-decoration: none!important;
}

div.bottom-author > p {
  color: #222;
  font-weight: bold;
  font-size: 1.5em;
  margin-bottom: 1.1em;
}

@media (max-width: 767px) {
  
  /* CSS */
  div.bottom-author > div.banners-container {
  grid-template-columns: 1fr;
  grid-template-rows: 1fr 1fr 1fr;
  grid-template-areas:
    "."
    "."
    ".";}

    div.bottom-author > div.banners-container > div.banner {
      width: 100%;
      display: inline;
      padding-bottom: 1.4em;
    }

    div.bottom-author > div.banners-container > div.banner > a > img {
      width: 80%;
      height: 120px;
    }

    div.bottom-author > div.banners-container > div.banner > a > div {
      width: 80%!important;
      height: 120px;
      font-size: 1.8em;
      line-height: 1.8em;
    }
    
    div.bottom-author > div.banners-container > div.banner > a > span {
      margin-top: 0.8em;
      font-size: 1.6em;
    }

    div.bottom-author > p {
      
    }
}
</style>
  <div class="bottom-author">
      <p style="color:#222">' . __('Creado con pasión y trabajo duro por:','adsensei-b30') . '</p>
      <div class="banners-container">
      <div class="banner">
        <a href="https://blogger3cero.com" target="_blank">
          <img width=200px src="' . plugins_url("assets/adsensei_new.jpg",__FILE__) .'"/>
          <span>Dean Romero</span>
          <br/>
        </a>
      </div>
      <div class="banner">
        <a href="https://mejorhombre.com" target="_blank" >
        <img width=200px src="' . plugins_url("assets/mejorhombre2.png",__FILE__) .'"/>
          <span>Jaime Sempere</span>
          </a>
      </div>
      <div class="banner">
      <a href="https://seomify.com" target="_blank">
          <img width=200px src="' . plugins_url("assets/seomify_com.png",__FILE__) .'"/>
          <span>Alberto Del Águila</span>
          <br/>
        </a>
      </div>
      </div>
    </div>';
  }
}

function log_me($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}
