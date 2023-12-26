<?php

namespace Newsletter\Interfaces;

interface Constants{

    //Log
    const FILE_LOG = 'log_newsletter.txt';

    //Handles
    const H_CSS_ADMIN_FORM_ADD = 'nlAdminCssAdd';
    const H_JS_ADMIN_FORM_ADD = 'nlAdminJsAdd';
    const H_CSS_ADMIN_FORM_DELETE = 'nlAdminCssDelete';
    const H_JS_ADMIN_FORM_DELETE = 'nlAdminJsDelete';
    const H_CSS_ADMIN_FORM_LOG = 'nlAdminCssLog';
    const H_JS_ADMIN_FORM_LOG = 'nlAdminJsLog';
    const H_CSS_ADMIN_FORM_SEND = 'nlAdminCssSend';
    const H_JS_ADMIN_FORM_SEND = 'nlAdminJsSend';
    const H_CSS_ADMIN_FORM_SETTINGS = 'nlAdminCssSettings';
    const H_JS_ADMIN_FORM_SETTINGS = 'nlAdminJsSettings';
    const H_JS_AXIOS_LIB = 'nlAxiosLib';
    const H_CSS_BOOTSTRAP = 'nlBootstrapCss';
    const H_JS_BOOTSTRAP = 'nlBootstrapJs';
    consT H_CSS_UNSUBSCRIBE = 'nlUnsubscribeCss';
    const H_JS_PREUNSUBSCRIBE = 'nlPreUnsubscribeJs';
    const H_CSS_WP_FORM = 'nlNewsletterCss';
    const H_JS_WP_FORM = 'nlNewsletterJs';

    const KEY_AJAX = 'ajax';
    const KEY_DATA = 'data';
    //Keys
    const KEY_DONE = 'done';
    const KEY_EMPTY = 'empty';
    const KEY_MESSAGE = 'msg';

    //Dir paths
    const REL_DIST_CSS = 'dist/css/';
    const REL_DIST_JS = 'dist/js/';
    
    //File paths
    const REL_CSS_ADMIN_ADD = Constants::REL_DIST_CSS.'admin/nl_admin_add.css';
    const REL_CSS_ADMIN_DELETE = Constants::REL_DIST_CSS.'admin/nl_admin_delete.css';
    const REL_CSS_ADMIN_LOG = Constants::REL_DIST_CSS.'admin/nl_admin_log.css';
    const REL_CSS_ADMIN_SEND = Constants::REL_DIST_CSS.'admin/nl_admin_send.css';
    const REL_CSS_ADMIN_SETTINGS = Constants::REL_DIST_CSS.'admin/nl_admin_settings.css';
    const REL_CSS_BOOTSTRAP = 'node_modules/bootstrap/dist/css/bootstrap.min.css';
    const REL_CSS_WP = Constants::REL_DIST_CSS.'wp/nl_wp.css';
    const REL_JS_ADMIN_ADD = Constants::REL_DIST_JS.'admin/nl_admin_add.js';
    const REL_JS_ADMIN_DELETE = Constants::REL_DIST_JS.'admin/nl_admin_delete.js';
    const REL_JS_ADMIN_LOG = Constants::REL_DIST_JS.'admin/nl_admin_log.js';
    const REL_JS_ADMIN_SEND = Constants::REL_DIST_JS.'admin/nl_admin_send.js';
    const REL_JS_ADMIN_SETTINGS = Constants::REL_DIST_JS.'admin/nl_admin_settings.js';
    //const REL_JS_AXIOS_LIB = 'node_modules/axios/dist/axios.min.js';
    const REL_JS_BOOTSTRAP = 'node_modules/bootstrap/dist/js/bootstrap.min.js';
    const REL_JS_PREUNSUBSCRIBE = Constants::REL_DIST_JS.'scripts/preunsubscribe.js';
    const REL_CSS_UNSUBSCRIBE = Constants::REL_DIST_CSS.'scripts/unsubscribe.css';
    const REL_JS_WP = Constants::REL_DIST_JS.'wp/nl_wp.js';

    const REL_NEWSLETTER_LOG = '/log_files/newsletter_status.log';

    const REL_TEMPLATE_PREUNSUBSCRIBE = 'scripts/browser/subscribe/preunsubscribe.php';
    const REL_TEMPLATE_UNSUBSCRIBE = 'scripts/browser/subscribe/unsubscribe.php';

    const TABLE_SETTINGS = "newsletter_settings";
    const TABLE_USERS = "newsletter_users";

    //Slugs
    const SLUG_ADMIN_FORM_ADD = 'nl_submenu_add';
    const SLUG_ADMIN_FORM_DELETE = 'nl_submenu_del';
    const SLUG_ADMIN_FORM_LOG = 'nl_submenu_log';
    const SLUG_ADMIN_FORM_SEND = 'nl_submenu_send';
    const SLUG_ADMIN_FORM_SETTINGS = 'nl_submenu_settings';
}
?>