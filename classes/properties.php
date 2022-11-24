<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;
use Newsletter\Traits\Properties\PropertiesMessagesTrait;
use Newsletter\Traits\Properties\PropertiesUrlTrait;

class Properties{

    use PropertiesUrlTrait, PropertiesMessagesTrait/* , PropertiesValuesTrait */;
}

?>