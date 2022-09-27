<?php

namespace Newsletter\Classes;

class Properties{

    /**
     * Get the site home url
     */
    public static function homeUrl(){ return home_url(); }

    /**
     * Get the site plugins url
     */
    public static function pluginsUrl(){ return plugins_url(); }
}

?>