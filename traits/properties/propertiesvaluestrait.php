<?php

namespace Newsletter\Traits\Properties;

/**
 * Values get methods for Properties class
 */
trait PropertiesValesTrait{

    /**
     * Get the newsletter name
     */
    public static function newsletterName(): string{
        return $_ENV['NEWSLETTER_NAME'];
    }

}
?>