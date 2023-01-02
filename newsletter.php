<?php
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
 require_once("enums/languages.php");
 require_once("interfaces/constants.php");
 require_once("interfaces/exceptionmessages.php");
 require_once("exceptions/notsettedexception.php");
 require_once("exceptions/incorrectvariableformatexception.php");
 require_once("traits/properties/messages/activationmailtrait.php");
 require_once("traits/properties/messages/newusertrait.php");
 require_once("traits/properties/messages/othertrait.php");
 require_once("traits/properties/messages/unsubscribetrait.php");
 require_once("traits/properties/messages/verifytrait.php");
 require_once("traits/properties/propertiesmessagestrait.php");
 require_once("traits/properties/propertiesurltrait.php");
 require_once("traits/errortrait.php");
 require_once("traits/sqltrait.php");
 require_once("classes/properties.php");
 require_once("classes/htmlcode.php");
 require_once("classes/database/tables/table.php");
 require_once("classes/database/tables/users.php");

 use Newsletter\Classes\Database\Tables\Users;
 use Newsletter\Interfaces\Constants as C;
 use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

 register_activation_hook(__FILE__,'nl_set_table');
 function nl_set_table(){
    $data = ['tableName' => C::TABLE_USERS];
    $users = new Users($data);
    $create = $users->getSqlCreate();
    dbDelta($create);
 }

 register_uninstall_hook(__FILE__,'nl_delete_table');
 function nl_delete_table(){
    $data = ['tableName' => C::TABLE_USERS];
    $users = new Users($data);
    $users->dropTable();
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
      else if($page == C::SLUG_ADMIN_FORM_SEND){
         wp_enqueue_style(C::H_CSS_ADMIN_FORM_SEND);
         wp_enqueue_script(C::H_JS_ADMIN_FORM_SEND);
      }
   }//if(isset($_REQUEST['page'])){   
 }

 add_action('admin_menu','nl_menu');
 function nl_menu(){
    add_menu_page('Newsletter','Newsletter','administrator','nl_menu','','',1);
    add_submenu_page('nl_menu','Invia mail','Invia mail','administrator',C::SLUG_ADMIN_FORM_SEND,C::SLUG_ADMIN_FORM_SEND);
    add_submenu_page('nl_menu','Aggiungi utente','Aggiungi utente','administrator',C::SLUG_ADMIN_FORM_ADD,C::SLUG_ADMIN_FORM_ADD);
    add_submenu_page('nl_menu','Elimina iscritti','Elimina iscritti','administrator',C::SLUG_ADMIN_FORM_DELETE,C::SLUG_ADMIN_FORM_DELETE);
    remove_submenu_page('nl_menu','nl_menu');
 }

 
 function nl_submenu_add(){
      $addHtml = HtmlCode::adminAddForm();
      echo $addHtml;
 }

 function nl_submenu_del(){
    $delHtml = HtmlCode::adminDelForm();
    echo $delHtml;
 }

 function nl_submenu_send(){
    $sendHtml = HtmlCode::adminSenderForm();
    echo $sendHtml;
 }

 add_action('init','nl_init');
 function nl_init(){

 }

add_action('wp_enqueue_scripts','nl_libraries');
function nl_libraries(){
   wp_enqueue_script(C::H_JS_AXIOS_LIB);
}

 add_action('wp_enqueue_scripts','nl_scripts',11);
function nl_scripts(){
    wp_enqueue_style(C::H_CSS_WP_FORM);
    wp_enqueue_script(C::H_JS_WP_FORM);
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
   $plugin_dir = Properties::pluginUrl(__FILE__);
   $axiosJs = $plugin_dir.C::REL_JS_AXIOS_LIB;
   wp_register_script(C::H_JS_AXIOS_LIB,$axiosJs,[],null);

   //Register this files if you don't have Bootstrap in your Wordpress site 
   /* $bootstrapCss = $plugin_dir.C::REL_CSS_BOOTSTRAP;
   $bootstrapJs = $plugin_dir.C::REL_JS_BOOTSTRAP;
   wp_register_style(C::H_CSS_BOOTSTRAP,$bootstrapCss,[],null);
   wp_register_script(C::H_JS_BOOTSTRAP,$bootstrapJs,[],null); */

   if(is_admin()){
      $adminCssAdd = $plugin_dir.C::REL_CSS_ADMIN_ADD;
      $adminJsAdd = $plugin_dir.C::REL_JS_ADMIN_ADD;
      $adminCssDel = $plugin_dir.C::REL_CSS_ADMIN_DELETE;
      $adminJsDel = $plugin_dir.C::REL_JS_ADMIN_DELETE;
      $adminCssSend = $plugin_dir.C::REL_CSS_ADMIN_SEND;
      $adminJsSend = $plugin_dir.C::REL_JS_ADMIN_SEND;
      wp_register_style(C::H_CSS_ADMIN_FORM_ADD,$adminCssAdd,[],null);
      wp_register_script(C::H_JS_ADMIN_FORM_ADD,$adminJsAdd,[],null,true);
      wp_register_style(C::H_CSS_ADMIN_FORM_DELETE,$adminCssDel,[],null);
      wp_register_script(C::H_JS_ADMIN_FORM_DELETE,$adminJsDel,[],null,true);
      wp_register_style(C::H_CSS_ADMIN_FORM_SEND,$adminCssSend,[],null);
      wp_register_script(C::H_JS_ADMIN_FORM_SEND,$adminJsSend,[],null,true);
   }//if(is_admin()){
   else{
      $wpCss = $plugin_dir.C::REL_CSS_WP;
      $wpJs = $plugin_dir.C::REL_JS_WP;
      wp_register_style(C::H_CSS_WP_FORM,$wpCss,[],null);
      wp_register_script(C::H_JS_WP_FORM,$wpJs,[],null,true);
   }

}

add_shortcode('nl_subscribe','nl_subscribe_form');
function nl_subscribe_form($atts){
   $a = shortcode_atts([
      'lang' => Langs::$langs["en"]
   ],$atts);
   $langParams = HtmlCode::subscribeFormValues($a['lang']);
   return HtmlCode::wpSignupForm($langParams);
}

add_filter('script_loader_tag','nl_add_script_tags',10,3);
function nl_add_script_tags($tag, $handle, $src){
   switch($handle){
      case C::H_JS_WP_FORM:
      case C::H_JS_ADMIN_FORM_ADD:
      case C::H_JS_ADMIN_FORM_DELETE:
      case C::H_JS_ADMIN_FORM_SEND:
         $tag = '<script type="module" src="'.esc_url($src).'"></script>';
         break;
      default:
         break;
   }
   return $tag;
}

?>