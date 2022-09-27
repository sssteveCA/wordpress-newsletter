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

 register_activation_hook(__FILE__,'nl_set_table');
 function bnl_set_table(){
    global $wpdb;
    
 }
?>