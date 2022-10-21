<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;

class General{

    /**
     * Get the language code if param is valid, otherwise return english language code
     * @param string|null $lang_param
     * @return string the language code
     */
    public static function languageCode(?string $lang_param): string{
        $langs = array_values(Langs::$langs);
        if(isset($lang_param) && in_array($lang_param,$langs))
            return $lang_param;
        else return Langs::$langs["en"];
    }
}
?>