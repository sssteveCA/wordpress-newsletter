<?php

namespace Newsletter\Interfaces;

interface Constants{

    //Log
    const FILE_LOG = 'log.txt';
    
    //Paths
    const REL_CSS_ADMIN_ADD = 'css/admin/nl_admin_add.css';
    const REL_CSS_ADMIN_DELETE = 'css/admin/nl_admin_delete.css';
    const REL_CSS_ADMIN_SEND = 'css/admin/nl_admin_send.css';
    const REL_CSS_WP = 'css/wp/nl_wp.css';
    const REL_JS_ADMIN_ADD = 'js/admin/nl_admin_add.js';
    const REL_JS_ADMIN_DELETE = 'js/admin/nl_admin_delete.js';
    const REL_JS_ADMIN_SEND = 'js/admin/nl_admin_send.js';
    const REL_JS_WP = 'js/admin/nl_wp.js';
    const TABLE_USERS = "newsletter_users";
}
?>