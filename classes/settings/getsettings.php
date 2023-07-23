<?php

namespace Newsletter\Classes\Settings;

/**
 * This class fetch the settings from the DB and returns the proper HTML
 */
class GetSettings{

    private string $html = '';

    public function __construct(){

    }

    public function getHtml(){ return $this->html; }

}

?>