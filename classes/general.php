<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;

class General{

    /**
     * Get the language code if param is valid, otherwise return english language code
     * @param string $lang_param
     * @return string the language code
     */
    public static function languageCode(string $lang_param): string{
        $langs_array = Langs::cases();
        if(isset($lang_param) && in_array($lang_param,$langs_array))
            return $lang_param;
        else return Langs::English->value;
    }
}
?>