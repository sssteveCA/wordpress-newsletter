<?php

namespace Newsletter\Interfaces;

interface Constants{

    //Log
    const FILE_LOG = 'log.txt';

    //Handles
    const H_CSS_ADMIN_FORM_ADD = 'nlAdminCssAdd';
    const H_JS_ADMIN_FORM_ADD = 'nlAdminJsAdd';
    const H_CSS_ADMIN_FORM_DELETE = 'nlAdminCssDelete';
    const H_JS_ADMIN_FORM_DELETE = 'nlAdminJsDelete';
    const H_CSS_ADMIN_FORM_SEND = 'nlAdminCssSend';
    const H_JS_ADMIN_FORM_SEND = 'nlAdminJsSend';
    const H_JS_AXIOS_LIB = 'nlAxiosLib';
    const H_CSS_BOOTSTRAP = 'nlBootstrapCss';
    const H_JS_BOOTSTRAP = 'nlBootstrapJs';
    const H_CSS_WP_FORM = 'nlNewsletterCss';
    const H_JS_WP_FORM = 'nlNewsletterJs';
    
    //Paths
    const REL_CSS_ADMIN_ADD = 'css/admin/nl_admin_add.css';
    const REL_CSS_ADMIN_DELETE = 'css/admin/nl_admin_delete.css';
    const REL_CSS_ADMIN_SEND = 'css/admin/nl_admin_send.css';
    const REL_CSS_BOOTSTRAP = 'node_modules/bootstrap/dist/css/bootstrap.min.css';
    const REL_CSS_WP = 'css/wp/nl_wp.css';
    const REL_JS_ADMIN_ADD = 'js/admin/nl_admin_add.js';
    const REL_JS_ADMIN_DELETE = 'js/admin/nl_admin_delete.js';
    const REL_JS_ADMIN_SEND = 'js/admin/nl_admin_send.js';
    const REL_JS_AXIOS_LIB = 'node_modules/axios/dist/axios.min.js';
    const REL_JS_BOOTSTRAP = 'node_modules/bootstrap/dist/js/bootstrap.min.js';
    const REL_JS_WP = 'js/wp/nl_wp.js';
    const TABLE_USERS = "newsletter_users";

    //Slugs
    const SLUG_ADMIN_FORM_ADD = 'nl_submenu_add';
    const SLUG_ADMIN_FORM_DELETE = 'nl_submenu_del';
    const SLUG_ADMIN_FORM_SEND = 'nl_submenu_send';
}
?>