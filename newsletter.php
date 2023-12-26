<?php

use Newsletter\Classes\Database\Models\Settings as ModelsSettings;
use Newsletter\Classes\Database\Tables\Settings;
use Newsletter\Classes\Settings\GetSettings;
/**
 * Plugin Name: Newsletter
 * Description: This plugin allows send email to subscribers
 * Version: 1.0
 * Requires at least: 5.6
 * Requires PHP: 8.0
 * Author: Stefano Puggioni
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once(ABSPATH."wp-admin/includes/plugin.php");
require_once(ABSPATH."wp-admin/includes/upgrade.php");
require_once("vendor/autoload.php");

use Newsletter\Classes\Database\Tables\Users;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

 register_activation_hook(__FILE__,'nl_set_table');
 function nl_set_table(){
    $users = new Users(['tableName' => C::TABLE_USERS]);
    $create_users = $users->getSqlCreate();
    $settings = new Settings(['tableName' => C::TABLE_SETTINGS]);
    $create_settings = $settings->getSqlCreate();
    dbDelta([$create_users,$create_settings]);
    $settings_data = [
      'tableName' => C::TABLE_SETTINGS,
      'lang_status' => ["en" => false,"es" => false,"it" => false],
      'included_pages_status' => ["contacts_pages" => false,"cookie_policy_pages" => false,"privacy_policy_pages" => false,"terms_pages" => false],
      'socials_status' => ["facebook" => false,"instagram" => false,"youtube" => false],
      'social_pages' => ["facebook" => "","instagram" => "","youtube" => ""],
      'contact_pages' => ["en" => "","es" => "","it" => ""],
      'cookie_policy_pages' => ["en" => "","es" => "","it" => ""],
      'privacy_policy_pages' => ["en" => "","es" => "","it" => ""],
      'terms_pages' => ["en" => "","es" => "","it" => ""],
    ];
    $settings_mode = new \Newsletter\Classes\Database\Models\Settings($settings_data);
    $settings_mode->insertSettings();
 }

 register_uninstall_hook(__FILE__,'nl_delete_table');
 function nl_delete_table(){
    $users = new Users(['tableName' => C::TABLE_USERS]);
    $users->dropTable();
    $settings = new Settings(['tableName' => C::TABLE_SETTINGS]);
    $settings->dropTable();
 }

 add_action('admin_enqueue_scripts','nl_admin_scripts',11);
 function nl_admin_scripts(){
   //file_put_contents("log.txt","newsletter.php nl_admin_scripts request page =>".var_export($_REQUEST['page'],true)."\r\n",FILE_APPEND);
   if(isset($_REQUEST['page'])){
      $page = $_REQUEST['page'];
      if($page == C::SLUG_ADMIN_FORM_ADD || $page == C::SLUG_ADMIN_FORM_DELETE || $page == C::SLUG_ADMIN_FORM_SEND){
         wp_enqueue_script(C::H_JS_AXIOS_LIB);

         //Enqueue this files if you don't have Bootstrap in your Wordpress site
         /* wp_enqueue_style(C::H_CSS_BOOTSTRAP);
         wp_enqueue_script(C::H_JS_BOOTSTRAP); */
      }
      if($page == C::SLUG_ADMIN_FORM_ADD){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_ADD);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_ADD);
      }
      else if($page == C::SLUG_ADMIN_FORM_DELETE){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_DELETE);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_DELETE);
      }
      else if($page == C::SLUG_ADMIN_FORM_LOG){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_LOG);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_LOG);
      }
      else if($page == C::SLUG_ADMIN_FORM_SEND){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_SEND);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_SEND);
      }
      else if($page == C::SLUG_ADMIN_FORM_SETTINGS){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_SETTINGS);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_SETTINGS);
      }
   }//if(isset($_REQUEST['page'])){   
 }

 add_action('admin_menu','nl_menu');
 function nl_menu(){
    add_menu_page('Newsletter','Newsletter','administrator','nl_menu','','',1);
    add_submenu_page('nl_menu','Invia mail','Invia mail','administrator',C::SLUG_ADMIN_FORM_SEND,C::SLUG_ADMIN_FORM_SEND);
    add_submenu_page('nl_menu','Stato invio delle newsletter','Stato invio delle newsletter','administrator',C::SLUG_ADMIN_FORM_LOG,C::SLUG_ADMIN_FORM_LOG);
    add_submenu_page('nl_menu','Aggiungi utente','Aggiungi utente','administrator',C::SLUG_ADMIN_FORM_ADD,C::SLUG_ADMIN_FORM_ADD);
    add_submenu_page('nl_menu','Elimina iscritti','Elimina iscritti','administrator',C::SLUG_ADMIN_FORM_DELETE,C::SLUG_ADMIN_FORM_DELETE);
    add_submenu_page('nl_menu','Impostazioni','Impostazioni','administrator',C::SLUG_ADMIN_FORM_SETTINGS,C::SLUG_ADMIN_FORM_SETTINGS);
    remove_submenu_page('nl_menu','nl_menu');
 }

 
 function nl_submenu_add(){ echo HtmlCode::adminAddForm(); }
 function nl_submenu_del(){ echo HtmlCode::adminDelForm(); }
 function nl_submenu_log(){ echo HtmlCode::adminLogForm(); }
 function nl_submenu_send(){ echo HtmlCode::adminSenderForm(); }
 function nl_submenu_settings(){ 
   $getSettings = new GetSettings();
   echo $getSettings->getHtml();
 }

