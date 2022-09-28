<?php

namespace Newsletter\Classes;

class Properties{

    /**
     * Get the site home URL
     */
    public static function homeUrl(){ return home_url(); }

    /**
     * Get the site plugins URL
     */
    public static function pluginsUrl(){ return plugins_url(); }

    /**
     * Get the current plugin home URL 
     */
    public static function pluginUrl(string $plugin){
        return plugin_dir_url($plugin);
    }

    /**
     * Get the string to be used in the frontend subscribe form
     */
    public static function subscribeFormStrings(): array{
        $strings = [];
        return $strings;
    }
}

?>