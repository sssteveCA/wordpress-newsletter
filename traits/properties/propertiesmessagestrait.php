<?php

namespace Newsletter\Traits\Properties;

use Newsletter\Enums\Langs;
use Newsletter\Traits\Properties\Messages\ActivationMailTrait;
use Newsletter\Traits\Properties\Messages\NewUserTrait;
use Newsletter\Traits\Properties\Messages\OtherTrait;
use Newsletter\Traits\Properties\Messages\UnsubscribeTrait;
use Newsletter\Traits\Properties\Messages\VerifyTrait;

/**
 * Get messages methods for Properties class
 */
trait PropertiesMessagesTrait{

    use ActivationMailTrait, NewUserTrait, OtherTrait, UnsubscribeTrait, VerifyTrait;
}
?>