/*  add_action('init','nl_init');
 function nl_init(){} */

add_filter('http_request_timeout',function($timeout){
   return 15;
});

add_action('wp_enqueue_scripts','nl_libraries',11);
function nl_libraries(){
   //wp_enqueue_script(C::H_JS_AXIOS_LIB);
   //If there is a Bootstrap CSS file already enqueued, don't load
   if(wp_style_is('BootstrapCss')){
      wp_deregister_style('BootstrapCss');
      wp_dequeue_style('BootstrapCss');
   }
   //If there is a Bootstrap JS file already enqueued, don't load
   if(wp_script_is('BootstrapJs')){
      wp_deregister_script('BootstrapJs');
      wp_dequeue_script('BootstrapJs');
   }
   wp_enqueue_style(C::H_CSS_BOOTSTRAP);
   wp_enqueue_script(C::H_JS_BOOTSTRAP);
}

 add_action('wp_enqueue_scripts','nl_scripts',11);
function nl_scripts(){
    wp_enqueue_style(C::H_CSS_WP_FORM);
    wp_enqueue_script(C::H_JS_WP_FORM);
    if(is_page_template(C::REL_TEMPLATE_PREUNSUBSCRIBE)){
      wp_enqueue_script(C::H_JS_PREUNSUBSCRIBE);
    }

}

add_action('wp_footer','nl_form_signup');
function nl_form_signup(){
   $lang = Langs::$langs["en"];
   //Check if Polylang plugin is active
   if(is_plugin_active("polylang/polylang.php")){
      if(function_exists("pll_current_language")){
         $lang = pll_current_language(); //Get the current setted language with Polylang
         //file_put_contents(C::FILE_LOG,"newsletter.php nl_form_signup language => ".var_export($lang,true)."\r\n",FILE_APPEND);
      }
   }//if(is_plugin_active("polylang/polylang.php")){
   echo do_shortcode("[nl_subscribe lang=\"{$lang}\"]"); 
}

