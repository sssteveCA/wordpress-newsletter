<?php
/**
 * Plugin Name: Newsletter
 * Description: This plugin allows send email to subscribers
 * Version: 1.0
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Author: Stefano Puggioni
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

 require_once(ABSPATH."wp-admin/includes/upgrade.php");
 require_once("classes/properties.php");

 use Newsletter\Classes\Database\Tables\Users;
 use Newsletter\Interfaces\Constants as C;
 use Newsletter\Classes\Properties as Pr;
 use Newsletter\Classes\HtmlCode;

 register_activation_hook(__FILE__,'nl_set_table');
 function bnl_set_table(){
    $data = ['name' => C::TABLE_USERS];
    $users = new Users($data);
    $create = $users->getSqlCreate();
    dbDelta($create);
 }

 register_uninstall_hook(__FILE__,'nl_delete_table');
 function nl_delete_table(){
    $data = ['name' => C::TABLE_USERS];
    $users = new Users($data);
    $users->dropTable();
 }

 add_action('admin_enqueue_scripts','nl_admin_scripts',11);
 function nl_admin_scripts(){
    $plugin_dir = Pr::pluginUrl(__FILE__);
    $adminCss = $plugin_dir.C::REL_CSS_ADMIN;
    wp_enqueue_style('nlAdminCss',$adminCss,[],null);
    $adminJs = $plugin_dir.C::REL_JS_ADMIN;
    wp_enqueue_script('nlAdminJs',$adminJs,[],null);
 }

 add_action('admin_menu','nl_menu');
 function nl_menu(){
    add_menu_page('Newsletter','Newsletter','administrator','nl_menu','','',1);
    add_submenu_page('nl_menu','Invia mail','Invia mail','administrator','nl_submenu_send','nl_submenu_send');
    add_submenu_page('nl_menu','Aggiungi utente','Aggiungi utente','administrator','nl_submenu_add','nl_submenu_add');
    add_submenu_page('nl_menu','Elimina iscritti','Elimina iscritti','administrator','nl_submenu_del','nl_submenu_del');
    remove_submenu_page('nl_menu','nl_menu');
 }

 /**
  * Admin delete users menu item output
  */
 function nl_submenu_del(){
    $delHtml = HtmlCode::adminDelForm();
    echo $delHtml;
 }

 /**
  * Admin email sender menu item output
  */
 function nl_submenu_send(){
    $sendHtml = HtmlCode::adminSenderForm();
    echo $sendHtml;
 }
?>