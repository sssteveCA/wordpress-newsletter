<?php

namespace Newsletter\Classes;
use Newsletter\Enums\Langs;
use Newsletter\Traits\Properties\PropertiesMessagesTrait;
use Newsletter\Traits\Properties\PropertiesUrlTrait;
use Newsletter\Traits\Properties\PropertiesValesTrait;

class Properties{

    use PropertiesUrlTrait, PropertiesMessagesTrait, PropertiesValesTrait;
}

?>