add_action('wp_loaded','nl_after_load');
function nl_after_load(){
   $plugin_dir = Properties::pluginUrl();
   /* $axiosJs = $plugin_dir.C::REL_JS_AXIOS_LIB;
   wp_register_script(C::H_JS_AXIOS_LIB,$axiosJs,[],null); */

   //Register this files if you don't have Bootstrap in your Wordpress site 
   $bootstrapCss = $plugin_dir.C::REL_CSS_BOOTSTRAP;
   $bootstrapJs = $plugin_dir.C::REL_JS_BOOTSTRAP;
   wp_register_style(C::H_CSS_BOOTSTRAP,$bootstrapCss,[],null);
   wp_register_script(C::H_JS_BOOTSTRAP,$bootstrapJs,[],null);
   if(is_admin()){
      if(isset($_REQUEST['page'])){
         $page = $_REQUEST['page'];
         if($page == C::SLUG_ADMIN_FORM_ADD){
            $adminCssAdd = $plugin_dir.C::REL_CSS_ADMIN_ADD;
            $adminJsAdd = $plugin_dir.C::REL_JS_ADMIN_ADD;
            wp_register_style(C::H_CSS_ADMIN_FORM_ADD,$adminCssAdd,[],null);
            wp_register_script(C::H_JS_ADMIN_FORM_ADD,$adminJsAdd,[],null,true);
         }
         else if($page == C::SLUG_ADMIN_FORM_DELETE){
            $adminCssDel = $plugin_dir.C::REL_CSS_ADMIN_DELETE;
            $adminJsDel = $plugin_dir.C::REL_JS_ADMIN_DELETE;
            wp_register_style(C::H_CSS_ADMIN_FORM_DELETE,$adminCssDel,[],null);
            wp_register_script(C::H_JS_ADMIN_FORM_DELETE,$adminJsDel,[],null,true);
         }
         else if($page == C::SLUG_ADMIN_FORM_LOG){
            $adminCssLog = $plugin_dir.C::REL_CSS_ADMIN_LOG;
            $adminJsLog = $plugin_dir.C::REL_JS_ADMIN_LOG;
            wp_register_style(C::H_CSS_ADMIN_FORM_LOG,$adminCssLog,[],null);
            wp_register_script(C::H_JS_ADMIN_FORM_LOG,$adminJsLog,[],null,true);
         }
         else if($page == C::SLUG_ADMIN_FORM_SEND){
            $adminCssSend = $plugin_dir.C::REL_CSS_ADMIN_SEND;
            $adminJsSend = $plugin_dir.C::REL_JS_ADMIN_SEND;
            wp_register_style(C::H_CSS_ADMIN_FORM_SEND,$adminCssSend,[],null);
            wp_register_script(C::H_JS_ADMIN_FORM_SEND,$adminJsSend,[],null,true);
         }
         else if($page == C::SLUG_ADMIN_FORM_SETTINGS){
            $adminCssSettings = $plugin_dir.C::REL_CSS_ADMIN_SETTINGS;
            $adminJsSettings = $plugin_dir.C::REL_JS_ADMIN_SETTINGS;
            wp_register_style(C::H_CSS_ADMIN_FORM_SETTINGS,$adminCssSettings,[],null);
            wp_register_script(C::H_JS_ADMIN_FORM_SETTINGS,$adminJsSettings,[],null,true);
         }
      }//if(isset($_REQUEST['page'])){
   }//if(is_admin()){
   else{
      $wpCss = $plugin_dir.C::REL_CSS_WP;
      $wpJs = $plugin_dir.C::REL_JS_WP;
      wp_register_style(C::H_CSS_WP_FORM,$wpCss,[],null);
      wp_register_script(C::H_JS_WP_FORM,$wpJs,[],null,true);
   }
   if(is_page_template(C::REL_TEMPLATE_PREUNSUBSCRIBE)){
      $preUnsubscribeJs = $plugin_dir.C::REL_JS_PREUNSUBSCRIBE;
      wp_register_script(C::H_JS_PREUNSUBSCRIBE,$preUnsubscribeJs,[],null,true);
   }

}

add_shortcode('nl_subscribe','nl_subscribe_form');
function nl_subscribe_form($atts){
   $a = shortcode_atts([
      'lang' => Langs::$langs["en"]
   ],$atts);
   $settings = new ModelsSettings(['tableName' => C::TABLE_SETTINGS]);
   $settings->getSettings();
   if($settings->getLangStatus()[$a['lang']]){
      $settingsParams = [
         'lang_status' => $settings->getLangStatus(),
         'included_pages_status' => $settings->getIncludedPagesStatus(),
         'cookie_policy_pages' => $settings->getCookiePolicyPages(),
         'privacy_policy_pages' => $settings->getPrivacyPolicyPages(),
         'terms_pages' => $settings->getTermsPages(),
      ];
      
   }//if($settings->getLangStatus()[$a['lang']]){
   else $settingsParams = [ 'lang_status' => $a['lang'] ];
   $langParams = HtmlCode::subscribeFormValues($a['lang'], $settingsParams);
   $formParams = [ 'lang' => $langParams, 'settings' => $settingsParams];
   return HtmlCode::wpSignupForm($formParams);
}

add_filter('script_loader_tag','nl_add_script_tags',10,3);
function nl_add_script_tags($tag, $handle, $src){
   switch($handle){
      case C::H_JS_WP_FORM:
      case C::H_JS_ADMIN_FORM_ADD:
      case C::H_JS_ADMIN_FORM_DELETE:
      case C::H_JS_ADMIN_FORM_LOG:
      case C::H_JS_ADMIN_FORM_SEND:
      case C::H_JS_ADMIN_FORM_SETTINGS:
      case C::H_JS_PREUNSUBSCRIBE:
         $tag = '<script type="module" src="'.esc_url($src).'"></script>';
         break;
      default:
         break;
   }
   return $tag;
}

?>